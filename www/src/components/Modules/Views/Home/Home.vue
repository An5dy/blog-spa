<template>
    <Row class="content">
        <i-col span="16" class="article-list">
            <transition-group name="list" tag="div">
                <article-item v-for="(article, index) in articles"
                              :article="article"
                              :key="article.id">
                </article-item>
            </transition-group>
        <div class="demo-spin-container">
            <Spin fix v-if="spinShow">
                <Icon type="load-c" size=18 class="demo-spin-icon-load"></Icon>
                <div>加载中...</div>
            </Spin>
            <div v-if="!hasMore">已加载全部...</div>
        </div>
        </i-col>
        <i-col span="8" class="sidebar-right">
            <sidebar></sidebar>
        </i-col>
        <menu-list></menu-list>
    </Row>
</template>

<script>
    import {MenuList, ArticleItem, Sidebar} from 'Commons'
    import Scroll from '../../../../util/scroll'
    export default {
        name: 'Home',
        components: {
            MenuList: MenuList,
            ArticleItem: ArticleItem,
            Sidebar: Sidebar
        },
        data() {
            return {
                articles: [],
                hasMore: false,
                spinShow: false,
                nextPage: 1,
                currentPage: 1,
                lastPage: 1,
            }
        },
        methods: {
            getArticles() {
                // 加载进度条
                this.$Loading.start()
                let data = {
                    page: this.nextPage
                };
                if (this.$route.path === '/search' && this.$route.query.title != null) {
                    // 文章标题搜索
                    data['title'] = this.$route.query.title
                } else if (this.$route.path.includes('/category')) {
                    // 文章分类
                    data['category_id'] = this.$route.params.id
                } else if (this.$route.path.includes('/author')) {
                    // 作者
                    data['user_id'] = this.$route.params.id
                } else if (this.$route.path.includes('/new')) {
                    // 时间排序
                    data['order_by'] = 'time'
                }
                this.axios.get('/articles', {params: data}).then(res => {
                    if (res.data.code == '10000') {
                        this.currentPage = res.data.meta.current_page
                        this.lastPage = res.data.meta.last_page
                        if (this.currentPage < this.lastPage) {
                            this.spinShow = true
                            this.hasMore = true
                        } else {
                            this.hasMore = false
                            this.spinShow = false
                        }
                        this.articles = this.articles.concat(res.data.data)
                    }
                })
                this.$Loading.finish()
            },
            initScroll() {
                document.addEventListener('scroll', (e) => {
                    if (Scroll._getScrollTop() > 0 && Scroll.isEnd() && this.hasMore && this.lastPage > this.nextPage) {
                        this.nextPage++
                        this.getArticles()
                    }
                })
            }
        },
        watch: {
            '$route' (to, from) {
                this.articles = []
                this.currentPage = 1
                this.nextPage = 1
                this.lastPage = 1
                this.hasMore = false
                this.getArticles()
            },
        },
        mounted() {
            this.getArticles()
            this.initScroll()
        },
        destroy() {
            window.removeEventListener("scroll",this.initScroll)
        }
    }
</script>

<style lang="less" scoped rel="stylesheet/less">
    @import "Home.less";
    list-item {
        display: inline-block;
        margin-right: 10px;
    }
</style>
