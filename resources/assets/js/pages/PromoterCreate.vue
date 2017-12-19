<template>
    <div class="container mx-auto">
        <div class="user-form">
            <span class="help is-danger" v-if="form.errors.has('hospital')" v-text="form.errors.get('hospital')"></span>
            <div class="from-group">
                <label for="">医院</label>
                <input type="text" v-model="form.hospital" name="hospital" placeholder="请输入医院">
            </div>
            <span class="help is-danger" v-if="form.errors.has('department')" v-text="form.errors.get('department')"></span>
            <div class="from-group">
                <label for="">科室</label>
                <input type="text" v-model="form.department" name="department" placeholder="请输入科室">
            </div>
            <span class="help is-danger" v-if="form.errors.has('job_title')" v-text="form.errors.get('department')"></span>
            <div class="from-group">
                <label for="">职称</label>
                <input type="text" v-model="form.job_title" name="job_title" placeholder="请输入职称">
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
            form: new Form({
                hospital: '',
                department: '',
                job_title: '',
            }),
        }
    },
    created () {
        if (! window.App.signedIn) {
            window.location.href = '/login';
        }
    },
    methods: {
        onSubmit() {
            this.form.post('/promoter')
                .then(response => {
                    console.log(response);
                    this.$alert(response.data)
                        .then(response => {
                            window.location.href = '/user/promoter';
                        });
                })
                .catch(error => {
                    console.log(error);
                });
        }
    }
}
</script>
