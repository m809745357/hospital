<template>
    <div class="flex items-center w-full flex-col">
        <div class="w-full">
            <swiper :options="swiperOption">
                <swiper-slide v-for="(slide, index) in swiperSlides" :key="index"><img src="/images/slider-bg-1.png" alt=""></swiper-slide>
                <div class="swiper-pagination" slot="pagination"></div>
            </swiper>
        </div>
        
        <div class="container">
            <div class="mt-pc-92 text-center">
                <h6 class="text-3xl font-medium">医院动态</h6>
                <p class="text-1xs text-grey mt-pc-6 pb-pc-27 border-b-2 border-blue inline">Hospital News</p>
            </div>
            <div>
                <div>
                    <img src="" alt="">
                    <div>
                        <h4></h4>
                        <span></span>
                    </div>
                    <p></p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { swiper, swiperSlide } from 'vue-awesome-swiper'
import 'swiper/dist/css/swiper.css'

export default {
    props: [''],
    data () {
        return {
            swiperOption: {
                pagination: {
                    el: '.swiper-pagination'
                }
            },
            swiperSlides: [1, 2, 3, 4, 5]
        }
    },
    components: {
        swiper,
        swiperSlide
    }
}
</script>
