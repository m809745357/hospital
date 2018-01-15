<template>
    <div class="flex items-center w-full flex-col">
        <div class="container h-full mt-pc-50">
            <div class="border-l-4 border-blue h-pc-37 text-lg pl-4 md:pl-pc-27 flex items-center mx-4 md:mx-0 flex-1 justify-between">
                医疗特色
                <button class="border border-grey-dark h-pc-50 w-pc-143 text-lg text-grey-dark text-center rounded-16px" @click="goback">返回</button>
            </div>
        </div>
        <div class="container mt-1 mx-1 md:mx-0 md:mt-pc-50 md:border-t border-grey-lighter">
            <h4 class="text-2xl text-grey-darker text-center font-normal mt-pc-40">{{ special.title }}</h4>
            <p class="text-lg text-grey-dark text-center my-pc-10">{{ special.created_at }}</p>
            <div class="max-w-full m-1 topic-body" v-html="special.body"></div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['attributes'],
    data () {
        return {
            special: this.attributes
        }
    },
    methods: {
        goback() {
            window.history.go(-1);
        }
    }
}
</script>