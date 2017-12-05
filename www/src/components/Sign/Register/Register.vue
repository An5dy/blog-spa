<template>
    <Row>
        <Form ref="formRegister"
              :model="formRegister"
              :rules="ruleRegister"
              label-position="top">
            <FormItem prop="username">
                <Input v-model="formRegister.username" placeholder="用户名"></Input>
            </FormItem>
            <FormItem prop="email">
                <Input v-model="formRegister.email" placeholder="邮箱"></Input>
            </FormItem>
            <FormItem class="get-code" prop="captchaCode">
                <div class="code-item">
                    <Input v-model="formRegister.captchaCode" placeholder="验证码"/>
                </div>
                <Button class="btn-get-code" type="primary" :disabled="sendStatus" @click="sendCaptchaCode">{{ codeMsg }}</Button>
            </FormItem>
            <FormItem prop="password">
                <Input v-model="formRegister.password" type="password" placeholder="密码"></Input>
            </FormItem>
            <FormItem prop="password_confirmation">
                <Input v-model="formRegister.password_confirmation" type="password" placeholder="确认密码"></Input>
            </FormItem>
            <FormItem>
                <Button type="success" long class="register-submit" @click="handleSubmit('formRegister')">注册</Button>
            </FormItem>
        </Form>
    </Row>
</template>

<script>
    export default {
        data() {
            const validateUsername = (rule, value, callback) => {
                if (value === '') {
                    callback(new Error('用户名不能为空'))
                } else {
                    callback()
                }
            };
            const validateEmail = (rule, value, callback) => {
                if (value === '') {
                    callback(new Error('邮箱不能为空'))
                } else {
                    let emailReg = /^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-])+/
                    if (emailReg.test(value)) {
                        callback()
                    } else {
                        callback(new Error('邮箱格式不正确'))
                    }
                }
            };
            const validateCaptchaCode = (rule, value, callback) => {
                if (value === '') {
                    callback(new Error('验证码不能为空'))
                } else {
                    callback()
                }
            };
            const validatePassword = (rule, value, callback) => {
                if (value === '') {
                    callback(new Error('密码不能为空'))
                } else {
                    callback()
                }
            };
            const validatePasswordConfirm = (rule, value, callback) => {
                if (value === '') {
                    callback(new Error('确认密码不能为空'))
                } else if (value !== this.formRegister.password) {
                    callback(new Error('两次密码输入不一致'))
                } else {
                    callback()
                }
            }
            return {
                sendStatus: false,
                codeMsg: '获取验证码',
                formRegister: {
                    username: '',
                    email: '',
                    captchaCode: '',
                    password: '',
                    password_confirmation: ''
                },
                ruleRegister: {
                    username: [
                        { validator: validateUsername, trigger: 'blur' }
                    ],
                    email: [
                        { validator: validateEmail, trigger: 'blur' }
                    ],
                    captchaCode: [
                        { validator: validateCaptchaCode, trigger: 'blur' }
                    ],
                    password: [
                        { validator: validatePassword, trigger: 'blur' }
                    ],
                    password_confirmation: [
                        { validator: validatePasswordConfirm, trigger: 'blur' }
                    ]
                }
            }
        },
        methods: {
            handleSubmit(name) {
                this.$refs[name].validate((valid) => {
                    if (valid) {
                        this.$Loading.start()
                        this.axios.post('/register', this.formRegister).then(res => {
                            if (res.data.code === '10000') {
                                this.$Message.success('注册成功')
                                this.$emit('update:tabName', 'login')
                            } else {
                                this.$Message.error(res.data.message)
                            }
                        }).catch(error => {
                            this.$Message.error('系统错误')
                        });
                        this.$Loading.finish()
                    } else {
                        this.$Message.error('注册失败')
                    }
                })
            },
            sendCaptchaCode() {
                if (this.formRegister.email === '') {
                    this.$Message.error('邮箱不能为空!')
                } else {
                    this.$Loading.start();
                    this.axios.post('/verification_code/send', {email: this.formRegister.email}).then(res => {
                        if (res.data.code === '10000') {
                            this.$Message.success('邮件发送成功')
                        } else {
                            this.$Message.error(res.data.message)
                        }
                        this.sendStatus = true
                        let timeCount = 58
                        this.codeMsg = '59秒后重试'
                        let interval = setInterval(() => {
                            this.codeMsg = timeCount + '秒后重试'
                            timeCount --
                            if (timeCount === 0) {
                                this.sendStatus = false
                                this.codeMsg = '重新发送'
                                clearInterval(interval)
                            }
                        }, 1000);
                    }).catch(error => {
                        this.$Message.error('系统错误')
                    })
                    this.$Loading.finish()
                }
            }
        }
    }
</script>

<style lang="less" rel="stylesheet/less">
    @import "Register.less";
</style>
