<template>
    <footer class="footer">
        © 2016-{{ year }} <router-link to="/">zhangze.me</router-link> All right reserved.
        <br/>
        <a href="http://www.miitbeian.gov.cn/" target="_blank">备案号：浙ICP备17026260号</a>
    </footer>
</template>

<script>
    export default {
        name: 'Footer',
        data() {
            return {
                year: new Date().getFullYear()
            }
        }
    }
</script>

<style lang="less" scoped rel="stylesheet/less">
    @import "Footer.less";
</style>
