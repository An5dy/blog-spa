<template>
    <div class="article-item" v-show="show">
        <Card :bordered="true">
            <div class="article-item-title">
                <router-link :to="{ name: 'show', params: { id: article.id }}">
                    <h2 v-html="article.title"></h2>
                </router-link>
            </div>
            <ul class="article-item-menu">
                <li class="article-item-menu-person">
                    <Icon type="person" color="#2d8cf0"></Icon>
                    <router-link :to="{ name: 'author', params: { id: article.author.id }}">{{ article.author.name }}</router-link>
                </li>
                <li>
                    <Icon type="ios-calendar" color="#ff9900"></Icon>
                    {{ article.created_at }}
                </li>
                <li>
                    <Icon type="filing" color="#19be6b"></Icon>
                    <router-link :to="{ name: 'category', params: { id: article.category.id }}">{{ article.category.title }}</router-link>
                </li>
                <li>
                    <Icon type="fireball" color="#ed3f14"></Icon>
                    {{ article.checked_num }}
                </li>
                <li v-if="$store.state.userInfo.userInfo.id==article.author.id" class="item-delete">
                    <a href="javascript:void(0);" @click="deleteItem">删除</a>
                </li>
            </ul>
            <div class="article-item-description">
                <router-link :to="{ name: 'show', params: { id: article.id }}">
                    <p>{{ article.description }}</p>
                </router-link>
            </div>
            <div class="article-item-content">
                <span>标签：</span>
                <Tag color="blue" v-for="tag in article.tags" :key="tag.id" class="tag">{{ tag.title }}</Tag>
                <div class="read-more">
                    <router-link :to="{ name: 'show', params: { id: article.id }}">阅读全文...</router-link>
                </div>
            </div>
        </Card>
    </div>
</template>

<script>
    export default {
        name: 'ArticleItem',
        props: {
            article: {},
        },
        data() {
            return {
                show: true
            }
        },
        methods: {
            deleteItem() {
                this.$Modal.confirm({
                    title: '提示',
                    content: '<p>是否确认删除?</p>',
                    onOk: () => {
                        this.axios.post('/articles/delete/' + this.article.id).then(res => {
                            if (res.data.code === '10000') {
                                this.$Message.success('删除成功')
                                this.show = false
                            } else {
                                this.$Message.error(res.data.message)
                            }
                        }).catch(error => {
                            this.$Message.error('删除失败')
                        })
                    }
                })
            }
        }
    }
</script>

<style lang="less" scoped rel="stylesheet/less">
    @import "ArticleItem.less";
</style>
