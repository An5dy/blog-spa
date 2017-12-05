import * as types from '../mutation-types'
import JWT from './../../util/jwt'
import Cookie from 'js-cookie'

const state = {
    userInfo: Cookie.getJSON('user_info') || {}
}

const mutations = {
    [types.STORE_USER_INFO](state) {
        state.userInfo = Cookie.getJSON('user_info') || {}
    },
    [types.DELETE_USER_INFO](state) {
        state.userInfo = {}
    }
}

const actions = {
    storeUserInfo({commit}, data) {
        return new Promise((resolve, reject) => {
            // 保存用户信息至cookie
            Cookie.set('user_info', JSON.stringify({id: data.id, name: data.name, email: data.email, avatar: data.avatar, avatar_thumb: data.avatar_thumb}))
            // 设置access_token
            JWT.set(data.access_token)
            // 保存用户信息至vuex
            commit(types.STORE_USER_INFO)
            resolve()
        })
    },
    updateUserInfo({commit}, data) {
        return new Promise((resolve, reject) => {
            // 保存用户信息至cookie
            Cookie.set('user_info', JSON.stringify({id: data.id, name: data.name, email: data.email, avatar: data.avatar, avatar_thumb: data.avatar_thumb}))
            // 保存用户信息至vuex
            commit(types.STORE_USER_INFO)
            resolve()
        })
    },
    deleteUserInfo({commit}) {
        return new Promise((resolve, reject) => {
            JWT.delete()
            Cookie.remove('user_info')
            commit(types.DELETE_USER_INFO)
            resolve()
        })
    }
}

export default {
    state,
    mutations,
    actions
}