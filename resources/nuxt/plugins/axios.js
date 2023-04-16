import axios from 'axios'

export default function (ctx, inject) {
    axios.defaults.baseURL = 'http://127.0.0.1:8000'
    axios.defaults.headers.common['Authorization'] = localStorage.getItem('auth')
    axios.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded'

    /* 注入 Nuxt Instance Property */
    ctx.$axios = axios

    inject('axios', axios)
}