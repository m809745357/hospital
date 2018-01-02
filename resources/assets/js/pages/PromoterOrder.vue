<template>
    <div class="container mx-auto">
        <div class="promoter">
            <li class="content title">
                <span>时间</span>
                <span>姓名</span>
                <span>性别</span>
                <span>科室</span>
                <span>状态</span>
            </li>
            <scroll class="promoter-content warpper" :data="orders" >
                <div >
                    <li class="content" v-for="(order, index) in orders" :key="index">
                        <span>{{ order.created_at.substr(0, 10) }}</span>
                        <span>{{ order.name }}</span>
                        <span>{{ order.gender }}</span>
                        <span>{{ order.department.name }}</span>
                        <span v-if="order.status == '1'">已兑换</span>
                        <span v-else>
                            <p v-if="user.promoter && typeof user.promoter == 'object'" href="javascript:;">未兑换</p>
                            <a v-else class="block no-underline flex items-center justify-center" href="javascript:;" @click="change(order.id)">兑换</a>
                        </span>
                    </li>
                </div>
            </scroll>
            <div class="pay-model" v-show="show" @click="cancel" >
                <div class="model-desc" @click.stop="">
                    <div class="from-group">
                        <label for="">兑换码</label>
                        <input type="password" v-model="data.secret" placeholder="请找医院输入">
                    </div>
                    <button type="button" @click="exchange">确定</button>
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
            orders: this.attributes.order === undefined ? this.attributes : this.attributes.order,
            user: window.App.user,
            show: false,
            data: {
                id: '',
                secret: '',
            }
        }
    },
    components: {
        scroll
    },
    created () {
        console.log(this.orders);  
    },
    methods: {
        touch() {
            event.preventDefault();
        },
        cancel() {
            this.show = false;
        },
        change(id) {
            this.data.id = id;
            this.show = true;
        },
        exchange() {
            axios.post(`/orders/promoter/records`, this.data)
                .then(response => {
                    console.log(response.data);
                    notie.force({
                        type: 1,
                        text: '兑换成功',
                        buttonText: '好的',
                        callback: () => {
                            window.location.href = '/orders/promoter';
                        }
                    })
                })
                .catch(error => {
                    if (error.response.status === 422) {
                        notie.alert({ type: 2, text: error.response.data.errors.secret[0] });
                        return ;
                    }
                    notie.alert({ type: 3, text: error.response.data.data });
                    console.log(error.response);
                });
        }
    }
}
</script>
