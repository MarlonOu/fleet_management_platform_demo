<template>
    <div>
        <nav class="navbar navbar-expand-sm bg-dark" v-if="!route.params.id">
            <ul class="navbar-nav w-100 justify-content-between">
                <li class="nav-item nav-link" v-if="route.path === '/'">
                    SwiSys車隊管理平台
                </li>
                <li class="nav-item nav-link" v-else>
                    ESG查詢系統
                </li>
                <div class="d-flex">
                    <li class="nav-item nav-link">
                        {{ user }}您好
                    </li>
                    <li class="nav-item mx-2 nav-link">
                        <NuxtLink v-if="route.path === '/'" to="/admin">ESG查詢系統</NuxtLink>
                        <NuxtLink v-else to="/">SwiSys車隊管理平台</NuxtLink>
                    </li>
                    <li class="nav-item nav-link" style="cursor: pointer;">
                        <div @click="logout()">登出</div>
                    </li>
                </div>

            </ul>
        </nav>
    </div>
</template>
<script>
import { useRoute, defineComponent, ref, nextTick, useRouter } from '@nuxtjs/composition-api'

export default defineComponent({
    setup() {
        const route = useRoute()
        const router = useRouter()
        const user = ref('')
        const setUser = () => {
            if (process.client) {
                user.value = localStorage.getItem('user')
            }
        }
        const logout = () => {
            window.localStorage.removeItem('user');
            window.localStorage.removeItem('auth')
            window.localStorage.removeItem('vehicle_type')
            nextTick(() => {
                router.push('/login')
            })
        }
        setUser()
        return {
            route,
            user,
            logout

        }
    }

})


</script>
<style>
.nav-link {
    color: white !important;
}

a {
    text-decoration: none;
    color: white;
}
</style>
