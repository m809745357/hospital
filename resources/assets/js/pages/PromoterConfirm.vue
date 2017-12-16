<template>
    <div class="container mx-auto">
        <div class="promoter">
            <li class="content title">
                <span>时间</span>
                <span>数量</span>
                <span>是否兑换</span>
            </li>
            <scroll class="promoter-content warpper" :date="orders">
                <div>
                    <li class="content" v-for="(order, index) in orders" :key="index" v-if="order.record !== null && order.record.status > 0">
                        <span>{{ order.created_at }}</span>
                        <span>{{ order.record.crown }}皇冠 {{ order.record.stars }}星星</span>
                        <button>兑换</button>
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
