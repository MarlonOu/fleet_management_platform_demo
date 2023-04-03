<template>
  <div>
    <div class="row">
      <div class="col-sm-8">
        <div class="bg-primary" style="height:50vh">
          地圖 {{ }}
        </div>
        <div class="bg-success" style="height:50vh">
          <table style="width: 100%">
            <tr>
              <th>狀態</th>
              <th>狀態</th>
              <th>狀態</th>
              <th>行駛時間</th>
              <th>車號</th>
              <th>駕駛人</th>
              <th>時速</th>
              <th>地址</th>
              <th>圍籬</th>
            </tr>
            <tr v-for="carList in allCarList">
              <!-- 要放V-FOR -->
              <td>
                {{ carList }}
              </td>
            </tr>
          </table>
        </div>
      </div>
      <div class="col-sm-4" style="height:100vh; overflow-y:scroll">
        <h4>車輛狀態</h4>
        時速: <br>
        車隊: <br>
        GPS: <br>
        <hr>
        <h4>車隊即時數據</h4>
        <div class="row text-center">
          <div class="col-sm-6" style="height: 150px">
            引擎冷卻液
          </div>
          <div class="col-sm-6" style="height: 150px">
            總里程數
          </div>
        </div>
        <div class="row text-center">
          <div class="col-sm-6" style="height: 150px">
            時速
          </div>
          <div class="col-sm-6" style="height: 150px">
            限速功能狀態
          </div>
        </div>
        <div class="row text-center">
          <div class="col-sm-6" style="height: 150px">
            機油油位
          </div>
          <div class="col-sm-6" style="height: 150px">
            限時油耗
          </div>
        </div>
        <div class="row text-center">
          <div class="col-sm-6" style="height: 150px">
            平均油耗
          </div>
          <div class="col-sm-6" style="height: 150px">
            引擎轉速
          </div>
        </div>
        <div class="row text-center">
          <div class="col-sm-6" style="height: 150px">
            引擎油溫
          </div>
          <div class="col-sm-6" style="height: 150px">
            煞車壓力
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { computed, defineComponent, useContext, ref } from '@nuxtjs/composition-api'

export default defineComponent({
  setup() {
    const { $swal, $axios } = useContext()
    const allCarList = ref(null)
    const getAllCarList = () => {
      $axios.get('api/welcome')
        .then(({ data }) => {
          allCarList.value = data
        })
        .catch((e) => {
          console.log(e)
        })
    }
    getAllCarList()
    const dont = () => {
      $swal("Success!", "Transaction was successful", "success");
    }
    const id = computed(() => {
      return 123
    })
    return {
      id,
      dont,
      allCarList
    }
  }

})


</script>

<style lang="scss">
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
</style>