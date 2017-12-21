<template>
    <div class="container mx-auto">
        <div class="parcel-index">
            <div class="parcel-menu" @touchmove="touch">
                <a :class="menu == 'expert' ? 'on' : ''" @click="changeMenu('expert')">按专家预约</a>
                <a :class="menu == 'date' ? 'on' : ''" @click="changeMenu('date')">按日期预约</a>
            </div>
            <div class="parcel-date" @touchmove="touch" v-if="menu == 'expert'">
                <input type="search" name="search" value="" v-model="keyword"  placeholder="输入医生名搜索">
            </div>
            <div class="parcel-date" @touchmove="touch" v-else>
                <li :class="day['1'] == week ? 'on' : ''" v-for="(day, index) in days" :key="index" @click="changeDay(day['1'], index)">{{ weeks[day['1']] }}<span>{{ day['0'] }}</span></li> 
            </div>
            <div class="parcel-contact">
                <scroll class="parcel-package warpper" :data="schedulings">
                    <div class="content">
                        <div class="doctor-item" 
                            v-for="(scheduling, index) in schedulings" 
                            :key="index" 
                            v-if="(keyword !== '' && scheduling.doctor.name.indexOf(keyword) > -1 && scheduling.doctor.status === 1) || ( keyword === '' && ( week === '' || scheduling.day === week ) && scheduling.doctor.status === 1)">
                            <div class="doctor-item-left">
                                <img :src="scheduling.doctor.image" alt="">
                                <h4>{{ types[scheduling.type] }}</h4>
                            </div>
                            <div class="doctor-item-desc">
                                <div class="doctor-item-right">
                                    <div class="doctor-item-top">
                                        <div class="name-title">
                                            <p><strong>{{ scheduling.doctor.name }}</strong> {{ scheduling.doctor.title }}</p>
                                            <p>接诊量：{{ scheduling.doctor.recep_num }} {{ scheduling.doctor.department.name }}</p>
                                        </div>
                                        <a @click="settle(index)">￥{{ scheduling.money }} 预约</a>
                                    </div>
                                    <p>{{ scheduling.doctor.desc }}</p>
                                </div>
                                <div class="depart">
                                    <span>{{ scheduling.address }}</span>
                                    <p>{{ days_display[scheduling.day] }} {{ times[scheduling.time] }}</p>
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
            days_display: [],
            weeks: [ '日', '一', '二', '三', '四', '五', '六'],
            week: moment().day(),
            week_inex: '',
            types: {
                expert: '专家门诊',
                general: '普通门诊',
                famous: '名医门诊',
            },
            times: [
                '', '上午', '下午', '全天'
            ],
            keyword: ''
        }
    },
    components: {
        scroll
    },
    created () {
        for (let index = 0; index < 7; index++) {
            let day = moment().add(index, 'days');
            this.days[index] = [day.format('MM.DD'), day.day(), day.format('YYYY年MM月DD日')];
            this.days_display[day.day()] = day.format('YYYY年MM月DD日');
        }  
    },
    methods: {
        touch() {
            event.preventDefault();
        },
        changeMenu(menu) {
            this.menu = menu;
            if (menu === 'date') {
                this.week = moment().day(),
                this.keyword = ''
            } else {
                this.week = ''
            }
        },
        changeDay(week, index) {
            this.week = week;
            this.week_inex = index;
        },
        settle(index) {
            let order_time = this.days_display[this.schedulings[index].day] + ' ' + this.times[this.schedulings[index].time];
            axios.post('/orders', {
                    order_details: this.schedulings[index],
                    order_details_type: 'App\\Models\\Scheduling',
                    money: this.schedulings[index].money,
                    order_time: order_time
                })
                .then(response => {
                    console.log(response);
                    window.location.href = `/orders/${response.data.data.id}`;
                })
                .catch(error => {
                    if (error.response.status === 400) {
                        this.$alert(error.response.data.data);
                        return ;
                    }
                    console.log(error.response);
                })
        }
    }
}
</script>
