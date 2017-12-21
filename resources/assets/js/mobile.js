
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

require('amfe-flexible');

import { Alert, Confirm, Toast } from 'wc-messagebox'
import 'wc-messagebox/style.css'

window.Vue = require('vue');

Vue.use(Alert, {
    title: '提示',  // 默认标题为 '提示'
    btn: {
        text: '确定',
        style: {} // 可以通过 style 来修改按钮的样式, 比如说粗细, 颜色
    }
})

window.wx = require('weixin-js-sdk');

if (App.wxconfig !== undefined) {
    wx.config(JSON.parse(App.wxconfig));
    wx.ready(function () {
        wx.onMenuShareTimeline({
            title: '宁波鄞州肛肠医院',
            link: 'https://nbyzgc.mandokg.com/user',
            imgUrl: 'https://lorempixel.com/200/200/?47750',
        });
        wx.onMenuShareAppMessage({
            title: '宁波鄞州肛肠医院',
            desc: '宁波鄞州肛肠医院',
            link: 'https://nbyzgc.mandokg.com/user',
            imgUrl: 'https://lorempixel.com/200/200/?47750',
        });
    });
}
// Vue.use(Confirm, options)
// Vue.use(Toast, duration)

window.moment = require('moment');
window.moment.locale('zh-cn');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
Vue.component('user-index', require('./pages/UserIndex.vue'));
Vue.component('user-bind', require('./pages/UserBind.vue'));
Vue.component('user-room', require('./pages/UserRoom.vue'));
Vue.component('parcel-index', require('./pages/ParcelIndex.vue'));
Vue.component('order-show', require('./pages/OrderShow.vue'));
Vue.component('order-index', require('./pages/OrderIndex.vue'));
Vue.component('physical-index', require('./pages/PhysicalIndex.vue'));
Vue.component('package-index', require('./pages/PackageIndex.vue'));
Vue.component('package-show', require('./pages/PackageShow.vue'));
Vue.component('advance-index', require('./pages/AdvanceIndex.vue'));
Vue.component('promoter-create', require('./pages/PromoterCreate.vue'));
Vue.component('promoter-show', require('./pages/PromoterShow.vue'));
Vue.component('promoter-order', require('./pages/PromoterOrder.vue'));
Vue.component('promoter-order-create', require('./pages/PromoterOrderCreate.vue'));
Vue.component('promoter-record', require('./pages/PromoterRecord.vue'));
Vue.component('promoter-confirm', require('./pages/PromoterConfirm.vue'));

const app = new Vue({
    el: '#app',
});