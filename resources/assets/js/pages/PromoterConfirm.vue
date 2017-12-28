<template>
    <div class="container mx-auto">
        <div class="promoter">
            <li class="content title">
                <span>时间</span>
                <span>数量</span>
                <span>是否兑换</span>
            </li>
            <scroll class="promoter-content warpper" :data="orders">
                <div>
                    <li class="content" v-for="(order, index) in orders" :key="index">
                        <span>{{ order.date }}</span>
                        <span style="width: 33%">{{ order.crown }}皇冠 {{ order.stars }}星星</span>
                        <a class="block no-underline flex items-center justify-center" v-if="order.status === 0">兑换</a>
                        <span v-else>已兑换</span>
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
            orders: this.attributes,
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
