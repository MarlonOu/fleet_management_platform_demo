<template>
    <div class="py-5">
        <div class="container">
            <div class="w-75 m-auto p-5 bg-success mb-3">
                <div class="row mb-5 w-100 align-items-center">
                    <div class="col-sm-2">
                        車輛選擇:
                    </div>
                    <div class="col-sm-10">
                        <input type="text" class="form-control">
                    </div>
                </div>
                <div class="row w-100 align-items-center">
                    <div class="col-sm-2">
                        車輛選擇:
                    </div>
                    <div class="col-sm-10">
                        <input type="text" class="form-control">
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
import { useContext, ref, useRouter, onMounted } from '@nuxtjs/composition-api'

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
        const allCarList = ref([])
        const getAllCarLocation = () => {
            if (process.client) {
                if (!localStorage.getItem('auth') || !localStorage.getItem('user')) {
                    router.push('/login')
                }
            }

            $axios.get('api/get-attendance-record')
                .then(({ data }) => {
                    allCarList.value = data
                })
                .catch((e) => {
                    console.log(e)
                })
        }
        getAllCarLocation()
        const show = () => {
            console.log(123)
        }

        return {
            allCarList,
            getAllCarLocation,
            show
        }
    }
}
</script>