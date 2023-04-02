<template>
  <div class="app-button--primary">
    hello 世界 連假快樂 {{ id }}
    <button @click="dont">go</button>
  </div>
</template>

<script>
import { computed, defineComponent, useContext } from '@nuxtjs/composition-api'

export default defineComponent({
  setup() {
    const { $swal } = useContext()
    const dont = () => {
      $swal("Success!", "Transaction was successful", "success");
    }
    const id = computed(() => {
      return 123
    })
    return {
      id,
      dont
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