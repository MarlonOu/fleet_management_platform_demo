<template>
    <div class="app-button--primary">
        hello 世界 連假快樂
        <button @click="dont">go</button>
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Launch demo modal
        </button>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        123123
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
  
<script>
import { computed, defineComponent, useContext } from '@nuxtjs/composition-api'

export default defineComponent({
    setup() {
        const { $swal, $axios } = useContext()
        const dont = () => {
            $axios.get('api/welcome')
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