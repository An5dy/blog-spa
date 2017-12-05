<template>
    <Form ref="password"
          :model="password"
          :rules="rulePassword"
          label-position="left"
          :label-width="100">
        <FormItem label="原密码" prop="old">
            <Input v-model="password.old"
                   type="password"
                   class="input-width"></Input>
        </FormItem>
        <FormItem label="新密码" prop="new">
            <Input v-model="password.new"
                   class="input-width"
                   type="password"></Input>
        </FormItem>
        <FormItem label="再次输入密码" prop="new_confirmation">
            <Input v-model="password.new_confirmation"
                   class="input-width"
                   type="password"></Input>
        </FormItem>
        <FormItem>
            <Button type="primary" @click="handleSubmit('password')">确认</Button>
        </FormItem>
    </Form>
</template>

<script>
    export default {
        name: 'Password',
        data () {
            const validateOldPassword = (rule, value, callback) => {
                if (value === '') {
                    callback(new Error('旧密码不能为空'))
                } else {
                    callback()
                }
            };
            const validatePassword = (rule, value, callback) => {
                if (value === '') {
                    callback(new Error('新密码不能为空'))
                } else {
                    callback()
                }
            };
            const validatePasswordConfirm = (rule, value, callback) => {
                if (value === '') {
                    callback(new Error('确认密码不能为空'))
                } else if (value !== this.password.new) {
                    callback(new Error('两次密码输入不一致'))
                } else {
                    callback()
                }
            }
            return {
                password: {
                    old: '',
                    new: '',
                    new_confirmation: ''
                },
                rulePassword: {
                    old: [
                        { validator: validateOldPassword, trigger: 'blur' }
                    ],
                    new: [
                        { validator: validatePassword, trigger: 'blur' }
                    ],
                    new_confirmation: [
                        { validator: validatePasswordConfirm, trigger: 'blur' }
                    ],
                }
            }
        },
        methods: {
            handleSubmit(name) {
                this.$refs[name].validate((valid) => {
                    if (valid) {
                        this.$Loading.start()
                        let data = {
                            password: this.password.new,
                            oldPassword: this.password.old,
                            password_confirmation: this.password.new_confirmation
                        }
                        this.axios.post('/user/update_password', data).then(res => {
                            if (res.data.code === '10000') {
                                this.$Message.success('密码修改成功')
                            } else {
                                this.$Message.error(res.data.message)
                            }
                        }).catch(error => {
                            this.$Message.error('密码修改失败')
                        })
                        this.$Loading.finish()
                    }
                })
            }
        }
    }
</script>

<style lang="less" scoped rel="stylesheet/less">
    @import "Password.less";
</style>
