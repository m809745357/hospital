<template>
    <div class="flex items-center w-full flex-col">
        <div class="container h-full mt-pc-50">
            <div class="border-l-4 border-blue h-pc-37 text-lg pl-4 md:pl-pc-27 flex items-center mx-4 md:mx-0">医院介绍</div>
        </div>

        <div class="container mt-1 mx-1 md:mx-0 md:mt-pc-50 md:border-t border-grey-lighter">
            <div class="max-w-full m-1 topic-body" v-html="introduce"></div>
        </div>
    </div>
</template>

<script>
export default {
    data () {
        return {
            introduce: window.App.configs.introduce
        }
    }
}
</script>
