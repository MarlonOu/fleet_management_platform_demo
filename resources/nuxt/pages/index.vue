<template>
  <div>
    <div class="row">
      <div :class="{ 'col-sm-12': detailHide, 'col-sm-8': !detailHide }">
        <div style="height:50vh">
          <Map :setLocation="allCarList"></Map>
        </div>

        <div class="bg-success" style="height:50vh; overflow-y:scroll">
          <div class="row py-3">
            <div class="col-3">
              <select class="form-select" v-model="selects" @change="listenSelects">
                <option :value="null" disabled>
                  請選擇車輛
                </option>
                <option v-for="car in getRunCar" :key="car.driver_number" :value="car.driver_number">
                  {{ car.licence_plate }}
                  <span v-if="getSelects.includes(car.driver_number)" style="color: #ff3c00;">(已選)</span>
                </option>
              </select>
            </div>
            <div class="col-3">
              <label class="btn btn-danger" @click="deleteCars()">清除</label>
            </div>
          </div>
          <table v-if="type === '1'" style="width: 100%" class="text-white text-center">
            <tr>
              <th>查看</th>
              <th>駕駛人姓名</th>
              <th>車號</th>
              <th>車輛品牌</th>
              <th>車輛型式</th>
              <th>時速</th>
              <th>轉速</th>
              <th>時間</th>
            </tr>
            <tr v-if="getRunCarsDetails.length > 0" v-for="(carList, index) in getRunCarsDetails">
              <td>
                <button class="btn btn-primary" @click="turnDetail(index)">
                  <img :src="`/${carList.vehicle_brand}/${carList.vehicle_model}.png`" width="50" alt="图片">
                </button>
              </td>
              <td>
                {{ carList.driver_name }}
              </td>
              <td>
                {{ carList.licence_plate }}
              </td>
              <td>
                {{ carList.vehicle_brand }}
              </td>
              <td>
                {{ carList.vehicle_model }}
              </td>
              <td>
                {{ carList.speed }}
              </td>
              <td>
                {{ carList.engine_speed }}
              </td>
              <td>
                {{ carList.date_time }}
              </td>

            </tr>
          </table>
          <table v-else style="width: 100%" class="text-white text-center">
            <tr>
              <th>查看</th>
              <th>駕駛人姓名</th>
              <th>車號</th>
              <th>排放標準</th>
              <th>時速</th>
              <th>轉速</th>
              <th>行駛里程數</th>
              <th>時間</th>
            </tr>
            <tr v-if="getRunCarsDetails.length > 0" v-for="(carList, index) in getRunCarsDetails">
              <td>
                <button class="btn btn-primary" @click="turnDetail(index)">查看</button>
              </td>
              <td>
                {{ carList.driver_name }}
              </td>
              <td>
                {{ carList.licence_plate }}
              </td>
              <td>
                {{ carList.emission_standards }}
              </td>
              <td>
                {{ carList.speed }}
              </td>
              <td>
                {{ carList.engine_speed }}
              </td>
              <td>
                {{ carList.odo_mileage }}
              </td>
              <td>
                {{ carList.date_time }}
              </td>
            </tr>
          </table>
        </div>
      </div>
      <div v-if="!detailHide" class="col-sm-4" style="height:100vh; overflow-y:scroll">
        <div class="text-end fw-bold mt-4">
          <span @click="turnOffDetail()" class="p-3" style="cursor: pointer;">
            <b>X</b>
          </span>
        </div>
        <h4>車輛狀態</h4>
        車號: {{ getRunCarsDetails[getIndex].licence_plate }} <br>
        駕駛人: {{ getRunCarsDetails[getIndex].driver_name }} <br>
        行駛時間: {{ getRunCarsDetails[getIndex].time }}<br>
        是否超時: {{ getRunCarsDetails[getIndex].task_overtime }} <br>
        <hr>
        <h4>車隊即時數據</h4>
        <div class="row text-center">
          <div class="col-sm-6" style="height: 50px">
            時速
            <br>
            <b>{{ getRunCarsDetails[getIndex].speed }}</b>
          </div>
          <div class="col-sm-6" style="height: 50px">
            轉速
            <br>
            <b>{{ getRunCarsDetails[getIndex].engine_speed }}</b>
          </div>
        </div>
        <div class="row text-center">
          <div class="col-sm-6" style="height: 50px">
            總里程
            <br>
            <b>{{ getRunCarsDetails[getIndex].odo_mileage }}</b>
          </div>
          <div class="col-sm-6" style="height: 50px">
            排放標準
            <br>
            <b>{{ getRunCarsDetails[getIndex].emission_standards }}</b>
          </div>
        </div>
        <img v-if="type"
          :src="`/${getRunCarsDetails[getIndex].vehicle_brand}/${getRunCarsDetails[getIndex].vehicle_model}.png`"
          width="100%" alt="图片">

        現在時間:{{ time | moment('YYYY-MM-DD HH:mm') }}
      </div>
    </div>
  </div>
</template>

<script>
import { computed, defineComponent, useContext, ref, useRouter, nextTick, watch, useRoute } from '@nuxtjs/composition-api'
import moment from 'moment'

export default defineComponent({
  setup() {
    const { $swal, $axios } = useContext()
    const router = useRouter()
    const type = ref(null)
    const route = useRoute()
    const time = ref(new Date().getTime())
    const allCarList = ref([])
    const allCarLocation = ref(null)
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

      $axios.get('api/allVehicleInformation')
        .then(({ data }) => {
          allCarList.value = data
          console.log(allCarList)
          nextTick(() => {
            getAll()
          })
        })
        .catch((e) => {
          console.log(e)
        })
    }
    getAllCarLocation()
    const getNowAllCarLocation = () => {
      loading.value = true
      console.log(allCarList)
      $axios.get('api/allVehicleInformation')
        .then(({ data }) => {
          allCarList.value = data
        })
        .catch((e) => {
          console.log(e)
        })
        .finally(() => {
          loading.value = false
        })
    }
    const dont = () => {
      $swal("Success!", "Transaction was successful", "success");
    }
    const detailHide = ref(true)
    const getRunDetail = ref(null)
    const getIndex = ref(null)
    const turnDetail = (val) => {
      getIndex.value = val
      detailHide.value = false
    }
    const turnOffDetail = () => {
      detailHide.value = true
    }
    const getAll = () => {
      setInterval(() => {
        if (!loading.value) {
          if (route.value.path === '/') {
            getNowAllCarLocation()
          }
        }
      }, "3000");
    }
    const getRunCar = computed(() => {
      const all = copyAllCars.value
      const car = []
      all.forEach((value, index) => {
        if (value.vehicle_status === 1) {
          car.push(value)
        }
      })
      return car
    })
    const copyAllCars = ref([])
    const selects = ref(null)
    const getSelects = ref([])
    const getRunCarsDetails = computed(() => {
      const getSelect = getSelects.value
      const allCar = allCarList.value
      const getCarsDetails = []
      allCar.forEach((value, index) => {
        getSelect.forEach((value2, index2) => {
          if (value2 === allCar[index].driver_number) {
            getCarsDetails.push(allCar[index])
          }
        })
      })
      return getCarsDetails
    })

    watch(allCarList, (val) => {
      copyAllCars.value = JSON.parse(JSON.stringify(val))
    })


    const deleteCars = () => {
      selects.value = null
      getSelects.value = []
    }

    const listenSelects = () => {
      const val = selects.value
      if (val != null) {
        if (!getSelects.value.includes(val)) {
          getSelects.value.push(val)
        } else {
          const index = getSelects.value.indexOf(val)
          getSelects.value.splice(index, 1)
        }
      }
      selects.value = null
    }

    return {
      dont,
      allCarList,
      detailHide,
      turnDetail,
      getAllCarLocation,
      allCarLocation,
      loading,
      getNowAllCarLocation,
      getAll,
      getRunCar,
      selects,
      getSelects,
      getRunCarsDetails,
      deleteCars,
      getRunDetail,
      copyAllCars,
      getIndex,
      turnOffDetail,
      listenSelects,
      type,
      time
    }
  }

})


</script>

<style lang="scss">
table {
  border-collapse: collapse;

}

td {

  padding: 5px;
}


.app-button {
  position: relative;
  display: inline-flex;
  cursor: pointer;
  text-align: center;
  white-space: nowrap;
  align-items: center;
  justify-content: center;
  vertical-align: top;
  text-decoration: none;
  outline: none;

  &--primary {
    background-color: $primary;
    color: $white;
  }

}

.GMap__Wrapper {
  height: 50vh !important;
}
</style>
