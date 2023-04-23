<template>
    <div class="py-5">
        <div class="container">
            <div>
                <h1>詳細資料</h1>
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
                            <label class="block mb-2 font-bold"> 時速/轉速 </label>
                            <client-only>
                                <line-chart :data="mixSpeed" />
                            </client-only>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-6">
                                <client-only>
                                    <line-chart :data="speed" />
                                </client-only>
                            </div>
                            <div class="col-sm-6">
                                <client-only>
                                    <line-chart :data="rotatingSpeed" />
                                </client-only>
                            </div>
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
            const data = modal.value.engine_speed
            const time = modal.value.date_time
            const datasets = [{

                label: '轉速',
                data: data,
                fill: false,
                borderColor: 'rgb(75, 192, 192)',
                tension: 1
            }]
            const engine_speed = {
                labels: time,
                datasets
            }
            return engine_speed
        })
        const speed = computed(() => {
            const data = modal.value.speed
            const time = modal.value.date_time
            const datasets = [{

                label: '時速',
                data: data,
                fill: false,
                borderColor: 'rgb(155, 92, 122)',
                tension: 0.1
            }]
            const speed = {
                labels: time,
                datasets
            }
            return speed
        })
        const mixSpeed = computed(() => {
            const engine_speed = modal.value.engine_speed
            const speed = modal.value.speed
            const time = modal.value.date_time
            const datasets = [
                {
                    label: '轉速',
                    data: engine_speed,
                    circular: true,
                    fill: false,
                    borderColor: 'rgb(75, 192, 192)',
                    tension: 0.1
                },
                {
                    label: '時速',
                    data: speed,
                    circular: true,
                    fill: false,
                    borderColor: 'rgb(155, 92, 122)',
                    tension: 0.1
                },
            ]
            const mix = {
                labels: time,
                datasets
            }
            return mix
        })
        return {
            modal,
            loadingData,
            rotatingSpeed,
            speed,
            mixSpeed
        }
    }
})
</script>
