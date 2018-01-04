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
                        <a class="block no-underline flex items-center justify-center" href="javascript:;" @click="exchange(order.id, index)" v-if="order.status === 0">兑换</a>
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
        exchange(id, key) {
            notie.confirm({
                text: '确定兑换码',
                cancelCallback: function () {
                    notie.alert({ text: '兑换取消' });
                },
                submitCallback: function () {
                    axios.post(`/user/promoter/statistics/${id}/confirm`)
                        .then(response => {
                            console.log(response.data);
                            notie.force({
                                type: 1,
                                text: '兑换成功',
                                buttonText: '好的',
                                callback: () => {
                                    window.location.href = '/user/promoter/confirms';
                                }
                            })
                        })
                        .catch(error => {
                            notie.alert({ type: 3, text: error.response.data.data });
                            console.log(error.response);
                        });
                }
            })
        }
    }
}
</script>
