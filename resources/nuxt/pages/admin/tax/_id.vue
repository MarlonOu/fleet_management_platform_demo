<template>
    <div class="py-5">
        <div class="container">
            <div>
                <h1>SwiSys車隊管理平台 ESG 車輛查詢結果</h1>
                <div>
                    <div v-if="loadingData" class="text-center">
                        <h5 class="fw-bold mb-5 text-primary">
                            資料讀取中..
                        </h5>
                    </div>
                    <div v-else>
                        <div class="px-3 w-50 m-auto">
                            <div class="mb-2 d-flex justify-content-between">
                                <div>
                                    車隊統編:
                                </div>
                                <div>
                                    {{ modal.tax_id }}
                                </div>
                            </div>
                            <div class="mb-2 d-flex justify-content-between">
                                <div>
                                    車牌號碼:
                                </div>
                                <div>
                                    {{ modal.licence_plate }}
                                </div>
                            </div>
                            <div class="mb-2 d-flex justify-content-between">
                                <div>
                                    駕駛人:
                                </div>
                                <div>
                                    {{ modal.driver_name }}
                                </div>
                            </div>
                            <div class="mb-2 d-flex justify-content-between">
                                <div>
                                    任務啟動時間:
                                </div>
                                <div>
                                    {{ modal.task_start_sime }}
                                </div>
                            </div>
                            <div class="mb-2 d-flex justify-content-between">
                                <div>
                                    任務結束時間:
                                </div>
                                <div>
                                    {{ modal.task_end_time }}
                                </div>
                            </div>
                            <div class="mb-2 d-flex justify-content-between">
                                <div>
                                    任務持續時間:
                                </div>
                                <div>
                                    {{ modal.time }}
                                </div>
                            </div>
                            <div class="mb-2 d-flex justify-content-between">
                                <div>
                                    任務行駛總里程:
                                </div>
                                <div>
                                    {{ modal.mileage }}
                                </div>
                            </div>
                            <div class="mb-2 d-flex justify-content-between">
                                <div>
                                    碳排放:
                                </div>
                                <div>
                                    {{ modal.co2_emission }}
                                </div>
                            </div>
                        </div>
                        <div>
                            <line-chart :chart="mixSpeed" :chart2="speed" :chart3="rotatingSpeed" :chart4="average"
                                :chart5="idle" :chart6="idle_hours" :chart7="instant_fuel" :chart8="odo_mileage">
                            </line-chart>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import { useContext, ref, useRoute, computed, defineComponent } from '@nuxtjs/composition-api'

export default defineComponent({

    setup() {
        const { $axios } = useContext()
        const route = useRoute()
        const loadingData = ref(false)
        const modal = ref('')
        const show = () => {
            loadingData.value = true
            loadingData.value = true
            $axios.get(`api/get-history-data/${route.value.params.id}`)
                .then(({ data }) => {
                    modal.value = data
                })
                .catch((e) => {
                    console.log(e)
                })
                .finally(() => {
                    loadingData.value = false
                })
        }
        show()
        const rotatingSpeed = computed(() => {

            const max = modal.value.engineThreshold
            const rotatingSpeed = {
                title: { text: '轉速' },
                xAxis: {
                    type: 'category',
                    data: modal.value.date_time
                },
                yAxis: {
                    type: 'value'
                },
                tooltip: {
                    trigger: 'axis'
                },
                grid: {
                    left: '5%',
                    right: '15%',
                    bottom: '10%'
                },
                visualMap: {
                    top: 50,
                    right: 10,
                    pieces: [
                        {
                            gt: 0,
                            lte: max - 1,
                            color: '#93CE07'
                        },

                        {
                            gt: max,
                            color: '#AC3B2A'
                        }
                    ],
                    outOfRange: {
                        color: '#999'
                    }
                },
                series: [
                    {
                        data: modal.value.engine_speed,
                        type: 'line'
                    }
                ],
                dataZoom: [

                    {
                        type: 'inside'
                    }
                ],
            }

            return rotatingSpeed


        })
        const speed = computed(() => {
            const max = modal.value.speedThreshold
            const speed = {
                title: { text: '時速' },
                xAxis: {
                    type: 'category',
                    data: modal.value.date_time
                },
                yAxis: {
                    type: 'value'
                },
                tooltip: {
                    trigger: 'axis'
                },
                grid: {
                    left: '5%',
                    right: '15%',
                    bottom: '10%'
                },
                visualMap: {
                    top: 50,
                    right: 10,
                    pieces: [
                        {
                            gt: 0,
                            lte: max - 1,
                            color: '#93CE07'
                        },

                        {
                            gt: max,
                            color: '#AC3B2A'
                        }
                    ],
                    outOfRange: {
                        color: '#999'
                    }
                },
                series: [
                    {
                        data: modal.value.speed,
                        type: 'line'
                    }
                ],
                dataZoom: [

                    {
                        type: 'inside'
                    }
                ],
            }

            return speed

        })
        const mixSpeed = computed(() => {

            const colors = ['#5470C6', '#EE6666'];
            const mix = {
                title: {
                    text: 'Rainfall and Flow Relationship',
                    left: 'center'
                },
                grid: {
                    bottom: 80
                },
                toolbox: {
                    feature: {
                        dataZoom: {
                            yAxisIndex: 'none'
                        },
                        restore: {},
                        saveAsImage: {}
                    }
                },
                tooltip: {
                    trigger: 'axis',

                },
                legend: {
                    data: ['Flow', 'Rainfall'],
                    left: 10
                },
                dataZoom: [
                    {
                        show: true,
                        realtime: true,
                        start: 65,
                        end: 85
                    },
                    {
                        type: 'inside',
                        realtime: true,
                        start: 65,
                        end: 85
                    }
                ],
                xAxis: [
                    {
                        type: 'category',
                        data: modal.value.date_time
                    }
                ],
                yAxis: [
                    {
                        name: '時速',
                        type: 'value'
                    },
                    {
                        name: '轉速',

                        type: 'value',

                    }
                ],
                series: [
                    {
                        name: '時速',
                        type: 'line',
                        // prettier-ignore
                        data: modal.value.speed,
                    },
                    {
                        name: '轉速',
                        type: 'line',
                        yAxisIndex: 1,

                        // prettier-ignore
                        data: modal.value.engine_speed,
                    }
                ]
            };
            return mix
        })



        const average = computed(() => {
            const average = {
                title: { text: '平均油耗' },
                xAxis: {
                    type: 'category',
                    data: modal.value.date_time
                },
                tooltip: {
                    trigger: 'axis'
                },
                grid: {
                    left: '5%',
                    right: '15%',
                    bottom: '10%'
                },
                yAxis: {
                    type: 'value'
                },
                series: [
                    {
                        data: modal.value.average_fuel,
                        type: 'line'
                    }
                ],
                dataZoom: [

                    {
                        type: 'inside'
                    }
                ],
            }

            return average

        })





        const idle = computed(() => {
            const idle = {
                title: { text: '怠速油耗(idle_fuel)' },
                xAxis: {
                    type: 'category',
                    data: modal.value.date_time
                },
                yAxis: {
                    type: 'value'
                },
                tooltip: {
                    trigger: 'axis'
                },
                grid: {
                    left: '5%',
                    right: '15%',
                    bottom: '10%'
                },
                series: [
                    {
                        data: modal.value.idle_fuel,
                        type: 'line'
                    }
                ],
                dataZoom: [

                    {
                        type: 'inside'
                    }
                ],
            }

            return idle


        })
        const idle_hours = computed(() => {
            const idle_hours = {
                title: { text: '空轉時間(idle_hours)' },
                xAxis: {
                    type: 'category',
                    data: modal.value.date_time
                },
                yAxis: {
                    type: 'value'
                },
                tooltip: {
                    trigger: 'axis'
                },
                grid: {
                    left: '5%',
                    right: '15%',
                    bottom: '10%'
                },
                series: [
                    {
                        data: modal.value.idle_hours,
                        type: 'line'
                    }
                ],
                dataZoom: [

                    {
                        type: 'inside'
                    }
                ],
            }

            return idle_hours




        })
        const instant_fuel = computed(() => {
            const instant_fuel = {
                title: { text: '順時油耗(instant_fuel)' },
                xAxis: {
                    type: 'category',
                    data: modal.value.date_time
                },
                yAxis: {
                    type: 'value'
                },
                tooltip: {
                    trigger: 'axis'
                },
                grid: {
                    left: '5%',
                    right: '15%',
                    bottom: '10%'
                },
                series: [
                    {
                        data: modal.value.instant_fuel,
                        type: 'line'
                    }
                ],
                dataZoom: [

                    {
                        type: 'inside'
                    }
                ],
            }

            return instant_fuel




        })
        const odo_mileage = computed(() => {
            const mileage = {
                title: { text: '總里程數(odo_mileage)' },
                xAxis: {
                    type: 'category',
                    data: modal.value.odo_mileage
                },
                yAxis: {
                    type: 'value'
                },
                tooltip: {
                    trigger: 'axis'
                },
                grid: {
                    left: '5%',
                    right: '15%',
                    bottom: '10%'
                },
                series: [
                    {
                        data: modal.value.engine_speed,
                        type: 'line'
                    }
                ],
                dataZoom: [

                    {
                        type: 'inside'
                    }
                ],
            }

            return mileage
        })

        return {
            modal,
            loadingData,
            rotatingSpeed,
            speed,
            mixSpeed,
            average,
            idle,
            idle_hours,
            instant_fuel,
            odo_mileage
        }
    }
})
</script>
