<template>
  <div class="bg">
    <div class="login">
      <h4 class="text-center mt-0 mb-3">登入</h4>
      <div class="mb-3">
        <input type="text" class="form-control" v-model="email">
      </div>
      <div class="mb-3">
        <input type="password" class="form-control" v-model="password">
      </div>
      <div>
        <label class="btn btn-primary" @click="login()"> 登入</label>
      </div>
    </div>
  </div>
</template>
<script>
import {defineComponent, useContext, ref, useRouter} from '@nuxtjs/composition-api'

export default defineComponent({
  layout: 'login',
  setup() {
    const {$axios} = useContext()
    const email = ref('aaa@gmail.com')
    const password = ref('aaaaaa')
    const vehicle_type = ref('1')
    const router = useRouter()
    const login = () => {
      const payload = {
        email: email.value,
        password: password.value
      }
      $axios.post('api/auth/login', payload)
        .then(({data}) => {
          localStorage.setItem('auth', data.original.access_token)
          localStorage.setItem('user', data.original.user.name)
          localStorage.setItem('type', data.original.user.vehicle_type)
        })
        .catch((e) => {
          console.log(e)
        })
        .finally(() => {
          if (localStorage.getItem('type') === "1") {
            router.push('/index2')
          } else {
            router.push('/')
          }
        })
    }

    return {
      email,
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
