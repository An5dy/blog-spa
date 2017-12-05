<template>
    <div class="article">
        <transition name="fade" :class="false">
            <Row class="article-content" v-if="show">
                <i-col>
                    <div class="article-title">
                        <h2>{{ article.title }}</h2>
                    </div>
                    <div class="article-author">
                        作者: {{ author.name }}
                    </div>
                    <div class="article-menu">
                        <ul>
                            <li>分类: {{ category.title }}</li>
                            <li>发布时间: {{ article.created_at }}</li>
                            <li><Icon type="fireball" color="#ed3f14"></Icon> {{ article.checked_num }}</li>
                            <li class="article-editor" v-show="$store.state.userInfo.userInfo.id==author.id">
                                <router-link :to="{ name: 'edit', params: { id: article.id }}">
                                    <Icon type="edit"></Icon>
                                    编辑
                                </router-link>
                            </li>
                        </ul>
                    </div>
                    <div class="article-description"  v-html="article.description"></div>
                    <div class="article-tags">
                        <div class="tags">
                            <span>标签:</span>
                            <Tag color="blue" v-for="(tag,index) in tags" :key="tag.id">{{ tag.title }}</Tag>
                        </div>
                    </div>
                </i-col>
            </Row>
        </transition>
        <menu-list></menu-list>
    </div>
</template>

<script>
    import {MenuList} from 'Commons'
    export default {
        name: 'show',
        components: {
            MenuList
        },
        data() {
            return {
                article: {},
                author: {},
                category: {},
                tags: [],
                show: false
            }
        },
        methods: {
            getArticle() {
                this.$Loading.start()
                this.axios.get('/articles/' + this.$route.params.id).then(res => {
                    if (res.data.code === '10000') {
                        this.article = res.data.data
                        this.author = res.data.data.author
                        this.category = res.data.data.category
                        this.tags = res.data.data.tags
                        this.show = true
                    } else {
                        this.$Message.error('当前文章不存在')
                        this.$router.push('/')
                    }
                }).catch(error => {
                    this.$Message.error('当前文章不存在')
                    this.$router.push('/')
                })
                this.$Loading.finish()
            }
        },
        mounted() {
            this.getArticle()
        }
    }
</script>

<style lang="less" scoped rel="stylesheet/less">
    @import "Show.less";
</style>
