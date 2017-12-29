<template>
    <div class="container mx-auto">
        <div class="user-form" v-if="order.order_details_type == 'App\\Models\\Food'">
            <div class="from-group">
                <label for="">订单号</label>
                <input type="text" v-model="order.out_trade_no" name="out_trade_no" disabled>
            </div>
            <div class="from-group">
                <label for="">订餐时间</label>
                <input type="text" v-model="order.created_at" name="created_at" disabled>
            </div>
            <div class="from-group">
                <label for="">餐次</label>
                <input type="text" :value="order.remark == 'am' ? '午餐' : '晚餐'" name="remark" disabled>
            </div>
            <div class="from-group">
                <label for="">送餐时间</label>
                <select name="order_time" id="" v-model="order.order_time" v-if="order.status == 1">
                    <option value="">请选择</option>
                    <option value="11:00-11:30">11:00-11:30</option>
                    <option value="11:30-12:00">11:30-12:00</option>
                    <option value="12:00-12:30">12:00-12:30</option>
                    <option value="12:30-13:00">12:30-13:00</option>
                    <option value="13:00-13:30">13:00-13:30</option>
                    <option value="13:30-14:00">13:30-14:00</option>
                </select>
                <input type="text" v-model="order.order_time" name="order_time" disabled v-else>
            </div>
        </div>
        <div class="user-form" v-if="order.order_details_type == 'App\\Models\\Physical'">
            <div class="from-group">
                <label for="">订单号</label>
                <input type="text" v-model="order.out_trade_no" name="out_trade_no" disabled>
            </div>
            <div class="from-group">
                <label for="">订单时间</label>
                <input type="text" v-model="order.created_at" name="created_at" disabled>
            </div>
            <div class="from-group">
                <label for="">体检时间</label>
                <select name="order_time" id="" v-model="day" v-if="order.status == 1">
                    <option value="">请选择</option>
                    <option :value="day" v-for="(day, index) in days" :key="index">{{ day }}</option>
                </select>
                <select name="order_time" id="" v-model="time" v-if="order.status == 1">
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
                <input type="text" v-model="order.order_time" name="order_time" disabled v-else>
            </div>
        </div>
        <div class="user-form" v-if="order.order_details_type == 'App\\Models\\Package'">
            <div class="from-group">
                <label for="">订单号</label>
                <input type="text" v-model="order.out_trade_no" name="out_trade_no" disabled>
            </div>
            <div class="from-group">
                <label for="">订单时间</label>
                <input type="text" v-model="order.created_at" name="created_at" disabled>
            </div>
            <div class="from-group">
                <label for="">预约时间</label>
                <select name="order_time" id="" v-model="day" v-if="order.status == 1">
                    <option value="">请选择</option>
                    <option :value="day" v-for="(day, index) in days" :key="index">{{ day }}</option>
                </select>
                <select name="order_time" id="" v-model="time" v-if="order.status == 1">
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
                <input type="text" v-model="order.order_time" name="order_time" disabled v-else>
            </div>
            <div class="from-group">
                <label for="">诊疗费</label>
                <input type="text" v-model="'￥ ' + order.money + ' 元'" name="order_time" disabled>
            </div>
        </div>
        <div class="user-form" v-if="order.order_details_type == 'App\\Models\\Scheduling'">
            <div class="from-group">
                <label for="">订单号</label>
                <input type="text" v-model="order.out_trade_no" name="out_trade_no" disabled>
            </div>
            <div class="from-group">
                <label for="">订单时间</label>
                <input type="text" v-model="order.created_at" name="created_at" disabled>
            </div>
            <div class="from-group">
                <label for="">预约时间</label>
                <input type="text" v-model="order.order_time" name="order_time" disabled>
            </div>
            <div class="from-group">
                <label for="">预约医生</label>
                <input type="text" v-model="order.order_details.doctor.name" name="order_time" disabled>
            </div>
            <div class="from-group">
                <label for="">诊疗费</label>
                <input type="text" v-model="'￥ ' + order.order_details.money + ' 元'" name="order_time" disabled>
            </div>
            <div class="from-group">
                <label for="">就诊地点</label>
                <input type="text" v-model="order.order_details.address" name="order_time" disabled>
            </div>
        </div>
        <div class="order-show" v-if="order.order_details_type !== 'App\\Models\\Scheduling' && order.order_details_type !== 'App\\Models\\Package'">
            <h4>订单详情</h4>
            <div class="food-item" v-for="(detail, index) in order.order_details" :key="index">
                <h4>{{ detail.title }}</h4>
                <p>{{ detail.num }}</p>
                <span>￥ {{ detail.num * detail.money}} </span>
            </div>
            <span class="sum">合计：￥ {{ order.money }}</span>
        </div>
        <div class="pays" v-if="order.status == 1">
            <div class="pay" @click="change('wechat')" v-if="!checkIpad">
                <img src="/images/wechat.png" alt="">
                <p>微信支付</p>
                <img :src="payway == 'wechat' ? '/images/choosed.png' : '/images/choose.png'" alt="">
            </div>
            <div class="pay" @click="change('card')" v-if="!checkIpad">
                <img src="/images/card.png" alt="">
                <p>一卡通支付</p>
                <img :src="payway == 'card' ? '/images/choosed.png' : '/images/choose.png'" alt="">
            </div>
            <div class="pay" @click="change('ipad')" v-if="checkIpad">
                <img src="/images/ipad.png" alt="">
                <p>Ipad支付</p>
                <img :src="payway == 'ipad' ? '/images/choosed.png' : '/images/choose.png'" alt="">
            </div>
        </div>
        <div class="topay" v-if="order.status == 1">
            <button type="button" @click="pay">马上支付</button>
        </div>
        <div class="topay" v-else>
            <button type="button" @click="back">返回我的订单</button>
        </div>
        <div class="pay-model" v-show="show" @click="cancelCardPay" >
            <div v-if="payway === 'card'" class="model-desc" @click.stop="">
                <div class="from-group">
                    <label for="">密码</label>
                    <input type="password" v-model="secret" placeholder="请找护士输入">
                </div>
                <button type="button" @click="pay">确定</button>
            </div>
            <div v-if="payway === 'ipad'" class="model-desc" @click.stop="" v-html="img">
                
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: ['attributes', 'other'],
    data () {
        return {
            order: this.attributes,
            payway: this.attributes.pay_way ? this.attributes.pay_way : 'wechat',
            show: false,
            secret: '',
            days: [],
            day: '',
            time: '',
            img: '',
            json: {},
            checkIpad: false
        }
    },
    created () {
        for (let index = 0; index < 7; index++) {
            this.days[index] = moment().add(index, 'days').format('L')
        }
        console.log(this.attributes.order_details_type !== 'App\\Models\\Scheduling');
        if (this.other.id !== undefined) {
            this.payway = 'ipad';
            this.checkIpad = true;
        }
    },
    methods: {
        cancelCardPay() {
            this.show = false;
            this.secret = '';
        },
        change(payway) {
            this.payway = payway;
            this.show = false;
        },
        back() {
            window.location.href = '/orders';
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
        url() {
            let url = `/orders/${this.order.id}/${this.payway}`;

            if (this.payway == 'ipad') {
                url = `/ipads/${this.other.id}${url}`;
            }
            return url;
        },
        pay() {

            if (this.order.order_time === '' && this.order.order_details_type == 'App\\Models\\Food') {
                this.$alert('请选择送餐时间');
                return ;
            }
            if (this.order.order_details_type == 'App\\Models\\Physical') {
                if (this.day === '' || this.time === '') {
                    this.$alert('请选择体检时间');
                    return ;
                }
                this.order.order_time = this.day + ' ' + this.time;
            }
            if (this.order.order_details_type == 'App\\Models\\Package') {
                if (this.day === '' || this.time === '') {
                    this.$alert('请选择预约时间');
                    return ;
                }
                this.order.order_time = this.day + ' ' + this.time;
            }
            if (this.payway === 'card' && this.secret === '') {
                this.show = true;
                return ;
            }
            axios.post(this.url(), {
                    order_time: this.order.order_time,
                    pay_way: this.payway,
                    secret: this.secret
                })
                .then(response => {
                    if (response.status === 201) {
                        if (this.payway === 'ipad') {
                            this.img = response.data.data;
                            this.show = true;
                            return ;
                        }
                        if (this.payway === 'card') {
                            this.order = response.data.data;
                            this.show = false;
                            return ;
                        }
                        if (this.payway === 'wechat') {
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
                    }
                    console.log(response.status);
                })
                .catch(error => {
                    this.cancelCardPay();
                        console.log(error.response);
                    if (error.response.status === 400) {
                        this.$alert(error.response.data.data);
                        return ;
                    }
                })

        }
    }
}
</script>
