<template>
    <div class="py-5">
        <div class="container">
            <div>
                <h1 class="text-center">SwiSys車隊管理平台 ESG 車輛查詢結果</h1>
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
                                    車輛品牌:
                                </div>
                                <div>
                                    {{ modal.vehicle_brand }}
                                </div>
                            </div>
                            <div class="mb-2 d-flex justify-content-between">
                                <div>
                                    車輛型式:
                                </div>
                                <div>
                                    {{ modal.vehicle_model }}
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
                                    碳排放:
                                </div>
                                <div>
                                    {{ modal.co2_emission }}
                                </div>
                            </div>
                        </div>
                        <div>
                            <line-chart :chart="mixSpeed" :chart2="speed" :chart3="rotatingSpeed" :chart4="oxygenSensor"
                                :chart5="shortFuel" :chart6="fuelRate" :chart7="massAirFlow" :chart8="airFuelRatio">
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
                title: { text: '轉速 (Engine Speed)' },
                xAxis: {
                    type: 'category',
                    data: modal.value.date_time
                },
                yAxis: {
                    type: 'value',
                    name: '單位: rpm'
                },
                tooltip: {
                    trigger: 'axis'
                },
                grid: {
                    left: '10%',
                    right: '15%',
                    bottom: '10%',
                    containLebel: true
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
                title: { text: '時速 (Speed)' },
                xAxis: {
                    type: 'category',
                    data: modal.value.date_time
                },
                yAxis: {
                    type: 'value',
                    name: '單位: km/h'
                },
                tooltip: {
                    trigger: 'axis'
                },
                grid: {
                    left: '10%',
                    right: '15%',
                    bottom: '10%',
                    containLebel: true
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
                    text: 'Speed & Engine Speed',
                    left: 'center'
                },
                legend: {
                    data: ['時速', '轉速'],
                    left: 10
                },
                grid: {
                    bottom: 80,
                    containLebel: true
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
                        name: '時速 (km/h)',
                        type: 'value'
                    },
                    {
                        name: '轉速 (rpm)',

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



        const oxygenSensor = computed(() => {
            const oxygenSensor = {
                title: { text: '含氧感知器電壓 (Oxygen Sensor)' },
                xAxis: {
                    type: 'category',
                    data: modal.value.date_time
                },
                tooltip: {
                    trigger: 'axis'
                },
                grid: {
                    left: '10%',
                    right: '15%',
                    bottom: '10%',
                    containLebel: true
                },
                yAxis: {
                    type: 'value',
                    name: '單位: V'
                },
                series: [
                    {
                        data: modal.value.oxygen_sensor,
                        type: 'line'
                    }
                ],
                dataZoom: [

                    {
                        type: 'inside'
                    }
                ],
            }

            return oxygenSensor

        })





        const shortFuel = computed(() => {
            const shortFuel = {
                title: { text: '短期燃油修正比 (Short Fuel)' },
                xAxis: {
                    type: 'category',
                    data: modal.value.date_time
                },
                yAxis: {
                    type: 'value',
                    name: '單位: %'
                },
                tooltip: {
                    trigger: 'axis'
                },
                grid: {
                    left: '10%',
                    right: '15%',
                    bottom: '10%',
                    containLebel: true
                },
                series: [
                    {
                        data: modal.value.short_fuel,
                        type: 'line'
                    }
                ],
                dataZoom: [

                    {
                        type: 'inside'
                    }
                ],
            }

            return shortFuel


        })
        const fuelRate = computed(() => {
            const fuelRate = {
                title: { text: '耗油量 (Fuel Rate)' },
                xAxis: {
                    type: 'category',
                    data: modal.value.date_time
                },
                yAxis: {
                    type: 'value',
                    name: '單位: L/h'
                },
                tooltip: {
                    trigger: 'axis'
                },
                grid: {
                    left: '10%',
                    right: '15%',
                    bottom: '10%',
                    containLebel: true
                },
                series: [
                    {
                        data: modal.value.fuel_rate,
                        type: 'line'
                    }
                ],
                dataZoom: [

                    {
                        type: 'inside'
                    }
                ],
            }

            return fuelRate




        })
        const massAirFlow = computed(() => {
            const massAirFlow = {
                title: { text: '空氣流量 (Mass Air Flow)' },
                xAxis: {
                    type: 'category',
                    data: modal.value.date_time
                },
                yAxis: {
                    type: 'value',
                    name: '單位: g/s'
                },
                tooltip: {
                    trigger: 'axis'
                },
                grid: {
                    left: '10%',
                    right: '15%',
                    bottom: '10%',
                    containLebel: true
                },
                series: [
                    {
                        data: modal.value.mass_air_flow,
                        type: 'line'
                    }
                ],
                dataZoom: [

                    {
                        type: 'inside'
                    }
                ],
            }

            return massAirFlow




        })
        const airFuelRatio = computed(() => {
            const airFuelRatio = {
                title: { text: '空燃比 (Air Fuel Ratio)' },
                xAxis: {
                    type: 'category',
                    data: modal.value.date_time
                },
                yAxis: {
                    type: 'value',
                    name: '無單位，例: 14:1'
                },
                tooltip: {
                    trigger: 'axis'
                },
                grid: {
                    left: '10%',
                    right: '15%',
                    bottom: '10%',
                    containLebel: true
                },
                series: [
                    {
                        data: modal.value.air_fuel_ratio,
                        type: 'line'
                    }
                ],
                dataZoom: [

                    {
                        type: 'inside'
                    }
                ],
            }

            return airFuelRatio
        })

        return {
            modal,
            loadingData,
            rotatingSpeed,
            speed,
            mixSpeed,
            oxygenSensor,
            shortFuel,
            fuelRate,
            massAirFlow,
            airFuelRatio
        }
    }
})
</script>
