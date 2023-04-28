<template>
    <div id="echarts">
        <div class="row mb-3">
            <div class="col-sm-6">
                <label class="block mb-2 font-bold"> Correlations分析 </label>

                <div id="myChart" />

            </div>

        </div>
        <hr>
        <div class="row mb-3">
            <label class="block mb-2 font-bold"> Over/Under Threshold 分析 </label>
            <div class="col-sm-6">

                <div id="myChart2" />

            </div>
            <div class="col-sm-6">

                <div id="myChart3" />

            </div>
        </div>
        <div class="row mb-3">
            <div class="col-sm-6">

                <div id="myChart4" />

            </div>
            <div class="col-sm-6">

                <div id="myChart5" />

            </div>
        </div>
        <div class="row mb-3">
            <div class="col-sm-6">
                <div id="myChart6" />
            </div>
            <div class="col-sm-6">
                <div id="myChart7" />
            </div>
        </div>
        <div class="col-sm-6">
            <div id="myChart8" />
        </div>
    </div>
</template>
<script>
export default {
    name: 'Echarts',
    props: {
        chart: {
            type: Object,
            default: null
        },
        chart2: {
            type: Object,
            default: null
        },
        chart3: {
            type: Object,
            default: null
        },
        chart4: {
            type: Object,
            default: null
        },
        chart5: {
            type: Object,
            default: null
        },
        chart6: {
            type: Object,
            default: null
        },
        chart7: {
            type: Object,
            default: null
        },
        chart8: {
            type: Object,
            default: null
        }
    },
    data() {
        return {}
    },
    mounted() {
        this.echartsInit()
        this.echartsInit2()
        this.echartsInit3()
        this.echartsInit4()
        this.echartsInit5()
        this.echartsInit6()
        this.echartsInit7()
        this.echartsInit8()
    },
    methods: {
        echartsInit() {
            // 找到容器
            const chart = this.chart
            const myChart = this.$echarts.init(document.getElementById('myChart'))
            // 开始渲染

            myChart.setOption(chart)
        },
        echartsInit2() {
            const chart2 = this.chart2
            const myChart = this.$echarts.init(document.getElementById('myChart2'))
            myChart.setOption(chart2)
        },
        echartsInit3() {
            const chart3 = this.chart3
            // 找到容器
            const myChart = this.$echarts.init(document.getElementById('myChart3'))
            // 开始渲染

            myChart.setOption(chart3)
        },
        echartsInit4() {
            const chart4 = this.chart4
            const myChart = this.$echarts.init(document.getElementById('myChart4'))
            myChart.setOption(chart4)
        },
        echartsInit5() {
            const chart5 = this.chart5
            // 找到容器
            const myChart = this.$echarts.init(document.getElementById('myChart5'))
            // 开始渲染

            myChart.setOption(chart5)
        },
        echartsInit6() {
            const chart6 = this.chart6
            const myChart = this.$echarts.init(document.getElementById('myChart6'))
            myChart.setOption(chart6)
        },
        echartsInit7() {
            // 找到容器
            const chart7 = this.chart7
            const myChart = this.$echarts.init(document.getElementById('myChart7'))
            // 开始渲染

            myChart.setOption(chart7)
        },
        echartsInit8() {
            const chart8 = this.chart8
            const myChart = this.$echarts.init(document.getElementById('myChart8'))
            myChart.setOption(chart8)
        }

    }
}
</script>
<style lang="scss">
#myChart {
    width: 600px;
    height: 300px;
    margin-left: auto;
    margin-right: auto;
    float: left;
}

#myChart2 {
    width: 600px;
    height: 300px;
    margin-left: auto;
    margin-right: auto;
    float: right;
}

#myChart3 {
    width: 600px;
    height: 300px;
    margin-left: auto;
    margin-right: auto;
    float: right;
}

#myChart4 {
    width: 600px;
    height: 300px;
    margin-left: auto;
    margin-right: auto;
    float: right;
}

#myChart5 {
    width: 600px;
    height: 300px;
    margin-left: auto;
    margin-right: auto;
    float: right;
}

#myChart6 {
    width: 600px;
    height: 300px;
    margin-left: auto;
    margin-right: auto;
    float: right;
}

#myChart7 {
    width: 600px;
    height: 300px;
    margin-left: auto;
    margin-right: auto;
    float: right;
}

#myChart8 {
    width: 600px;
    height: 300px;
    margin-left: auto;
    margin-right: auto;
    float: right;
}
</style>