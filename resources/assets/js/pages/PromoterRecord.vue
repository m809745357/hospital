<template>
    <div class="container mx-auto">
        <div class="promoter">
            <div class="promoter-info">
                <img :src="user.avatar" alt="">
                <div class="promoter-desc">
                    <h4><strong>总收益：</strong> {{ user.promoter.crown }}皇冠 {{ user.promoter.stars }}星星</h4>
                    <h4><strong>本月收益：</strong></h4>
                </div>
            </div>
            <li class="content title">
                <span>时间</span>
                <span>姓名</span>
                <span>科室</span>
                <span>类型</span>
                <span>收益</span>
            </li>
            <scroll class="promoter-content warpper" :date="orders">
                <div>
                    <li class="content" v-for="(order, index) in orders" :key="index" v-if="order.record !== null">
                        <span>{{ order.created_at }}</span>
                        <span>{{ order.name }}</span>
                        <span>{{ order.department.name }}</span>
                        <span>门诊</span>
                        <span>{{ order.record.crown }}皇冠 {{ order.record.stars }}星星</span>
                    </li>
                </div>
            </scroll>
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
            orders: this.attributes.order,
            user: window.App.user,
        }
    },
    components: {
        scroll
    },
    methods: {
        touch() {
            event.preventDefault();
        },
    }
}
</script>
