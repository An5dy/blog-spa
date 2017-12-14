<template>
    <transition name="sidebar-slide-fade">
        <div class="sidebar">
            <div class="sidebar-article">
                <Collapse v-model="choose" accordion>
                    <Panel name="1">
                        最新文章
                        <p slot="content">
                            <router-link v-for="newList in newLists"
                            :key="newList.id"
                            :to="{ name: 'show', params: { id: newList.id }}">
                            {{ newList.title }}
                            </router-link>
                            <router-link to="/new" v-show="newLists.length >= 5">查看更多...</router-link>
                        </p>
                    </Panel>
                    <Panel name="2">
                        最热文章
                        <p slot="content">
                            <router-link v-for="hotList in hotLists"
                            :key="hotList.id"
                            :to="{ name: 'show', params: { id: hotList.id }}">
                            {{ hotList.title }}
                            </router-link>
                            <router-link to="/" v-show="hotLists.length >= 5">查看更多...</router-link>
                        </p>
                    </Panel>
                </Collapse>
            </div>
            <div class="friendly-link">
                <Collapse value="1">
                    <Panel name="1">
                        友情链接
                        <p slot="content">
                            <a v-for="friendlyLink in friendlyLinks" :href="friendlyLink.path">{{ friendlyLink.description }}</a>
                        </p>
                    </Panel>
                </Collapse>
            </div>
        </div>
    </transition>
</template>

<script>
    export default {
        name: 'Sidebar',
        data() {
            return {
                hotLists: [],
                newLists: [],
                friendlyLinks: [],
                choose: ''
            }
        },
        methods: {
            getData() {
                this.axios.post('/articles/sidebar').then(res => {
                    if (res.data.code === '10000') {
                        this.hotLists = res.data.data.hot
                        this.newLists = res.data.data.new
                    }
                }).catch(error => {
                    this.$Message.error('文章数据获取失败');
                })
            },
            getFriendlyLink() {
                this.axios.post('/friendly_links').then(res => {
                    if (res.data.code === '10000') {
                        this.friendlyLinks = res.data.data
                    }
                }).catch(error => {
                    this.$Message.error('友情链接获取失败')
                })
            }
        },
        mounted() {
            this.getData()
            this.getFriendlyLink()
        },
    }
</script>

<style lang="less" scoped rel="stylesheet/less">
    @import "Sidebar.less";
</style>
