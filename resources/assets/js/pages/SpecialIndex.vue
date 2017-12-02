<template>
    <div class="flex items-center w-full flex-col">
        <div class="container h-full mt-pc-50">
            <div class="border-l-4 border-blue h-pc-37 text-lg pl-4 md:pl-pc-27 flex items-center mx-4 md:mx-0">医疗特色</div>
        </div>
        <div class="container mt-1 md:mt-50">
            <div class="flex flex-row flex-wrap">
                <div v-for="(special, index) in specials" :key="index" class="max-w-1/3 h-pc-319 mb-pc-25">
                    <div class="mx-pc-25 rounded-4px h-full">
                        <div class="border border-blue-light h-pc-226 rounded-t-4px">
                            <img :src="special.image" height="226" class="w-full rounded-t-4px">
                        </div>
                        <div>
                            <div>
                                <h4>{{ special.title }}</h4>
                                <p>{{ special.desc }}</p>
                            </div>
                            <img src="" alt="">
                        </div>
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
            specials: this.attributes
        }
    }
}
</script>