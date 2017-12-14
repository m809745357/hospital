<template>
    <div class="container mx-auto">
        <div class="user-index" v-if="order.order_details_type == 'App\\Models\\Food'">
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
        <div class="user-index" v-if="order.order_details_type == 'App\\Models\\Physical'">
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
        <div class="user-index" v-if="order.order_details_type == 'App\\Models\\Package'">
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
        <div class="user-index" v-if="order.order_details_type == 'App\\Models\\Scheduling'">
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
        <div class="order-show" v-if="! order.order_details_type == 'App\\Models\\Scheduling'">
            <h4>订单详情</h4>
            <div class="food-item" v-for="(detail, index) in order.order_details" :key="index">
                <h4>{{ detail.title }}</h4>
                <p>{{ detail.num }}</p>
                <span>￥ {{ detail.num * detail.money}} </span>
            </div>
            <span class="sum">合计：￥ {{ order.money }}</span>
        </div>
        <div class="pays" v-if="order.status == 1">
            <div class="pay" @click="change('wechat')">
                <img src="/images/wechat.png" alt="">
                <p>微信支付</p>
                <img :src="payway == 'wechat' ? '/images/choosed.png' : '/images/choose.png'" alt="">
            </div>
            <div class="pay" @click="change('card')">
                <img src="/images/card.png" alt="">
                <p>一卡通支付</p>
                <img :src="payway == 'card' ? '/images/choosed.png' : '/images/choose.png'" alt="">
            </div>
            <div class="pay" @click="change('ipad')">
                <img src="/images/ipad.png" alt="">
                <p>Ipad支付</p>
                <img :src="payway == 'ipad' ? '/images/choosed.png' : '/images/choose.png'" alt="">
            </div>
        </div>
        <div class="topay" v-if="order.status == 1">
            <button type="button" @click="pay">马上支付</button>
        </div>
        <div class="pay-model" v-show="show" @click="cancelCardPay" >
            <div v-if="payway === 'card'" class="model-desc" @click.stop="">
                <div class="from-group">
                    <label for="">密码</label>
                    <input type="password" v-model="secret" placeholder="请找护士输入">
                </div>
                <button type="button" @click="pay">确定</button>
            </div>
            <div v-if="payway === 'ipad'" class="model-desc" @click.stop="">
                <img src="" alt="">
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: ['attributes'],
    data () {
        return {
            order: this.attributes,
            payway: this.attributes.pay_way ? this.attributes.pay_way : 'wechat',
            show: false,
            secret: '',
            days: [],
            day: '',
            time: ''
        }
    },
    created () {
        for (let index = 0; index < 7; index++) {
            this.days[index] = moment().add(index, 'days').format('L')
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
        pay() {

            if (this.order.order_time === '' && this.order.order_details_type == 'App\\Models\\Food') {
                alert('请选择送餐时间');
                return ;
            }
            if (this.order.order_details_type == 'App\\Models\\Physical') {
                if (this.day === '' || this.time === '') {
                    alert('请选择体检时间');
                    return ;
                }
                this.order.order_time = this.day + ' ' + this.time;
            }
            if (this.order.order_details_type == 'App\\Models\\Package') {
                if (this.day === '' || this.time === '') {
                    alert('请选择预约时间');
                    return ;
                }
                this.order.order_time = this.day + ' ' + this.time;
            }
            if (this.payway === 'card' && this.secret === '') {
                this.show = true;
                return ;
            }
            axios.post(`/orders/${this.order.id}/${this.payway}`, {
                    order_time: this.order.order_time,
                    pay_way: this.payway,
                    secret: this.secret
                })
                .then(response => {
                    if (response.status === 201) {
                        this.order = response.data.data;
                        this.show = false;
                        return ;
                    }
                    console.log(response.status);
                })
                .catch(error => {
                    this.cancelCardPay();
                    if (error.response.status === 400) {
                        alert(error.response.data.data);
                        return ;
                    }
                    console.log(error.response);
                })

        }
    }
}
</script>
