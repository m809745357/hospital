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
            time: ''
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
        pay () {
            axios.post(`/orders/${this.order.id}/${this.payway}`, {
                    order_time: this.order_time,
                    pay_way: this.payway,
                })
                .then(response => {
                    if (response.status === 201) {
                        
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
