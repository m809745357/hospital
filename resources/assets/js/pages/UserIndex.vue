<template>
    <div class="container mx-auto">
        <div class="user-index">
            <div class="from-group">
                <label for="">病床号</label>
                <input type="text" v-model="form.address" name="address" placeholder="未入住不需要填写">
            </div>
            <span class="help is-danger" v-if="form.errors.has('address')" v-text="form.errors.get('address')"></span>
            <div class="from-group">
                <label for="">姓名</label>
                <input type="text" v-model="form.name" name="name" placeholder="请输入姓名">
            </div>
            <span class="help is-danger" v-if="form.errors.has('name')" v-text="form.errors.get('name')"></span>
            <div class="from-group">
                <label for="">身份证</label>
                <input type="text" v-model="form.card" name="card" placeholder="请输入身份证">
            </div>
            <span class="help is-danger" v-if="form.errors.has('card')" v-text="form.errors.get('card')"></span>
            <div class="from-group">
                <label for="">手机</label>
                <input type="tel" v-model="form.mobile" name="phone" placeholder="请输入手机">
                <a href="javascript:;" @click="sendMessage" v-if="time > 60">获取验证码</a>
                <a href="javascript:;" @click="sendMessage" v-else>{{time}}秒后再次发送</a>
            </div>
            <span class="help is-danger" v-if="form.errors.has('mobile')" v-text="form.errors.get('mobile')"></span>
            <div class="from-group">
                <label for="">验证码</label>
                <input type="text" v-model="code" name="code" placeholder="请输入验证码">
            </div> 
            <span class="help is-danger" v-if="form.errors.has('code')" v-text="form.errors.get('code')"></span>
            <button type="button" @click="onSubmit">确认</button>
        </div>
    </div>
</template>
<script>
import Form from "../utils/From.js";

export default {
    data () {
        return {
            form: new Form({
                name: window.App.user.name,
                mobile: window.App.user.mobile,
                card: window.App.user.card,
                address: window.App.user.address,
            }),
            time: 61,
            send: false,
            code: ''
        }
    },
    created () {
        if (! window.App.signedIn) {
            window.location.href = '/login';
        }
    },
    methods: {
        sendMessage() {
            if (this.send === false) {
                axios.post('/sms', {
                    mobile: this.form.mobile
                }).then(response => {
                    this.send = true;
                    console.log(response);

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
                    console.log(error.response.data);
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
                                console.log(response);
                            })
                            .catch(error => {
                                console.log(error);
                            });
                    })
                    .catch(error => {
                        console.log(error.response);
                    });
            } else {
                alert('请先获取短信验证码');
            }
        }
    }
}
</script>
