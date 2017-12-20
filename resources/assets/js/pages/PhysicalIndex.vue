<template>
    <div class="container mx-auto">
        <div class="parcel-index">
            <div class="parcel-menu" @touchmove="touch">
                <a href="/physicals/packages">套餐体检</a>
                <a class="on" href="/physicals/single">单列体检</a>
            </div>
            <div class="parcel-date" @touchmove="touch">{{ date }}</div>
            <div class="parcel-contact">
                <scroll class="parcel-channel warpper" :data="departments">
                    <div class="content">
                        <li v-for="(department, index) in departments" :key="index" @click="changeChannel(department.slug)">{{ department.name }}</li>
                    </div>
                </scroll>
                <scroll class="parcel-food wrapper" :data="departments">
                    <div class="content">
                        <div class="parcel-food-channel" v-for="(department, department_index) in departments" :key="department_index">
                            <div class="parcel-food-title" :id="department.slug"><strong>{{ department.name }}</strong>{{ department.describe }}</div>
                            <div class="parcel-food-contact" 
                                @click="detail(department_index, physical_index)" 
                                v-for="(physical, physical_index) in department.physical" 
                                :key="physical_index">
                                <img :src="physical.image" alt="">
                                <div class="parcel-food-desc">
                                    <h4>{{ physical.title }}</h4>
                                    <p>{{ physical.desc }}</p>
                                    <div class="parcel-food-footer">
                                        <span>￥ {{ physical.money }}</span>
                                        <div class="parcel-food-options">
                                            <img v-if="physical.num > 0" class="reduce" src="/images/reduce.png" @click.stop="reduce(department_index, physical_index)" alt="">
                                            <span v-if="physical.num > 0">{{ physical.num }}</span>
                                            <img class="plus" src="/images/plus.png" @click.stop="plus(department_index, physical_index)" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </scroll>
            </div>
            <div class="parcel-footer container" @touchmove="touch">
                <div class="parcel-cart">
                    <div class="parcel-cart-img" :data-count="count" @click="cart = true">
                        <img src="/images/cart.png" alt="">
                    </div>
                    <span>￥ {{ money }}</span>
                </div>
                <button type="button" @click="settle">去结算</button>
            </div>
        </div>
        <div class="parcel-detail" v-show="show" @click="show = false" @touchmove="touch">
            <div class="food-detail" @click.stop="">
                <img class="food-close" src="" alt="">
                <img class="food-image" :src="physical.image" alt="">
                <h4>{{ physical.title }}</h4>
                <p>{{ physical.desc }}</p>
                <div class="food-footer">
                    <span>￥ {{ physical.money }}</span>
                    <button type="button" @click.stop="plus(department_index, physical_index)">加入购物车</button>
                </div>
            </div>
        </div>
        <div class="cart" v-show="cart" @click="cart = false" @touchmove="touch">
            <div class="cart-detail" @click.stop="">
                <div class="cart-top">
                    <h4>购物车</h4>
                    <span @click="clear">
                        <img src="/images/delete.png" alt="">
                        清空
                    </span>
                </div>
                <div v-for="(department, department_index) in departments" :key="department_index">
                    <div class="cart-food-item" 
                        v-for="(physical, physical_index) in department.physical" 
                        :key="physical_index"
                        v-if="physical.num > 0">
                        <h4>{{ physical.title }}</h4>
                        <span>￥ {{ physical.money }}</span>
                        <div class="cart-food-options">
                            <img v-if="physical.num > 0" class="reduce" src="/images/reduce.png" @click.stop="reduce(department_index, physical_index)" alt="">
                            <span v-if="physical.num > 0">{{ physical.num }}</span>
                            <img class="plus" src="/images/plus.png" @click.stop="plus(department_index, physical_index)" alt="">
                        </div>
                    </div>
                </div>
                <div class="cart-bottom">
                    已选餐品
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import scroll from '../components/Scroll.vue';
import BScroll from 'better-scroll';
export default {
    props: ['attributes'],
    data () {
        return {
            departments: this.attributes,
            date: moment().format('L'),
            count: 0,
            money: 0,
            show: false,
            cart: false,
            physical: {},
            department_index: '',
            physical_index: '',
            menu: 'am',
            physicals: []
        }
    },
    components: {
        scroll
    },
    created () {

    },
    methods: {
        changeChannel(slug) {
            this.$children[1].scrollToElement('#' + slug, 1000);
        },
        plus(department, physical) {
            if (this.departments[department].physical[physical].num == 1) {
                this.show = false;
                return ;
            }
            this.departments[department].physical[physical].num ++;
            this.money = this.money + this.departments[department].physical[physical].money;
            this.count ++;
            this.show = false;
        },
        reduce(department, physical) {
            this.departments[department].physical[physical].num --;
            this.money = this.money - this.departments[department].physical[physical].money;
            this.count --;
            this.show = false;
        },
        detail(department, physical) {
            this.physical = this.departments[department].physical[physical];
            this.department_index = department;
            this.physical_index = physical;
            this.show = true;
        },
        touch() {
            event.preventDefault();
        },
        clear() {
            this.departments.map((department, department_index) => {
                department.physical.map((physical, physical_index) => {
                    physical.num = 0;
                })
            })
            this.count = 0;
            this.money = 0;
            this.cart = false;
        },
        settle() {
            this.physicals = [];
            this.departments.map((department, department_index) => {
                department.physical.map((physical, physical_index) => {
                    if (physical.num > 0) {
                        this.physicals.push(physical);
                    }
                })
            });
            axios.post('/orders', {
                    order_details: this.physicals,
                    order_details_type: 'App\\Models\\Physical'
                })
                .then(response => {
                    console.log(response);
                    window.location.href = `/orders/${response.data.data.id}`;
                })
                .catch(error => {
                    if (error.response.status === 400) {
                        this.$alert(error.response.data.data);
                        return ;
                    }
                    console.log(error.response);
                })
        }
    }
}
</script>
