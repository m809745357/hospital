<template>
    <div class="flex items-center w-full flex-col">
        
        <div class="container">
            <div class="mt-pc-92 text-center pb-pc-27">
                <h6 class="text-3xl font-medium">医院动态</h6>
                <p class="text-1xs text-grey mt-pc-6 pb-pc-27 border-b-2 border-blue inline">Hospital News</p>
            </div>
            <div class="mt-pc-50 flex items-center justify-between flex-col m-1 md:m-pc-50 md:flex-row md:h-pc-403">
                <div class="h-full md:w-pc-540 flex justify-between flex-col w-full">
                    <img :src="'/uploads/' + dynamics[0].image" alt="">
                    <div class="flex items-center mt-1 md:mt-0">
                        <a :href="`/dynamics/${dynamics[0].id}`" class="no-underline hover:underline hover:text-blue text-lg font-normal text-grey-darkest truncate w-3/4">{{ dynamics[0].title }}</a>
                        <span class="text-grey-darkest text-xs">{{ dynamics[0].created_at }}</span>
                    </div>
                    <p class="text-grey-darker text-xs leading-loose h-m-6 overflow-hidden mt-1 md:mt-0">{{ dynamics[0].desc }}</p>
                </div>
                <div class="h-full w-full md:w-pc-540 justify-around flex items-center md:justify-between flex-col">
                    <div v-for="(dynamic, index) in dynamics" :key="index" v-if="index > 0" class="h-pc-98 w-full flex items-center justify-between">
                        <img :src="'/uploads/' + dynamic.image" class="w-1/4 md:w-pc-98">
                        <div class="w-3/4 h-full flex flex-col justify-around pl-2 md:pl-0">
                            <span class="text-grey-darkest text-xs">{{ dynamic.created_at }}</span>
                            <a :href="`/dynamics/${dynamic.id}`" class="no-underline hover:underline hover:text-blue text-lg font-normal text-grey-darkest truncate w-3/4">{{ dynamic.title }}</a>
                            <p class="text-grey-darker text-xs truncate">{{ dynamic.desc }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-1 md:mt-pc-50 text-center">
                <a class="more" href="/dynamics">MORE</a>
            </div>
            
        </div>
        
        <div class="mt-1 md:mt-pc-50">
            <img src="/images/slider-bg-2.png" alt="">
        </div>

        <div class="container">
            <div class="mt-pc-92 text-center pb-pc-27">
                <h6 class="text-3xl font-medium">医疗特色</h6>
                <p class="text-1xs text-grey mt-pc-6 pb-pc-27 border-b-2 border-blue inline">Medical Features</p>
            </div>
        </div>

        <div class="container mt-1 md:mt-pc-50">
            <swiper :options="medicalOptions" class="w-11/12">
                <swiper-slide v-for = "(medical, index) in medicals" :key="index" class="h-pc-470 flex items-center justify-center">
                    <div class="border-blue border md:w-pc-350 flex flex-col justify-between h-pc-470 rounded-4px">
                        <img :src="`/images/i-${medical}.png`" class="w-full rounded-t-4px h-pc-226">
                        <div class="flex flex-col items-center justify-center">
                            <img :src="`/images/icon-${medical}.png`" alt="">
                            <span class="text-blue text-lg mt-pc-10">经验</span>
                        </div>
                        <h4 class="text-lg font-normal text-grey-darkest text-center">资历丰富的各种医生</h4>
                        <div class="text-xs text-grey-dark text-center mb-pc-40">
                            <p>全职聘请三甲医院主治医师</p>
                            <p>标准化临床路径及用药</p>
                            <p>医生终身学习制</p>
                        </div>
                    </div>
                </swiper-slide>
            </swiper>
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
            <div class="mt-1 md:mt-pc-50 text-center">
                <a class="more" href="/dynamics">MORE</a>
            </div>
        </div>
    </div>
</template>

<script>
import { swiper, swiperSlide } from 'vue-awesome-swiper'
import 'swiper/dist/css/swiper.css'

export default {
    props: ['attributes'],
    data () {
        return {
            medicalOptions: {
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
                slidesPerView : 3,
                loop : true,
            },
            medicals: [1, 2, 3],
            dynamics: this.attributes
        }
    },
    components: {
        swiper,
        swiperSlide
    },
    created () {
        if (window.screen.width < 768) {
            this.medicalOptions.slidesPerView = 1
        }
    },
    methods: {

    }
}
</script>
