<template>
    <div class="container mx-auto">
        <div class="parcel-index">
            <div class="parcel-menu" @touchmove="touch">
                <a class="on" href="/physicals/packages">套餐体检</a>
                <a href="/physicals/single">单列体检</a>
            </div>
            <div class="parcel-date" @touchmove="touch">{{ date }}</div>
            <div class="parcel-contact">
                <scroll class="parcel-package warpper" :data="packages">
                    <div class="content">
                        <div class="package-item" v-for="(pack, index) in packages" :key="index">
                            <img :src="'/uploads/' + pack.image" alt="">
                            <div class="package-item-desc">
                                <h4>{{ pack.title }}</h4>
                                <p>男：￥{{ pack.men_money }}</p>
                                <p>女：￥{{ pack.women_money }}</p>
                            </div>
                            <a :href="'/physicals/packages/' + pack.id">预约</a>
                        </div>
                    </div>
                </scroll>
            </div>
        </div>
    </div>
</template>
<script>
import scroll from '../components/Scroll.vue';
import BScroll from 'better-scroll';
export default {
    props: ['attributes'],
    data () {
        return {
            packages: this.attributes,
            date: moment().format('L'),
        }
    },
    components: {
        scroll
    },
    methods: {
        touch() {
            event.preventDefault();
        },
    }
}
</script>
