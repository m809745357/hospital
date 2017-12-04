<template>
    <div class="flex items-center w-full flex-col">
        <div class="container h-full mt-pc-50">
            <div class="border-l-4 border-blue h-pc-37 text-lg pl-4 md:pl-pc-27 flex items-center mx-4 md:mx-0">在线取报告单</div>
        </div>

        <div class="container mt-pc-50">
            <div class="report" v-if="judgeScreen">
                <input type="text" name="report" placeholder="请输入报告单号">
                <button type="button">查询</button>
            </div>
            <div v-else class="flex flex-col max-w-full m-pc-20 h-pc-98 items-center justify-around">
                <input type="text" name="report" class="w-full" placeholder="请输入报告单号">
                <button type="button" class="bg-blue w-full text-lg h-pc-30 text-white shadow">查询</button>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data () {
        return {
            
        }
    },
    computed: {
        judgeScreen() {
            return window.screen.width > 768;
        }  
    },
}
</script>
