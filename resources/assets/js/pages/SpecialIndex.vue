<template>
    <div class="flex items-center w-full flex-col">
        <div class="container h-full mt-pc-50">
            <div class="border-l-4 border-blue h-pc-37 text-lg pl-4 md:pl-pc-27 flex items-center mx-4 md:mx-0">医疗特色</div>
        </div>
        <div class="container mt-4 md:mt-pc-50">
            <div class="flex flex-col md:flex-row flex-wrap">
                <div v-for="(special, index) in specials" :key="index" class="max-w-full md:max-w-1/3 h-pc-319 mb-pc-25">
                    <a class="mx-pc-25 rounded-4px h-full block hover:shadow" @click="specialDetail(special.id)">
                        <div class="border border-blue-light h-pc-226 rounded-4px">
                            <!-- <img :src="special.image" class="h-full w-full rounded-4px"> -->
                            <img :src="'/images/i-' + ( index + 1 ) + '.png'" class="h-full w-full rounded-4px">
                        </div>
                        <div class="h-pc-95 flex flex-row items-center justify-between">
                            <div class="w-3/4">
                                <h4 class="text-lg text-grey-darker font-normal truncate">{{ special.title }}</h4>
                                <p class="text-xs text-grey-dark truncate mt-pc-10">{{ special.desc }}</p>
                            </div>
                            <img src="/images/icon-arrow.png" alt="">
                        </div>
                    </a>
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
    },
    methods: {
        specialDetail(id) {
            window.location.href = '/specials/' + id;
        }
    }
}
</script>