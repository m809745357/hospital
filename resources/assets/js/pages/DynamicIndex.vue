<template>
    <div class="flex items-center w-full flex-col">
        <div class="container h-full mt-pc-50">
            <div class="border-l-4 border-blue h-pc-37 text-lg pl-4 md:pl-pc-27 flex items-center mx-4 md:mx-0">医院动态</div>
        </div>
        <div class="container">
            <div v-for="(dynamic, index) in dynamics" :key="index" class="mx-pc-25 md:m-0 max-w-full flex flex-col md:flex-row justify-between py-pc-33 border-dashed border-b">
                <img :src="dynamic.image" class="w-full md:w-1/4" height="213">
                <div class="w-full md:w-3/4 md:pl-pc-33 flex flex-col justify-around">
                    <h4 class="no-underline hover:underline hover:text-blue text-2xl text-grey-darker font-normal truncate mt-1 md:mt-0" @click="viewDynamic(dynamic.id)" v-html="dynamic.title"></h4>
                    <span class="text-lg text-grey-dark mt-1 md:mt-0" v-html="dynamic.created_at"></span>
                    <p class="overflow-hidden leading-normal text-lg text-grey-dark h-m-3 mt-1 md:mt-0" v-html="dynamic.desc"></p>
                    <div class="flex flex-row items-center mt-1 md:mt-0">
                        <button class="w-pc-124 bg-blue h-pc-47 text-normal text-white text-lg" @click="viewDynamic(dynamic.id)">阅读全文</button>
                        <span class="flex-1 flex flex-row items-center justify-end text-grey-darker">
                            <img src="/images/view.png" alt="" class="mr-pc-10">
                            {{ dynamic.click_num }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['attributes'],
    data () {
        return {
            dynamics: this.attributes
        }
    },
    methods: {
        viewDynamic(id) {
            window.location.href = '/dynamics/' + id; 
        }
    }
}
</script>
