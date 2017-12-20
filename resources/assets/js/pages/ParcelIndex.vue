<template>
    <div class="container mx-auto">
        <div class="parcel-index">
            <div class="parcel-menu" @touchmove="touch">
                <a :class="menu == 'am' ? 'on' : ''" @click="changeMenu('am')">午餐</a>
                <a :class="menu == 'pm' ? 'on' : ''" @click="changeMenu('pm')">晚餐</a>
            </div>
            <div class="parcel-date" @touchmove="touch">{{ date }}</div>
            <div class="parcel-contact">
                <scroll class="parcel-channel warpper" :data="channels">
                    <div class="content">
                        <li v-for="(channel, index) in channels" :key="index" @click="changeChannel(channel.slug)">{{ channel.name }}</li>
                    </div>
                </scroll>
                <scroll class="parcel-food wrapper" :data="channels">
                    <div class="content">
                        <div class="parcel-food-channel" v-for="(channel, channel_index) in channels" :key="channel_index">
                            <div class="parcel-food-title" :id="channel.slug"><strong>{{ channel.name }}</strong>{{ channel.describe }}</div>
                            <div class="parcel-food-contact" 
                                @click="detail(channel_index, food_index)" 
                                v-for="(food, food_index) in channel.food" 
                                v-if="food.type == menu || food.type == 'all'"
                                :key="food_index">
                                <img :src="food.image" alt="">
                                <div class="parcel-food-desc">
                                    <h4>{{ food.title }}</h4>
                                    <p>{{ food.desc }}</p>
                                    <div class="parcel-food-footer">
                                        <span>￥ {{ food.money }}</span>
                                        <div class="parcel-food-options">
                                            <img v-if="food.num > 0" class="reduce" src="/images/reduce.png" @click.stop="reduce(channel_index, food_index)" alt="">
                                            <span v-if="food.num > 0">{{ food.num }}</span>
                                            <img class="plus" src="/images/plus.png" @click.stop="plus(channel_index, food_index)" alt="">
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
                <img class="food-image" :src="food.image" alt="">
                <h4>{{ food.title }}</h4>
                <p>{{ food.desc }}</p>
                <div class="food-footer">
                    <span>￥ {{ food.money }}</span>
                    <button type="button" @click.stop="plus(channel_index, food_index)">加入购物车</button>
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
                <div v-for="(channel, channel_index) in channels" :key="channel_index">
                    <div class="cart-food-item" 
                        v-for="(food, food_index) in channel.food" 
                        :key="food_index" 
                        v-if="food.num > 0 && (food.type == menu || food.type == 'all')">
                        <h4>{{ food.title }}</h4>
                        <span>￥ {{ food.money }}</span>
                        <div class="cart-food-options">
                            <img v-if="food.num > 0" class="reduce" src="/images/reduce.png" @click.stop="reduce(channel_index, food_index)" alt="">
                            <span v-if="food.num > 0">{{ food.num }}</span>
                            <img class="plus" src="/images/plus.png" @click.stop="plus(channel_index, food_index)" alt="">
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
            channels: this.attributes,
            date: moment().format('L'),
            count: 0,
            money: 0,
            show: false,
            cart: false,
            food: {},
            channel_index: '',
            food_index: '',
            menu: 'am',
            foods: []
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
        plus(channel, food) {
            this.channels[channel].food[food].num ++;
            this.money = this.money + this.channels[channel].food[food].money;
            this.count ++;
            this.show = false;
        },
        reduce(channel, food) {
            this.channels[channel].food[food].num --;
            this.money = this.money - this.channels[channel].food[food].money;
            this.count --;
            this.show = false;
        },
        detail(channel, food) {
            this.food = this.channels[channel].food[food];
            this.channel_index = channel;
            this.food_index = food;
            this.show = true;
        },
        touch() {
            event.preventDefault();
        }, 
        changeMenu(menu) {
            this.menu = menu;
            this.clear();
        },
        clear() {
            this.channels.map((channel, channel_index) => {
                channel.food.map((food, food_index) => {
                    food.num = 0;
                })
            })
            this.count = 0;
            this.money = 0;
            this.cart = false;
        },
        settle() {
            this.foods = [];
            this.channels.map((channel, channel_index) => {
                channel.food.map((food, food_index) => {
                    if (food.num > 0) {
                        this.foods.push(food);
                    }
                })
            });
            axios.post('/orders', {
                    order_details: this.foods,
                    order_details_type: 'App\\Models\\Food',
                    menu: this.menu
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
