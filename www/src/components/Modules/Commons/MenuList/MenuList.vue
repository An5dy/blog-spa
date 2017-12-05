<template>
    <ul class="menu-list" v-if="$store.state.userInfo.userInfo.name">
        <li class="blog">
            <Tooltip content="写博客" placement="left-start">
                <router-link to="/articles/add">
                    <Icon type="edit"></Icon>
                </router-link>
            </Tooltip>
        </li>
        <li>
            <Tooltip content="个人中心" placement="left-start">
                <router-link to="/setting">
                    <Icon type="home"></Icon>
                </router-link>
            </Tooltip>
        </li>
        <li>
            <Tooltip content="gitbub" placement="left">
                <a href="#"><Icon type="social-github"></Icon></a>
            </Tooltip>
        </li>
        <li class="email">
            <Tooltip content="邮箱" placement="left-start">
                <a href="#"><Icon type="email"></Icon></a>
            </Tooltip>
        </li>
    </ul>
</template>

<script>
    export default {
        name: 'MenuList'
    }
</script>

<style lang="less" scoped rel="stylesheet/less">
    @import "MenuList.less";
</style>
