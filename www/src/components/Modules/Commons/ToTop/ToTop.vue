<template>
    <BackTop class="to-top" :height="100" :bottom="30">
        <Icon type="chevron-up"></Icon>
    </BackTop>
</template>

<script>
    export default {
        name: 'toTop'
    };
</script>

<style lang="less" scoped rel="stylesheet/less">
    @import "ToTop.less";
</style>