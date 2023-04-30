<template>
    <div class="py-5">
        <div class="container">
            <div class="w-75 m-auto p-5 bg-success mb-3">
                <div class="row mb-5 w-100 align-items-center">
                    <div class="col-sm-2">
                        車輛選擇:
                    </div>
                    <div class="col-sm-10">
                        <select v-model="licence_plate" class="form-select">
                            <option :value="null" disabled>請選擇</option>
                            <option v-for="car in allCarList" :value="car">
                                {{ car }}
                            </option>
                        </select>
                    </div>
                </div>
                <div class="row w-100 align-items-center mb-5">
                    <div class="col-sm-2">
                        車輛駕駛人選擇:
                    </div>
                    <div class="col-sm-10">
                        <select v-model="driver_name" class="form-select" :disabled="disabled">
                            <option :value="null" disabled>請選擇</option>
                            <option v-for="name in allCarNameList" :value="name">
                                {{ name }}
                            </option>
                        </select>
                    </div>
                </div>
                <div class="row align-items-center ">
                    <div class="col-sm-5">
                        <button @click="submit()" class="w-100 btn btn-primary">送出</button>
                    </div>
                    <div class="col-sm-2"></div>
                    <div class="col-sm-5">
                        <button @click="clear()" class="w-100 btn btn-danger">移除</button>
                    </div>

                </div>
            </div>
            <div class="w-75 m-auto p-5 bg-warning">
                <table class="w-100">
                    <tr>
                        <th>任務</th>
                        <th>車牌號碼</th>
                        <th>駕駛人</th>
                        <th>任務開始時間</th>
                        <th>任務結束時間</th>
                        <th>任務持續時間</th>
                        <th>查看任務資訊</th>
                    </tr>
                    <tr v-for="allCar in allCarDetailsList">
                        <td>
                            {{ allCar.task_number }}
                        </td>
                        <td>
                            {{ allCar.licence_plate }}
                        </td>
                        <td>
                            {{ allCar.driver_name }}
                        </td>
                        <td>
                            {{ allCar.task_start_time }}
                        </td>
                        <td>
                            {{ allCar.task_end_time }}
                        </td>
                        <td>
                            {{ allCar.time }}
                        </td>
                        <td v-if="type === '1'">
                            <NuxtLink :to="'admin/obdii/' + allCar.task_number" target="_blank" class="btn btn-danger">查看
                            </NuxtLink>
                        </td>
                        <td v-else>
                            <NuxtLink :to="'admin/tax/' + allCar.task_number" target="_blank" class="btn btn-danger">查看
                            </NuxtLink>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <!-- <div class=" modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">詳細資料</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div v-if="loadingData" class="text-center">
                            <h1>
                                資料讀取中
                            </h1>

                        </div>
                        <div v-else>
                            <div class="w-75 m-auto">
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
        </div> -->
    </div>
</template>
  
<script>
import { useContext, ref, useRouter, watch, computed, defineComponent } from '@nuxtjs/composition-api'

export default defineComponent({

    setup() {
        const { $axios } = useContext()
        const router = useRouter()
        const type = ref(null)
        const allCarDetailsList = ref([])
        const loading = ref(false)
        const getAllCarLocation = () => {
            if (process.client) {
                if (!localStorage.getItem('auth') || !localStorage.getItem('user')) {
                    router.push('/login')
                }
                if (localStorage.getItem('vehicle_type')) {
                type.value = localStorage.getItem('vehicle_type')
                }
            }
        }
        getAllCarLocation()
        const loadingData = ref(false)
        const modal = ref('')
        const show = (val) => {
            if (type.value)
                router.push(`admin/obdii/${val}`)
            else
                router.push(`admin/tax/${val}`)
        }
        const disabled = computed(() => {
            if (loading.value || !licence_plate.value) {
                return true
            } else {
                return false
            }
        })
        const licence_plate = ref(null)
        const driver_name = ref(null)
        const allCarList = ref([])
        const allCarNameList = ref([])
        const getAllCarList = () => {
            $axios.get('api/get-attendance-record')
                .then(({ data }) => {
                    allCarList.value = data
                })
                .catch((e) => {
                    console.log(e)
                })
        }
        const getAllNameList = (val) => {
            loading.value = true
            driver_name.value = null
            $axios.get(`api/get-attendance-record/${val}`)
                .then(({ data }) => {
                    allCarNameList.value = data
                })
                .catch((e) => {
                    console.log(e)
                })
                .finally(() => {
                    loading.value = false
                })
        }
        watch(licence_plate, (val) => {
            getAllNameList(val)
        })
        getAllCarList()

        const submit = () => {
            const payload = {
                licence_plate: licence_plate.value,
                driver_name: driver_name.value
            }
            $axios.post('api/get-attendance-detail-record', payload)
                .then(({ data }) => {
                    allCarDetailsList.value = data
                })
                .catch((e) => {
                    console.log(e)
                })

        }
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
                fill: true,
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
                    fill: true,
                    borderColor: 'rgb(75, 192, 192)',
                    tension: 0.1
                },
                {
                    label: '時速',
                    data: speed,
                    circular: true,
                    fill: true,
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
        const clear = () => {
            licence_plate.value = null
            driver_name.value = null
        }
        return {
            allCarDetailsList,
            getAllCarLocation,
            show,
            licence_plate,
            allCarList,
            driver_name,
            allCarNameList,
            loading,
            disabled,
            submit,
            modal,
            loadingData,
            rotatingSpeed,
            speed,
            mixSpeed,
            type,
            clear
        }
    }
})
</script>
<style lang="scss">
.form-select:disabled {
    background-color: dimgrey !important;
}
</style>