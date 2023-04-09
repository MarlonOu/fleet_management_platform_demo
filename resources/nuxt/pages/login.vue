<template>
    <div class="bg">
        <div class="login">
            <h4 class="text-center mt-0 mb-3">登入</h4>
            <div class="mb-3">
                <input type="text" class="form-control">
            </div>
            <div class="mb-3">
                <input type="password" class="form-control">
            </div>
            <div>
                <label class="btn btn-primary" @click="login()"> 登入</label>
            </div>
        </div>
    </div>
</template>
<script>
import { defineComponent, useContext, ref, useRouter } from '@nuxtjs/composition-api'
export default defineComponent({
    layout: 'login',
    setup() {
        const { $axios } = useContext()
        const account = ref(null)
        const password = ref(null)
        const router = useRouter()
        const login = () => {
            const payload = {
                name: account.value,
                password: password.value
            }
            $axios.post('platformUserInformation', payload)
                .then(({ data }) => {
                    router.push('/')
                })
                .catch((e) => {
                    console.log(e)
                })
                .finally(() => {
                    router.push('/')
                })
        }

        return {
            account,
            password,
            login
        }
    }

})
</script>
<style>
.bg {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100vh;
    background-color: coral;
}

.login {
    border: 1px solid black;
    padding: 5rem;
    background-color: darkgray;
    border-radius: 15px;
}
</style>