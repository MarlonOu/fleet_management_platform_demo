<template>
  <div>
    <div class="row">
      <div :class="{ 'col-sm-12': detailHide, 'col-sm-8': !detailHide }">
        <div style="height:50vh">
          <Map :setLocation="allCarList"></Map>
        </div>

        <div class="bg-success" style="height:50vh">
          <div class="row py-3">
            <div class="col-3">
              <select class="form-select" v-model="selects">
                <option :value="null" disabled>
                  請選擇車輛
                </option>
                <option v-for="car in getRunCar" :key="car.driver_number" :value="car.driver_number">
                  車輛編號{{ car.driver_number }}
                  <span v-if="getSelects.includes(car.driver_number)" style="color: #ff3c00;">(已選)</span>
                </option>
              </select>
            </div>
            <div class="col-3">
              <label class="btn btn-danger" @click="deleteCars()">清除</label>
            </div>
          </div>
          <table style="width: 100%" class="text-white text-center">
            <tr>
              <th>查看</th>
              <th>駕駛人姓名</th>
              <th>車號</th>
              <th>排放標準</th>
              <th>時速</th>
              <th>行駛里程數</th>
              <th>時間</th>
            </tr>
            <tr v-if="getRunCarsDetails.length > 0" v-for="carList in getRunCarsDetails">
              <td>
                <button class="btn btn-primary" @click="turnDetail(carList.driver_number)">查看</button>
              </td>
              <td>
                {{ carList.driver_number }}
              </td>
              <td>
                {{ carList.vehicle_number }}
              </td>
              <td>
                {{ carList.Emission_standards }}
              </td>
              <td>
                {{ carList.speed }}
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
      <div v-if="!detailHide && getRunDetail" class="col-sm-4" style="height:100vh; overflow-y:scroll">
        <div class="text-end fw-bold mt-4">
          <span @click="turnDetail()" class="p-3" style="cursor: pointer;">
            <b>X</b>
          </span>
        </div>
        <h4>車輛狀態</h4>
        車號: {{ getRunDetail.licence_plate }} <br>
        駕駛人: {{ getRunDetail.driver_name }} <br>
        行駛時間: {{ getRunDetail.time }}<br>
        是否超時: {{ getRunDetail.task_overtime }} <br>
        <hr>
        <h4>車隊即時數據</h4>
        <div class="row text-center">
          <div class="col-sm-6" style="height: 50px">
            時速
            <br>
            <b>{{ getRunDetail.speed }}</b>
          </div>
          <div class="col-sm-6" style="height: 50px">
            轉速
            <br>
            <b>{{ getRunDetail.engine_speed }}</b>
          </div>
        </div>
        <div class="row text-center">
          <div class="col-sm-6" style="height: 50px">
            總里程
            <br>
            <b>{{ getRunDetail.odo_mileage }}</b>
          </div>
          <div class="col-sm-6" style="height: 50px">
            排放標準
            <br>
            <b>{{ getRunDetail.emission_standards }}</b>
          </div>
        </div>

      </div>
    </div>
  </div>
</template>

<script>
import { computed, defineComponent, useContext, ref, useRouter, nextTick, watch } from '@nuxtjs/composition-api'

export default defineComponent({
  setup() {
    const { $swal, $axios } = useContext()
    const router = useRouter()
    const allCarList = ref([])
    const allCarLocation = ref(null)
    const loading = ref(false)
    const getAllCarLocation = () => {
      $axios.get('api/getVehicleRealtimeStatus')
        .then(({ data }) => {
          allCarList.value = data
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
      $axios.get('api/uploadVehicleRealtimeInformation')
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
    const turnDetail = (val) => {
      if (val) {
        $axios.get(`api/getVehicleDetailInformation?driver_number=${val}`)
          .then(({ data }) => {
            getRunDetail.value = data
          })
          .catch((e) => {
            console.log(e)
          })
      }
      if (detailHide.value) {
        detailHide.value = false
      } else {
        detailHide.value = true
      }
    }
    const getAll = () => {
      setInterval(() => {
        if (!loading.value) {
          getNowAllCarLocation()
        }
      }, "1500");
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
        if (getSelect[index]) {
          if (value.driver_number === getSelect[index]) {
            getCarsDetails.push(allCar[index])
          }
        }
      })
      return getCarsDetails
    })

    watch(allCarList, (val) => {
      copyAllCars.value = JSON.parse(JSON.stringify(val))
    })

    watch(selects, (val) => {
      if (val != null) {
        getSelects.value.push(val)
      }
    })

    const deleteCars = () => {
      selects.value = null
      getSelects.value = []

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
      copyAllCars

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