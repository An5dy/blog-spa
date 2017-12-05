<template>
    <div class="sign">
        <div style="position: relative">
            <Tabs :value="tabName" @on-click="clickTab">
                <TabPane label="登录" name="login">
                    <Login></Login>
                </TabPane>
                <TabPane label="注册" name="register">
                    <Register :tabName.sync="tabName"></Register>
                </TabPane>
            </Tabs>
        </div>
    </div>
</template>

<script>
    import Login from './Login';
    import Register from './Register';
    export default {
        name: 'Sign',
        data() {
            return {
                tabName: 'login'
            }
        },
        components: {
            Login, Register
        },
        methods: {
            clickTab(name) {
                this.tabName = name
            }
        }
    }
</script>

<style lang="less" rel="stylesheet/less">
    @import "Sign.less";
</style>
