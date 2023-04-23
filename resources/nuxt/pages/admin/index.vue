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
                    <tr v-for="allCar in allCarList">
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
                        <td>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#exampleModal" @click="show()">
                                Launch demo modal
                            </button>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <div ref="modal" class=" modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        ...
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- <line-chart :data="chartData" /> -->
</template>
  
<script>
import { useContext, ref, useRouter, watch, computed } from '@nuxtjs/composition-api'

export default {
    data() {
        return {
            chartData: {
                datasets: [{
                    label: 'My First Dataset',
                    data: [65, 59, 80, 81, 56, 55, 40],
                    fill: false,
                    borderColor: 'rgb(75, 192, 192)',
                    tension: 0.1
                },

                {
                    label: 'My First Dataset',
                    data: [77, 12, 33, 22, 123, 22, 1],
                    fill: false,
                    borderColor: 'rgb(75, 192, 122)',
                    tension: 0.1
                }
                ]
            }
        };
    },
    setup() {
        const { $axios } = useContext()
        const router = useRouter()
        const allCarDetailsList = ref([])
        const loading = ref(false)
        const getAllCarLocation = () => {
            if (process.client) {
                if (!localStorage.getItem('auth') || !localStorage.getItem('user')) {
                    router.push('/login')
                }
            }
        }
        getAllCarLocation()
        const show = () => {
            console.log(123)
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
            submit
        }
    }
}
</script>
<style lang="scss">
.form-select:disabled {
    background-color: dimgrey !important;
}
</style>