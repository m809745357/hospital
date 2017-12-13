<template>
    <div class="container mx-auto">
        <div class="parcel-index">
            <div class="parcel-menu" @touchmove="touch">
                <a :class="menu == 'expert' ? 'on' : ''" @click="changeMenu('expert')">按专家预约</a>
                <a :class="menu == 'date' ? 'on' : ''" @click="changeMenu('date')">按日期预约</a>
            </div>
            <div class="parcel-date" @touchmove="touch" v-if="menu == 'expert'">{{ date }}</div>
            <div class="parcel-date" @touchmove="touch" v-else>
                <li :class="day['1'] == week ? 'on' : ''" v-for="(day, index) in days" :key="index" @click="changeDay(day['1'])">{{ weeks[day['1']] }}<span>{{ day['0'] }}</span></li> 
            </div>
            <div class="parcel-contact">
                <scroll class="parcel-package warpper" :data="schedulings">
                    <div class="content">
                        <div class="doctor-item" v-for="(scheduling, index) in schedulings" :key="index" v-if="week === '' || scheduling.day === week">
                            <img :src="scheduling.doctor.image" alt="">
                            <div class="doctor-item-desc">
                                <div class="doctor-item-right">
                                    <div class="doctor-item-top">
                                        <div class="name-title">
                                            <p><strong>{{ scheduling.doctor.name }}</strong> {{ scheduling.doctor.title }}</p>
                                            <p>接诊量：{{ scheduling.doctor.recep_num }}</p>
                                        </div>
                                        <a :href="`/scheduling/${scheduling.id}`" v-if="menu == 'expert'">查看</a>
                                        <a :href="`/scheduling/${scheduling.id}`" v-else>预约</a>
                                    </div>
                                    <p>{{ scheduling.doctor.desc }}</p>
                                </div>
                                <div class="depart">
                                    <span>{{ scheduling.doctor.department.name }}</span>
                                </div>
                            </div>
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
            schedulings: this.attributes,
            date: moment().format('L'),
            menu: 'date',
            days: [],
            weeks: [ '日', '一', '二', '三', '四', '五', '六'],
            week: moment().day()
        }
    },
    components: {
        scroll
    },
    created () {
        for (let index = 0; index < 7; index++) {
            this.days[index] = [moment().add(index, 'days').format('MM.DD'), moment().add(index, 'days').day()]
        }  
    },
    methods: {
        touch() {
            event.preventDefault();
        },
        changeMenu(menu) {
            this.menu = menu;
            if (menu === 'date') {
                this.week = moment().day()
            } else {
                this.week = ''
            }
        },
        changeDay(week) {
            this.week = week;
        }
    }
}
</script>
