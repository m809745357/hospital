
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

require('amfe-flexible');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('home', require('./pages/Home.vue'));
Vue.component('introduce', require('./pages/Introduce.vue'));
Vue.component('dynamic-index', require('./pages/DynamicIndex.vue'));
Vue.component('dynamic-show', require('./pages/DynamicShow.vue'));
Vue.component('special-index', require('./pages/SpecialIndex.vue'));
Vue.component('special-show', require('./pages/SpecialShow.vue'));
Vue.component('scheduling-index', require('./pages/SchedulingIndex.vue'));
Vue.component('report', require('./pages/Report.vue'));
Vue.component('contact', require('./pages/Contact.vue'));

import { swiper, swiperSlide } from 'vue-awesome-swiper'
import 'swiper/dist/css/swiper.css'

const app = new Vue({
    el: '#app',
    data () {
        return {
            isClickMenu: false,
            bannerOptions: {
                pagination: {
                    el: '.swiper-pagination'
                },
                loop : true,
            },
            swiperSlides: [1, 2, 3, 4, 5],
        }
    },
    components: {
        swiper,
        swiperSlide
    },
    methods: {
        changeMenu() {
            if (this.isClickMenu === false) {
                document.getElementById("menu").style.display = 'flex';
                this.isClickMenu = true;
            } else {
                document.getElementById("menu").style.display = 'none';
                this.isClickMenu = false;
            }
        }
    }
});
