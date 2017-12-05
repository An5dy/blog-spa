import Vue from 'vue'
import axios from 'axios'
import VueAxios from 'vue-axios'
import JWT from './jwt'

Vue.use(VueAxios, axios)
// 设置接口前缀
axios.defaults.baseURL = '/api'
// 设置access
axios.defaults.headers.Accept = 'application/json'
// 设置token
axios.interceptors.request.use(function (config) {
    if (JWT.get()) {
        config.headers['Authorization'] = 'Bearer ' + JWT.get();
    }
    return config;
}, function (error) {
    return Promise.reject(error);
})
// 拦截错误
axios.interceptors.response.use(res => {
    return res
}, error => {
    if (error.response) {
        switch (error.response.status) {
            case 401:
                window.vm.$store.dispatch('deleteUserInfo')
                window.vm.$router.push('/sign')
                window.vm.$Message.error('登录超时');
        }
    }
    return Promise.reject(error.response.data)
})