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
                    <p>我的奖励</p>
                    <img src="/images/right.png" alt="">
                </a>
                <a href="/user/promoter/confirms">
                    <p>奖励确认</p>
                    <img src="/images/right.png" alt="">
                </a>
                <a href="javascript:;" @click="cancel">
                    <p>注销医生</p>
                    <img src="/images/right.png" alt="">
                </a>
            </div>
            <div class="mt-1 flex flex-col items-center">
                <p class="text-center text-lg">用户扫二维码转诊</p>
                <img :src="qrcode" width="90%">
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
            qrcode: window.App.promoter
        }
    },
    methods: {
        touch() {
            event.preventDefault();
        },
        cancel() {
            notie.confirm({
                text: '你确定要注销吗，该动作不可逆',
                cancelCallback: () => notie.alert({text: '感谢您的支持' }),
                submitCallback: () => window.location.href = '/user/promoter/cancel'
            })

        }
    }
}
</script>
