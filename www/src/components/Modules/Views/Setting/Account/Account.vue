<template>
    <div>
        <Form :model="user" label-position="left" :label-width="100">
            <FormItem label="头像">
                <div class="avatar">
                    <img :src="user.avatar_thumb">
                </div>
                <Button type="dashed"
                        icon="ios-cloud-upload-outline"
                        class="upload"
                        @click="show=!show">选择图片</Button>
            </FormItem>
            <FormItem label="旧用户名">
                {{ $store.state.userInfo.userInfo.name }}
            </FormItem>
            <FormItem label="新用户名">
                <Input v-model.trim="user.name" class="input-width"></Input>
            </FormItem>
            <FormItem>
                <Button type="primary" @click="onSubmit">确认</Button>
            </FormItem>
        </Form>
        <CropUpload @crop-upload-success="uploadSuccess"
                    field="image"
                    :width="300"
                    :height="300"
                    :headers="headers"
                    :params="params"
                    url="/api/image/upload"
                    v-model="show">
        </CropUpload>
    </div>
</template>

<script>
    import CropUpload from 'vue-image-crop-upload';
    import JWT from '../../../../../util/jwt'
    export default {
        name: 'Account',
        components: {
            CropUpload
        },
        data() {
            return {
                user: {
                    name: '',
                    avatar: '',
                    avatar_thumb: this.$store.state.userInfo.userInfo.avatar_thumb,
                },
                show: false,
                headers: {
                    Authorization: 'Bearer ' + JWT.get()
                },
                params: {
                    thumb: 1
                }
            }
        },
        methods: {
            uploadSuccess(res, file) {
                this.show = false;
                if (res.code === '10000') {
                    this.user.avatar = res.data.shift()
                    this.user.avatar_thumb = res.data.pop()
                } else {
                    this.$Message.error(res.message);
                }
            },
            onSubmit() {
                if (this.$store.state.userInfo.userInfo.name == this.user.name) {
                    this.$Message.error('与原用户名相同')
                    return
                }
                let data = {}
                if (this.user.avatar && this.user.avatar_thumb) {
                    data.avatar = this.user.avatar
                    data.avatar_thumb = this.user.avatar_thumb
                }
                if (this.user.name) {
                    data.name = this.user.name
                }
                if (Object.keys(data).length == 0) {
                    this.$Message.error('请选择要修改的内容')
                    return
                }
                this.$Loading.start()
                this.axios.post('/user/update', data).then(res => {
                    if (res.data.code === '10000') {
                        this.$store.dispatch('updateUserInfo', res.data.data)
                        this.$Message.success('修改成功')
                    } else {
                        this.$Message.error('修改失败')
                    }
                }).catch(error => {
                    this.$Message.error('修改失败')
                })
                this.$Loading.finish()
            }
        }
    }
</script>

<style lang="less" scoped rel="stylesheet/less">
    @import "Account.less";
</style>
