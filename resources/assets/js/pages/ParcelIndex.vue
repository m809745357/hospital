<template>
    <div class="conatiner mx-auto">
        <div class="parcel-index">
            <div class="parcel-menu">
                <a class="on" href="">午餐</a>
                <a href="">晚餐</a>
            </div>
            <div class="parcel-date">
                {{ date }}
            </div>
            <div class="parcel-contact">
                <div class="parcel-channel">
                    <div v-for="(channel, index) in channels" :key="index">
                        <li>{{ channel.name }}</li>
                    </div>
                </div>
                <div class="parcel-food">
                    <div class="parcel-food-channel" v-for="(channel, index) in channels" :key="index">
                        <div class="parcel-food-contact" v-for="(food, index) in channel.food" :key="index">
                            <img :src="food.image" alt="">
                            <div class="parcel-food-desc">
                                <h4>{{ food.title }}</h4>
                                <p>{{ food.desc }}</p>
                                <span>{{ food.money }}</span>
                            </div>
                            <div class="parcel-food-options">
                                <img src="" alt="">
                                <span></span>
                                <img src="" alt="">
                            </div>
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
            channels: this.attributes,
            date: moment().format('L')
        }
    }
}
</script>
