<template>
    <div class="container mx-auto">
        <div class="user-index">
            <div class="user-desc" @click="bind">
                <img class="avatar" :src="user.avatar" alt="">
                <div class="user-info">
                    <h4>{{ user.name }} <span>{{ user.mobile }}</span></h4>
                    <p>{{ user.card}}</p>
                </div>
                <img src="/images/right.png" alt="">
            </div>
            <div class="user-account">
                <a href="/parcels"><img src="/images/parcels.png" alt="">微信点餐</a>
                <a href="/physicals/single"><img src="/images/physicals.png" alt="">预约体检</a>
                <a href="/advances"><img src="/images/advances.png" alt="">预约挂号</a>
            </div>
            <div class="user-menu">
                <a href="/user/room">
                    <img src="/images/room.png" alt="">
                    <p>绑定床号</p>
                    <img src="/images/right.png" alt="">
                </a>
                <a href="/orders">
                    <img src="/images/orders.png" alt="">
                    <p>我的订单</p>
                    <img src="/images/right.png" alt="">
                </a>
                <a href="/orders/promoter">
                    <img src="/images/promoters.png" alt="">
                    <p>转诊订单</p>
                    <img src="/images/right.png" alt="">
                </a>
                <a href="/user/promoter" v-if="user.role === 'promoter'">
                    <img src="/images/spread.png" alt="">
                    <p>我要推广</p>
                    <img src="/images/right.png" alt="">
                </a>
                <!-- <a href="/user/guide">
                    <img src="/images/guide.png" alt="">
                    <p>用户指南</p>
                    <img src="/images/right.png" alt="">
                </a> -->
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data () {
        return {
            user: window.App.user
        }
    },
    created () {
        
    },
    methods: {
        bind() {
            window.location.href = '/user/bind';
        }
    }
}
</script>
