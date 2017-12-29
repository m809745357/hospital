<template>
    <div class="container mx-auto">
        <div class="package-detail">
            <img class="image" :src="pack.image" alt=""/>
            <div class="title">
                <h4>{{ pack.title }}</h4>
            </div>
            <div class="gender men" @click="changeMoney('men')">
                <p>男</p>
                <span>￥{{ pack.men_money }}</span>
                <img :src="witch_money == 'men' ? '/images/choosed.png' : '/images/choose.png'" alt="">
            </div>
            <div class="gender women" @click="changeMoney('women')">
                <p>女</p>
                <span>￥{{ pack.women_money }}</span>
                <img :src="witch_money == 'women' ? '/images/choosed.png' : '/images/choose.png'" alt="">
            </div>
            <div class="gender time">
                <p>体检时间</p>
                <select name="order_time" id="" v-model="day">
                    <option value="">请选择</option>
                    <option :value="day" v-for="(day, index) in days" :key="index">{{ day }}</option>
                </select>
                <select name="order_time" id="" v-model="time">
                    <option value="">请选择</option>
                    <option value="9:00-10:00">9:00-10:00</option>
                    <option value="10:00-11:00">10:00-11:00</option>
                    <option value="11:00-12:00">11:00-12:00</option>
                    <option value="12:00-13:00">12:00-13:00</option>
                    <option value="13:00-14:00">13:00-14:00</option>
                    <option value="14:00-15:00">14:00-15:00</option>
                    <option value="15:00-16:00">15:00-16:00</option>
                    <option value="16:00-17:00">16:00-17:00</option>
                </select>
            </div>
            <div class="contact" v-html="pack.body"></div>
            <div class="pays">
                <div class="pay">
                    <img src="/images/wechat.png" alt="">
                    <p>微信支付</p>
                    <img :src="payway == 'wechat' ? '/images/choosed.png' : '/images/choose.png'" alt="">
                </div>
            </div>
            <div class="container pack-pay">
                <span>￥{{ money }}</span>
                <button type="button" @click="settle">立即支付</button>
            </div>
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
            pack: this.attributes,
            date: moment().format('L'),
            payway: 'wechat',
            money: this.attributes.men_money,
            witch_money: 'men',
            order_time: '',
            days: [],
            day: '',
            time: '',
            json: {},
        }
    },
    components: {
        scroll
    },
    created () {
        for (let index = 0; index < 7; index++) {
            this.days[index] = moment().add(index, 'days').format('L')
        }  
    },
    methods: {
        touch() {
            event.preventDefault();
        },
        changeMoney(witch_money) {
            this.witch_money = witch_money
            this.money = witch_money === 'men' ? this.pack.men_money : this.pack.women_money
            
        },
        settle() {
            if (this.day === '' || this.time === '') {
                this.$alert('请选择体检时间');
                return ;
            }
            this.order_time = this.day + ' ' + this.time;

            axios.post('/orders', {
                    order_details: this.pack,
                    order_details_type: 'App\\Models\\Package',
                    money: this.money
                })
                .then(response => {
                    if (response.status === 201) {                            
                        this.order = response.data.data
                        this.pay();
                    }
                    console.log(response.status);
                })
                .catch(error => {
                    if (error.response.status === 400) {
                        this.$alert(error.response.data.data);
                        return ;
                    }
                    console.log(error.reponse);
                })
                
        },
        onBridgeReady(){
            WeixinJSBridge.invoke(
                'getBrandWCPayRequest', {
                    "appId": this.json.appId,     //公众号名称，由商户传入     
                    "timeStamp": this.json.timeStamp,         //时间戳，自1970年以来的秒数     
                    "nonceStr": this.json.nonceStr, //随机串     
                    "package": this.json.package,     
                    "signType": this.json.signType,         //微信签名方式：     
                    "paySign": this.json.paySign //微信签名 
                },
                function(res){
                    alert(res.err_msg);
                    if(res.err_msg == "get_brand_wcpay_request:ok" ) {
                        alert('123');
                    }     // 使用以上方式判断前端返回,微信团队郑重提示：res.err_msg将在用户支付成功后返回    ok，但并不保证它绝对可靠。 
                }
            ); 
        },
        pay () {
            axios.post(`/orders/${this.order.id}/${this.payway}`, {
                    order_time: this.order_time,
                    pay_way: this.payway,
                })
                .then(response => {
                    if (response.status === 201) {
                        this.json = response.data.data;
                        if (typeof WeixinJSBridge == "undefined"){
                            if( document.addEventListener ){
                                document.addEventListener('WeixinJSBridgeReady', onBridgeReady, false);
                            }else if (document.attachEvent){
                                document.attachEvent('WeixinJSBridgeReady', onBridgeReady); 
                                document.attachEvent('onWeixinJSBridgeReady', onBridgeReady);
                            }
                        }else{
                            this.onBridgeReady();
                        }
                    }
                    console.log(response.status);
                })
                .catch(error => {
                    if (error.response.status === 400) {
                        this.$alert(error.response.data.data);
                        return ;
                    }
                    console.log(error.response);
                })
        }
    }
}
</script>
