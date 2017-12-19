<template>
    <div class="container mx-auto">
        <div class="promoter">
            <li class="content title">
                <span>时间</span>
                <span>姓名</span>
                <span>性别</span>
                <span>科室</span>
            </li>
            <scroll class="promoter-content warpper" :date="orders">
                <div>
                    <li class="content" v-for="(order, index) in orders" :key="index">
                        <span>{{ order.created_at.substr(0, 10) }}</span>
                        <span>{{ order.name }}</span>
                        <span>{{ order.gender }}</span>
                        <span>{{ order.department.name }}</span>
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
            orders: this.attributes.order === undefined ? this.attributes : this.attributes.order,
            user: window.App.user,
        }
    },
    components: {
        scroll
    },
    created () {
        console.log(this.order);  
    },
    methods: {
        touch() {
            event.preventDefault();
        },
    }
}
</script>
