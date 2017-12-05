<template>
    <Row class="setting">
        <i-col span="6" class="menu">
            <ul>
                <li>
                    <router-link to="/setting/account">
                        <Icon type="ios-person"></Icon>
                        账号设置
                    </router-link>
                </li>
                <li>
                    <router-link to="/setting/password">
                        <Icon type="ios-gear"></Icon>
                        密码设置
                    </router-link>
                </li>
            </ul>
        </i-col>
        <i-col span="18" class="content">
            <router-view></router-view>
        </i-col>
    </Row>
</template>

<script>
    export default {
        name: 'Setting'
    }
</script>

<style lang="less" rel="stylesheet/less">
    @import "Setting.less";
</style>
