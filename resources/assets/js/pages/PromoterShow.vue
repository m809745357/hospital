<template>
    <div class="container mx-auto">
        <div class="promoter">
            <div class="promoter-info">
                <img :src="user.avatar" alt="">
                <div class="promoter-desc">
                    <h4><strong>{{ user.name }}</strong> {{ promoter.job_title }}</h4>
                    <p>{{ promoter.hospital }} <span>{{ promoter.department }}</span></p>
                </div>
            </div>
            <div class="promoter-menu">
                <a href="/user/promoter/orders">
                    <p>转诊订单</p>
                    <img src="/images/right.png" alt="">
                </a>
                <a href="/user/promoter/records">
                    <p>我的收益</p>
                    <img src="/images/right.png" alt="">
                </a>
                <a href="/user/promoter/confirms">
                    <p>兑换确认</p>
                    <img src="/images/right.png" alt="">
                </a>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: ['attributes'],
    data () {
        return {
            promoter: this.attributes,
            user: window.App.user,
        }
    },
    methods: {
        touch() {
            event.preventDefault();
        },
    }
}
</script>
