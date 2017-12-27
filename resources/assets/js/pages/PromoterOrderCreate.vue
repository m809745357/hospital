<template>
    <div class="container mx-auto">
        <div class="user-form">
            <img src="/images/promoter.png" alt="" style="margin-bottom: 0.2667rem;">
            <div class="from-group">
                <label for="">姓名</label>
                <input type="text" v-model="form.name" name="name" placeholder="请输入姓名">
            </div>
            <span class="help is-danger" v-if="form.errors.has('name')" v-text="form.errors.get('name')"></span>
            <div class="from-group">
                <label for="">性别</label>
                <select name="gender" id="" v-model="form.gender">
                    <option value="">请选择性别</option>
                    <option value="men">男</option>
                    <option value="women">女</option>
                </select>
            </div>
            <span class="help is-danger" v-if="form.errors.has('gender')" v-text="form.errors.get('gender')"></span>
            <div class="from-group">
                <label for="">手机</label>
                <input type="text" v-model="form.mobile" name="mobile" placeholder="请输入手机">
            </div>
            <span class="help is-danger" v-if="form.errors.has('mobile')" v-text="form.errors.get('mobile')"></span>
            <div class="from-group">
                <label for="">科室</label>
                <select name="department" id="" v-model="form.department_id">
                    <option value="">请选择科室</option>
                    <option :value="department.id" v-for="(department, index) in departments" :key="index">{{ department.name }}</option>
                </select>
            </div>
            <span class="help is-danger" v-if="form.errors.has('department_id')" v-text="form.errors.get('department_id')"></span>
            <button type="button" @click="onSubmit">预约</button>
        </div>
    </div>
</template>
<script>
import Form from "../utils/From.js";

export default {
    props: ['attributes'],
    data () {
        return {
            form: new Form({
                name: '',
                gender: '',
                mobile: '',
                department_id: '',
            }),
            departments: this.attributes
        }
    },
    created () {
        if (! window.App.signedIn) {
            window.location.href = '/login';
        }
    },
    methods: {
        url() {
            return window.location.href;
        },
        onSubmit() {
            this.form.post(this.url())
                .then(response => {
                    console.log(response);
                    this.$alert('预约成功')
                        .then(response => {
                            window.location.href = '/orders/promoter';
                        });
                })
                .catch(error => {
                    if (error.response.status === 400) {
                        this.$alert(error.response.data.data);
                        return ;
                    }
                    console.log(error.response);
                });
        }
    }
}
</script>
