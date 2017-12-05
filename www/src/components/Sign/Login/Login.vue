<template>
    <Row>
        <Form ref="formCustom"
              :model="formCustom"
              :rules="ruleCustom"
              label-position="top">
            <FormItem label="邮箱:" prop="email">
                <Input v-model="formCustom.email"></Input>
            </FormItem>
            <FormItem label="密码:" prop="password">
                <Input v-model="formCustom.password" type="password"></Input>
            </FormItem>
            <FormItem label="验证码:">
                <div id="captcha">
                    <span id="loadingCaptcha">验证码加载中...</span>
                </div>
            </FormItem>
            <FormItem>
                <Button type="success" long class="login-submit" @click="handleSubmit('formCustom')">登录</Button>
            </FormItem>
        </Form>
    </Row>
</template>

<script>
    import 'assets/lib/gt'
    export default {
        data() {
            const validateEamil = (rule, value, callback) => {
                if (value === '') {
                    callback(new Error('邮箱不能为空'));
                } else {
                    let emailReg = /^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-])+/;
                    if (emailReg.test(value)) {
                        callback();
                    } else {
                        callback(new Error('邮箱格式不正确'));
                    }
                }
            };
            const validatePassword = (rule, value, callback) => {
                if (value === '') {
                    callback(new Error('密码不能为空'));
                } else {
                    callback();
                }
            };
            return {
                formCustom: {
                    email: '',
                    password: ''
                },
                ruleCustom: {
                    email: [
                        { validator: validateEamil, trigger: 'blur' }
                    ],
                    password: [
                        { validator: validatePassword, trigger: 'blur' }
                    ]
                },
                captcha: {}
            }
        },
        methods: {
            getCaptchas() {
                this.axios.get('/captcha/get')
                    .then(res => {
                        initGeetest({
                            // 以下配置参数来自服务端 SDK
                            gt: res.data.data.captcha.gt,
                            challenge: res.data.data.captcha.challenge,
                            offline: !res.data.data.captcha.success,
                            new_captcha: res.data.data.captcha.new_captcha,
                            product: 'popup',
                            width: '100%'
                        }, captchaObj => {
                            this.captcha = captchaObj;
                            // 这里可以调用验证实例 captchaObj 的实例方
                            captchaObj.appendTo("#captcha")
                            captchaObj.onReady(function () {
                                document.getElementById('loadingCaptcha').style.display = 'none'
                            })
                        })
                    })
            },
            handleSubmit (name) {
                this.$refs[name].validate((valid) => {
                    if (valid) {
                        this.$Loading.start();
                        let result = this.captcha.getValidate()
                        if (result) {
                            let formData = {
                                geetest_challenge: result.geetest_challenge,
                                geetest_validate: result.geetest_validate,
                                geetest_seccode: result.geetest_seccode,
                                email: this.formCustom.email,
                                password: this.formCustom.password
                            };
                            this.axios.post('/login', formData).then(res => {
                                if (res.data.code === '10000') {
                                    this.$store.dispatch('storeUserInfo', res.data.data)
                                    this.$Message.success(res.data.message)
                                    this.$router.push('/')
                                } else {
                                    this.$Message.error(res.data.message)
                                }
                            })
                        } else {
                            this.$Message.error('验证码错误')
                        }
                        this.captcha.reset()
                    } else {
                        this.$Message.error('登录失败')
                    }
                    this.$Loading.finish()
                })
            },
        },
        mounted() {
            this.getCaptchas();
        }
    }
</script>

<style lang="less" rel="stylesheet/less">
    @import "Login.less";
</style>
