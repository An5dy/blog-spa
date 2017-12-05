export default {
    storeUserInfo(data) {
        window.localStorage.setItem('user_info', data)
    },
    deleteUserInfo() {
        window.localStorage.removeItem('user_info')
    },
    getUserInfo() {
        return window.localStorage.getItem('user_info')
    },
    set(access_token) {
        window.localStorage.setItem('access_token', access_token)
    },
    get() {
        return window.localStorage.getItem('access_token')
    },
    delete() {
        window.localStorage.removeItem('access_token')
    }
}