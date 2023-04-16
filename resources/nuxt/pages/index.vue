<template>
  <div>
    <div class="row">
      <div :class="{ 'col-sm-12': detailHide, 'col-sm-8': !detailHide }">
        <div style="height:50vh">
          <Map :setLocation="allCarList"></Map>
        </div>

        <div class="bg-success" style="height:50vh">
          <table style="width: 100%" class="text-white text-center">
            <tr>
              <th>查看</th>
              <th>車輛編號</th>
              <th>駕駛人編號</th>
              <th>駕駛行為分數</th>
              <th>時間</th>
              <th>時速</th>
              <th>轉速</th>
              <th>平均油耗</th>
              <th>總里程</th>
              <th>經度</th>
              <th>緯度</th>
              <th>海拔高度</th>
              <th>超時工作</th>
            </tr>
            <tr v-for="carList in allCarList">
              <td>
                <button class="btn btn-primary" @click="turnDetail()">查看</button>
              </td>
              <td>
                {{ carList.vehicle_number }}
              </td>
              <td>
                {{ carList.driver_number }}
              </td>
              <td>
                {{ carList.driving_behavior_score }}
              </td>
              <td>
                {{ carList.date_time }}
              </td>
              <td>
                {{ carList.speed }}
              </td>
              <td>
                {{ carList.engine_speed }}
              </td>
              <td>
                {{ carList.average_fuel }}
              </td>
              <td>
                {{ carList.odo_mileage }}
              </td>
              <td>
                {{ carList.longitude }}
              </td>
              <td>
                {{ carList.latitude }}
              </td>
              <td>
                {{ carList.altitude }}
              </td>
              <td>
                {{ carList.mil_signal }}
              </td>
            </tr>
          </table>
        </div>
      </div>
      <div v-if="!detailHide" class="col-sm-4" style="height:100vh; overflow-y:scroll">
        <div class="text-end fw-bold mt-4">
          <span @click="turnDetail()" class="p-3" style="cursor: pointer;">
            <b>X</b>
          </span>
        </div>
        <h4>車輛狀態</h4>
        時速: <br>
        車隊: <br>
        GPS: <br>
        <hr>
        <h4>車隊即時數據</h4>
        <div class="row text-center">
          <div class="col-sm-6" style="height: 150px">
            時速
          </div>
          <div class="col-sm-6" style="height: 150px">
            轉速
          </div>
        </div>
        <div class="row text-center">
          <div class="col-sm-6" style="height: 150px">
            總里程
          </div>
          <div class="col-sm-6" style="height: 150px">
            平均油耗
          </div>
        </div>

      </div>
    </div>
  </div>
</template>

<script>
import { computed, defineComponent, useContext, ref, useRouter, nextTick } from '@nuxtjs/composition-api'

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
      $axios.get('api/getVehicleRealtimeStatus')
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
    const turnDetail = () => {
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
      }, "150000");
    }
    const runCars = ref([])
    const getRunCars = () => {
      $axios.get('api/getVehicleRealtimeDetailInformation')
        .then(({ data }) => {
          runCars.value = data

        })
        .catch((e) => {
          console.log(e)
        })
        .finally(() => {
          loading.value = false
        })
    }
    getRunCars()
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
      runCars,
      getRunCars

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