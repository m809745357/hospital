<template>
    <div class="container mx-auto">
        <div class="user-form">
            <!-- <div class="from-group">
                <label for="">病床号</label>
                <input type="text" v-model="form.address" name="address" placeholder="未入住不需要填写">
            </div>
            <span class="help is-danger" v-if="form.errors.has('address')" v-text="form.errors.get('address')"></span> -->
            <span class="help is-danger" v-if="certification == 0 && form.errors.has('name')" v-text="form.errors.get('name')"></span>
            <div class="from-group" v-if="certification == 0">
                <label for="">姓名</label>
                <input type="text" v-model="form.name" name="name" placeholder="请输入姓名">
            </div>
            <span class="help is-danger" v-if="form.errors.has('card')" v-text="form.errors.get('card')"></span>
            <div class="from-group" v-if="certification == 0">
                <label for="">身份证</label>
                <input type="text" v-model="form.card" name="card" placeholder="请输入身份证">
            </div>
            <div class="from-group" v-if="phone">
                <label for="">原手机</label>
                <input type="tel" v-model="phone" name="phone" disabled>
            </div>
            <span class="help is-danger" v-if="form.errors.has('mobile')" v-text="form.errors.get('mobile')"></span>
            <div class="from-group">
                <label for="">新手机</label>
                <input type="tel" v-model="form.mobile" name="mobile" placeholder="请输入手机">
                <a href="javascript:;" @click="sendMessage" v-if="time > 60">获取验证码</a>
                <a href="javascript:;" @click="sendMessage" v-else>{{time}}秒后再次发送</a>
            </div>
            <span class="help is-danger" v-if="form.errors.has('code')" v-text="form.errors.get('code')"></span>
            <div class="from-group">
                <label for="">验证码</label>
                <input type="text" v-model="code" name="code" placeholder="请输入验证码">
            </div> 
            <button type="button" @click="onSubmit">确认</button>
        </div>
    </div>
</template>
<script>
import Form from "../utils/From.js";

export default {
    data () {
        return {
            form: {},
            certification: window.App.user.certification,
            phone: window.App.user.mobile,
            time: 61,
            send: false,
            code: ''
        }
    },
    created () {
        if (! window.App.signedIn) {
            window.location.href = '/login';
        }
        if (this.certification === 1) {
            this.form = new Form({
                mobile: '',
            })
        } else {
            this.form = new Form({
                name: window.App.user.name,
                mobile: '',
                card: window.App.user.card,
            })
        }
    },
    methods: {
        sendMessage() {
            if (this.send === false) {
                axios.post('/sms', {
                    mobile: this.form.mobile
                }).then(response => {
                    this.send = true;
                    this.$alert('短信发送成功');

                    var times = setInterval(() => {
                        if (this.time == 0) {
                            this.time = 61;
                            this.send = false;
                            clearInterval(times);
                            return ;
                        }
                        this.time -- ;
                    }, 1000)

                }).catch(error => {
                    if (error.response.status === 422) {
                        this.$alert(error.response.data.errors.mobile[0])
                        return ;
                    }
                    
                    this.$alert(error.response.data.data)
                })
            }
        },
        onSubmit() {
            if (this.send === true) {
                axios.post(`/sms/${this.form.mobile}`, {
                    code: this.code
                })
                    .then(response => {
                        this.form.post('/user')
                            .then(response => {
                                this.$alert(response.data)
                                    .then(response => {
                                        window.location.href = '/user/bind';
                                    });
                            })
                            .catch(error => {
                                console.log(error.response)
                            });
                    })
                    .catch(error => {
                        if (error.response.status === 422) {
                            this.$alert(error.response.data.errors.mobile[0])
                            return ;
                        }
                        
                        this.$alert(error.response.data.data)
                        console.log(error.response);
                    });
            } else {
                this.$alert('请先获取短信验证码');
            }
        }
    }
}
</script>
