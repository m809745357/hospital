<template>
    <div class="flex items-center w-full flex-col">
        <div class="container h-full mt-pc-50">
            <div class="border-l-4 border-blue h-pc-37 text-lg pl-4 md:pl-pc-27 flex items-center mx-4 md:mx-0">门诊预约</div>
        </div>

        <div class="container mt-1 mx-1 md:mx-0 md:mt-pc-50 md:border-t border-grey-lighter px-pc-20 md:p-0">
            <p class="mt-1 md:mt-pc-33 md:mb-pc-20 text-lg">找到<span class="text-blue mx-px">{{ count }}</span>位医生</p>
            <div class="md:h-pc-37 bg-grey-lightest border-b border-grey-lighter flex flex-col md:flex-row items-start md:items-center text-xs text-grey-darkest p-pc-10 md-p-0 mt-1 md:mt-0">
                <div class="flex flex-row items-center h-pc-37">
                    <label class="md:ml-pc-25 w-pc-60">医生名：</label>
                    <input class="md:ml-pc-25 h-pc-25 w-pc-124 border border-grey" placeholder="请输入医生名称" type="text" v-model="filter.name" name="doctor" @change="filterDoctor">
                </div>
                <div class="flex flex-row items-center h-pc-37">
                    <label class="md:ml-pc-25 w-pc-60">选择科室：</label>
                    <select class="md:ml-pc-25 h-pc-25 w-pc-124 border border-grey bg-white text-center" name="department" v-model="filter.department" @change="filterDoctor">
                        <option value="">请选择</option>
                        <option :value="department.id" v-for="(department, index) in departments" :key="index">{{ department.name }}</option>
                    </select>
                </div>
                <div class="flex flex-row items-center h-pc-37">
                    <label class="md:ml-pc-25 w-pc-60">门诊时间：</label>
                    <select class="md:ml-pc-25 h-pc-25 w-pc-124 border border-grey bg-white" name="day" id="" v-model="filter.day" @change="filterDoctor">
                        <option value="">请选择</option>
                        <option :value="index" v-for="(day, index) in days" :key="index">{{ day }}</option>
                    </select>
                    <select class="md:ml-pc-25 h-pc-25 w-pc-124 border border-grey bg-white" name="time" id="" v-model="filter.time" @change="filterDoctor">
                        <option value="">请选择</option>
                        <option :value="index + 1" v-for="(time, index) in times" :key="index">{{ time }}</option>
                    </select>
                </div>
            </div>
            <div class="h-pc-37 bg-grey-lightest border-b border-grey-lighter flex items-center justify-center p-pc-10 md-p-0">
                <p class="text-sm text-red">重要说明：出诊信息仅供参考，如果有变动，以门诊公布为准</p>
            </div>
            <div class="fixed w-full pin-t pin-l h-full flex items-center justify-center z-10" v-if="show" @click="show = false">
                <img :src="qrcode" alt="">
            </div>
            <div v-if="doctors" class="md:border md:border-grey-lighter flex flex-col md:flex-row max-w-full mb-pc-20 md:mt-0 mt-1 shadow" v-for="(doctor, index) in doctors" :key="index">
                <div class="w-full md:w-1/5 md:border-r md:border-grey-ligter flex items-center md:ml-pc-50 py-pc-10">
                    <img :src="'/uploads/' + doctor.image" class="w-pc-60 h-pc-60 rounded-1/2 border border-grey-ligter">
                    <div class="ml-pc-10 flex-1">
                        <h4 class="text-orange text-sm font-normal">{{ doctor.name }} <span class="text-grey-dark">{{ doctor.title }}</span></h4>
                        <p class="mt-pc-6 text-grey-darkest">{{ doctor.department.name }}</p>
                    </div>
                </div>
                <div class="md:w-pc-432 flex items-center max-w-full md:px-pc-33 py-pc-10">
                    <p class="text-sm text-grey-dark">
                        <strong class="text-sm text-grey-darkest font-normal">擅长：</strong>
                        {{ doctor.desc }}
                    </p>
                </div>
                <div class="flex-1">
                    <table border="1" class="w-full" style="border-collapse:collapse;">
                        <tr class="text-sm text-grey-darkest">
                            <th width="25%" class="font-normal">出诊类别</th>
                            <th width="25%" class="font-normal">时间</th>
                            <th width="25%" class="font-normal">地点</th>
                            <th width="25%" class="font-normal">诊查费</th>
                        </tr>
                        <tr class="text-sm" v-for="(scheduling, index) in doctor.schedulings" :key="index" v-if="filter.day === '' || (filter.day !== '' && filter.day === scheduling.day)">
                            <td v-if="scheduling.type === 'general'" class="text-orange">{{ typeDisplay(scheduling.type) }}</td>
                            <td v-if="scheduling.type === 'expert'" class="text-blue">{{ typeDisplay(scheduling.type) }}</td>
                            <td v-if="scheduling.type === 'famous'" class="text-green">{{ typeDisplay(scheduling.type) }}</td>
                            <td class="text-grey-dark">{{ days[scheduling.day] }} {{ times[scheduling.time - 1] }}</td>
                            <td class="text-grey-dark">{{ scheduling.address }}</td>
                            <td class="text-green">{{ scheduling.money }}元</td>
                        </tr>
                    </table>
                </div>
                <div class="hidden md:w-pc-165 md:flex items-center justify-center">
                    <button class="bg-blue-light w-3/4 my-pc-10 md:w-pc-98 h-pc-30 text-sm text-blue-darkest" @click="show = true" type="button">挂号</button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: ['attributes', 'categories'],
    data () {
        return {
            doctors: this.attributes,
            count: this.attributes.length,
            departments: this.categories,
            filter: {
                name: '',
                department: '',
                day: '',
                time: '',
            },
            days: [
                '星期日', '星期一', '星期二', '星期三', '星期四', '星期五', '星期六'
            ],
            times: [
                '上午', '下午', '全天'
            ],
            source: '',
            qrcode: window.App.qrcode,
            show: false
        }
    },
    created() {
        console.log(this.doctors);
    },
    methods: {
        url() {
            return `/schedulings?name=${this.filter.name}&department=${this.filter.department}&day=${this.filter.day}&time=${this.filter.time}`;
        },
        filterDoctor() {
            var CancelToken = axios.CancelToken;
            if(this.source) {
                this.source.cancel('Operation canceled by the user.');
            }

            this.source = CancelToken.source();
            console.log(this.filter);

            axios.get(this.url(), { cancelToken: this.source.token })
                .then(response => {
                    console.log(response.data)
                    this.doctors = response.data;
                })
                .catch(thrown => {
                    if (axios.isCancel(thrown)) {
                        console.log('Request canceled', thrown.message);
                    } else {
                        // handle error
                    }
                });

        },
        typeDisplay(type) {
            switch (type) {
                case 'expert':
                    return '专家门诊';
                    break;
                case 'general':
                    return '普通门诊';
                    break;
                case 'famous':
                    return '名医门诊';
                    break;
            }
        }
        
    }
  
}
</script>
