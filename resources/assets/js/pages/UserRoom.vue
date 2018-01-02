<template>
    <div class="container mx-auto">
        <div class="user-form">
            <span class="help is-danger" v-if="form.errors.has('address')" v-text="form.errors.get('address')"></span>
            <div class="from-group">
                <label for="">病床号</label>
                <input type="text" v-model="form.address" name="address" placeholder="未入住不需要填写">
            </div>
            
            <button type="button" @click="onSubmit">绑定病床号</button>
        </div>
    </div>
</template>
<script>
import Form from "../utils/From.js";

export default {
    data () {
        return {
            form: new Form({
                address: window.App.user.address,
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
            this.form.post('/user/')
                .then(response => {
                    console.log(response);
                    // notie.alert({ type: 1, text: response.data, stay: true });
                    notie.force({
                        type: 1,
                        text: response.data,
                        buttonText: '好的',
                        callback: () => {
                            window.location.href = '/user';
                        }
                    })
                })
                .catch(error => {
                    console.log(error);
                });
        }
    }
}
</script>
