<template>
    <div class="article-add">
        <Form ref="formData"
              :model="formData"
              :rules="ruleData"
              :label-width="80">
            <FormItem prop="title" label="文章标题:">
                <Input v-model="formData.title"
                       placeholder="最多256个字"></Input>
            </FormItem>
            <FormItem label="文章正文:">
                <div id="editor" style="background-color: white"></div>
            </FormItem>
            <FormItem label="文章标签:">
                <i-col>
                <Input placeholder="标签名" v-model="tagName" style="width: 150px"></Input>
                <Button icon="ios-plus-empty" type="dashed" @click="addTag" style="background-color: white">添加标签</Button>
                (最多添加5个标签)
                </i-col>
                <i-col>
                <Tag v-for="tag in formData.tags" type="border" color="blue" :key="tag" :name="tag" closable @on-close="removeTag">
                    {{ tag }}
                </Tag>
                </i-col>
            </FormItem>
            <FormItem prop="category" label="选择分类:">
                <Select v-model="formData.category_id" style="width: 150px">
                    <Option v-for="(category, index) in categories"
                            :key="category.id"
                            :value="category.id">{{ category.title }}</Option>
                </Select>
            </FormItem>
            <FormItem>
                <Button type="success" long class="register-submit" @click="onSubmit('formData')">确认发布</Button>
            </FormItem>
        </Form>
    </div>
</template>

<script>
    import WangEditor from 'wangeditor/release/wangEditor'
    import JWT from '../../../../../util/jwt'
    export default {
        name: 'Add',
        data() {
            const validateTitle = (rule, value, callback) => {
                if (value === '') {
                    callback(new Error('标题不能为空'));
                } else {
                    callback();
                }
            };
            const validateCategory = (rule, value, callback) => {
                if (value === '') {
                    callback(new Error('请选择文章分类'));
                } else {
                    callback();
                }
            };
            return {
                editor: {},
                formData: {
                    title: '',
                    category_id: '',
                    description: '',
                    tags: []
                },
                ruleData: {
                    title: [
                        { validator: validateTitle, trigger: 'blur' }
                    ],
                    category: [
                        { validator: validateCategory, trigger: 'blur' }
                    ]
                },
                tagName: '',
                categories: [],
                tags: []
            }
        },
        methods: {
            initEditor() {
                this.editor = new WangEditor('#editor');
                this.editor.customConfig.zIndex = 0;
                this.editor.Message = this.$Message;
                this.editor.store = this.$store;
                this.editor.router = this.$router;
                // 图片上传设置
                this.editor.customConfig.uploadImgServer = '/api/image/upload';
                this.editor.customConfig.uploadFileName = 'image';
                this.editor.customConfig.uploadImgMaxSize = 1 * 1024 * 1024;
                this.editor.customConfig.uploadImgMaxLength = 1;
                this.editor.customConfig.uploadImgHeaders = {
                    'Accept': 'application/json',
                    'Authorization': 'Bearer ' + JWT.get(),
                };
                this.editor.customConfig.uploadImgHooks = {
                    error: function (xhr, editor) {
                        if (xhr.status == 401) {
                            editor.Message.warning('登录超时');
                            editor.store.dispatch('deleteUserInfo');
                            editor.router.push('/sign');
                        }
                    }
                }
                this.editor.create();
            },
            addTag() {
                if (this.formData.tags.length >= 5) {
                    this.$Message.error('最多添加5个标签');
                    return;
                }
                if (this.tagName) {
                    if (this.formData.tags.includes(this.tagName)) {
                        this.$Message.error('该标签已添加');
                    } else {
                        this.formData.tags.push(this.tagName);
                        this.tagName = '';
                    }
                }
            },
            removeTag(event, name) {
                let index = this.formData.tags.indexOf(name);
                this.formData.tags.splice(index, 1);
            },
            getCategories() {
                this.axios.get('/categories').then(res => {
                    if (res.data.code === '10000') {
                        this.categories = res.data.data;
                    }
                });
            },
            onSubmit(name) {
                this.formData.description = this.editor.txt.html();
                if (this.formData.description === '') {
                    this.$Message.error('文章内容不能为空');
                    return;
                }
                this.$refs[name].validate((valid) => {
                    if (valid) {
                        this.$Loading.start();
                        if (this.$route.params.id > 0) {
                            this.axios.post('/articles/' + this.$route.params.id, this.formData).then(res => {
                                if (res.data.code === '10000') {
                                    this.$Message.success(res.data.message);
                                    this.$router.push('/');
                                } else {
                                    this.$Message.error(res.data.message);
                                }
                            }).catch(error => {
                                this.$Message.error('系统错误');
                            })
                        } else {
                            this.axios.post('/articles', this.formData).then(res => {
                                if (res.data.code === '10000') {
                                    this.$Message.success(res.data.message);
                                    this.$router.push('/');
                                } else {
                                    this.$Message.error(res.data.message);
                                }
                            }).catch(error => {
                                this.$Message.error('系统错误');
                            })
                        }
                        this.$Loading.finish();
                    } else {
                        this.$Message.error('发布失败');
                    }
                })
            },
            getArticle() {
                if (this.$route.path.includes('/articles/edit')) {
                    this.axios.get('/articles/edit/' + this.$route.params.id).then(res => {
                        if (res.data.code === '10000') {
                            this.formData.id = res.data.data.id
                            this.formData.title = res.data.data.title
                            this.editor.txt.html(res.data.data.description)
                            for (let key in res.data.data.tags) {
                                this.formData.tags.push(res.data.data.tags[key].title)
                            }
                            this.formData.category_id = res.data.data.category_id
                        } else {
                        this.$Message.error(res.data.message)
                        }
                    })
                }
            }
        },
        mounted() {
            this.editor = null
            this.initEditor()
            this.getCategories()
            this.getArticle()
        }
    }
</script>

<style lang="less" scoped rel="stylesheet/less">
    @import "Add.less";
</style>
