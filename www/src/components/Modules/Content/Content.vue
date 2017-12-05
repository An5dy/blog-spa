<template>
    <Row class="body">
        <app-header></app-header>
        <main class="container">
            <router-view></router-view>
        </main>
        <app-footer></app-footer>
        <to-top></to-top>
    </Row>
</template>

<script>
    import {Header, Footer, ToTop} from 'Commons'
    export default {
        name: 'Content',
        components: {
            AppHeader: Header, 
            AppFooter: Footer,
            ToTop: ToTop,
        }
    }
</script>


<style lang="less" scoped rel="stylesheet/less">
    @import "Content.less";
</style>
