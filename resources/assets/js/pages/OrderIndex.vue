<template>
    <div class="container mx-auto">
        <div class="parcel-index">
            <div class="parcel-menu" @touchmove="touch">
                <a :class="menu == 'P' ? 'on' : ''" @click="changeMenu('P')">体检订单</a>
                <a :class="menu == 'S' ? 'on' : ''" @click="changeMenu('S')">挂号订单</a>
                <a :class="menu == 'F' ? 'on' : ''" @click="changeMenu('F')">点餐订单</a>
            </div>
            <div class="parcel-menu" @touchmove="touch">
                <a :class="status == '1' ? 'on' : ''" @click="changeStatus('1')">未支付</a>
                <a :class="status == '2' ? 'on' : ''" @click="changeStatus('2')">已支付</a>
                <a :class="status == '3' ? 'on' : ''" @click="changeStatus('3')">已完成</a>
                <a :class="status == '4' ? 'on' : ''" @click="changeStatus('4')">已取消</a>
            </div>
            <div class="parcel-contact">
                <scroll class="parcel-package warpper" :data="orders">
                    <div class="content">
                        <div class="order-item" v-for="(order, index) in orders" :key="index" v-if="order.order_details_type.indexOf(menu) > -1 && order.status === status">
                            <div class="order-item-top">
                                <div class="order-item-desc">
                                    <h4>单号:{{ order.out_trade_no }}</h4>
                                    <p v-if="order.order_details_type === 'App\\Models\\Food'">{{ order.created_at.substr(0, 10) }} {{ order.order_time }} {{ foodType[order.remark] }}</p>
                                    <p v-if="order.order_details_type === 'App\\Models\\Physical'">{{ order.order_time === '' ? '暂未选择时间' : order.order_time }} {{ order.remark }}</p>
                                    <p v-if="order.order_details_type === 'App\\Models\\Package'">{{ order.order_time === '' ? '暂未选择时间' : order.order_time }} {{ order.remark }}</p>
                                    <p v-if="order.order_details_type === 'App\\Models\\Scheduling'">{{ order.order_time === '' ? '暂未选择时间' : order.order_time }} {{ order.remark }}</p>
                                </div>
                                <a :href="`/orders/${order.id}`" v-if="order.status == 1">去支付</a>
                                <a :href="`/orders/${order.id}`" v-if="order.status == 2">去查看</a>
                            </div>
                            <div class="order-item-bottom">
                                <p v-if="order.order_details_type === 'App\\Models\\Food'">{{ order.order_details[0].title }} 等餐品</p>
                                <p v-if="order.order_details_type === 'App\\Models\\Physical'">{{ order.order_details[0].title }} 等单列体检</p>
                                <p v-if="order.order_details_type === 'App\\Models\\Package'">{{ order.order_details.title }} 套餐体检</p>
                                <p v-if="order.order_details_type === 'App\\Models\\Scheduling'">{{ order.order_details.doctor.department.name }} {{ order.order_details.doctor.name }}</p>
                                <span>￥ {{ order.money }}</span>
                            </div>
                        </div>
                    </div>
                </scroll>
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
            orders: this.attributes,
            date: moment().format('L'),
            menu: 'P',
            status: '1',
            foodType: {
                am: '午餐',
                pm: '晚餐'
            }
        }
    },
    components: {
        scroll
    },
    methods: {
        touch() {
            event.preventDefault();
        },
        changeMenu(menu) {
            this.menu = menu;
            this.status = '1';
        },
        changeStatus(status) {
            this.status = status;
        },
    }
}
</script>
