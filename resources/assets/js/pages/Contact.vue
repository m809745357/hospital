<template>
    <div class="flex items-center w-full flex-col">
        <div class="container bg-brand">
            <div class="flex items-center flex-col md:flex-row py-pc-20 relative bg-white z-10 shadow-md">
                <div class="flex-1 flex items-center flex-col justify-center md:border-r md:border-grey-dark h-pc-165 px-pc-50 md:px-0 w-full md:max-w-full">
                    <h4 class="text-2xl font-normal">全国服务热线</h4>
                    <p class="text-xl font-normal mt-pc-10">{{ configs.phone }}</p>
                </div>
                <div class="flex-1 flex items-start justify-around flex-col h-pc-165 px-pc-50">
                    <h4 class="text-xl font-normal">{{ configs.site_title }}</h4>
                    <p class="text-sm text-grey-darker flex items-center"><img class="mr-px" src="/images/phone.png" width="16" height="16">{{ configs.phone }}</p>
                    <p class="text-sm text-grey-darker flex items-center"><img class="mr-px" src="/images/address.png" width="16" height="16">{{ configs.address }}</p>
                    <p class="text-sm text-grey-darker flex items-center"><img class="mr-px" src="/images/e.png" width="16" height="16">{{ configs.url }}</p>
                    <p class="text-sm text-grey-darker flex items-center"><img class="mr-px" src="/images/mail.png" width="16" height="16">{{ configs.mail }}</p>
                </div>
                <div class="flex-1 flex items-center justify-around md:border-l md:border-grey-dark h-pc-165 px-pc-50 md:px-0 w-full md:max-w-full">
                    <div class="flex items-cetner flex-col justify-center">
                        <h4 class="text-base font-normal text-grey-darker">微信添加</h4>
                        <p class="text-sm mt-pc-10 text-center">扫一扫</p>
                    </div>
                    <img :src="`/${configs.qrcode}`" alt="">
                </div>
            </div>
            <div class="mt-pc-40 h-pc-470 bg-white shadow-md">
                <!-- <img src="/images/slider-bg-1.png" height="100%" class="py-pc-33 px-pc-50"> -->
                <div id="map" class="py-pc-33 px-pc-50 h-full"></div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data () {
        return {
            configs: window.App.configs     
        }
    },
    created () {
        setTimeout(() => {
            var center = new qq.maps.LatLng(this.configs.lat ,this.configs.lng);
            var map = new qq.maps.Map(document.getElementById("map"), {
                center: center,
                zoom: 18
            });
            var marker = new qq.maps.Marker({
                position: center,
                map: map
            });
        }, 1000)
    }
}
</script>