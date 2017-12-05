<template>
    <header ref="header">
        <Row type="flex" align="middle" justify="space-between" class="header">
            <i-col span="10" class="logo">
                <router-link to="/">SEE THE FUTURE</router-link>
            </i-col>
            <i-col span="14">
                <ul class="header-menu">
                    <li class="login" v-if="! $store.state.userInfo.userInfo.name">
                        <router-link to="/sign">
                            <Tooltip content="登录"
                                     placement="bottom"
                                     :transfer="true">
                                <Button shape="circle" icon="log-in"></Button>
                            </Tooltip>
                        </router-link>
                    </li>
                    <li class="login" v-if="$store.state.userInfo.userInfo.name">
                        <Tooltip content="退出"
                                 placement="bottom"
                                 :transfer="true">
                            <Button shape="circle" icon="log-out" @click="logout"></Button>
                        </Tooltip>
                    </li>
                    <li class="about" v-if="$store.state.userInfo.userInfo.name">
                        <router-link to="/setting">
                            <Tooltip content="个人中心"
                                     placement="bottom"
                                     :transfer="true">
                                <Button type="info" shape="circle" icon="home"></Button>
                            </Tooltip>
                        </router-link>
                    </li>
                    <li class="about" v-if="$store.state.userInfo.userInfo.name">
                        <Avatar v-if="!$store.state.userInfo.userInfo.avatar_thumb" icon="person" />
                        <Avatar v-if="$store.state.userInfo.userInfo.avatar_thumb" :src="$store.state.userInfo.userInfo.avatar_thumb" />
                    </li>
                    <li class="search">
                        <Icon type="ios-search-strong" class="search-icon"></Icon>
                        <input type="text"
                               class="searchFiles"
                               v-model.trim="searchFiles"
                               @click="onClick(searchFiles)"
                               @blur="onBlur(searchFiles)"
                               @keyup.enter="onSearch(searchFiles)">
                    </li>
                </ul>
            </i-col>
        </Row>
    </header>
</template>

<script>
    import Headroom from 'headroom.js';
    export default {
        name: 'Header',
        data() {
            return {
                searchFiles: '请输入文章标题...',
                isTopNav: false,
                scroll: 0,
                headroom: {},
            }
        },
        methods: {
            onClick(searchFiles) {
                if (searchFiles == '请输入文章标题...') {
                    this.searchFiles = null;
                }
            },
            onBlur(searchFiles) {
                if (searchFiles == null || searchFiles == '') {
                    this.searchFiles = '请输入文章标题...';
                }
            },
            onSearch(searchFiles) {
                if (searchFiles == null || searchFiles == '') {
                    this.$Message.warning('搜索内容不能为空');
                } else {
                    this.$router.push({
                        path: '/search',
                        query: {
                            title: this.searchFiles
                        }
                    })
                }
            },
            logout() {
                this.axios.post('/logout').then(res => {
                    this.$store.dispatch('deleteUserInfo');
                    this.$router.push('/');
                    this.$Message.success('退出成功');
                })
            }
        },
        mounted() {
            this.headroom = new Headroom(this.$refs.header, {
                "tolerance": 1,
                "offset": 0,
                "classes": {
                    "initial": "animated",
                    "pinned": "bounceInDown",
                    "unpinned": "bounceOutUp"
                }
            });
            this.headroom.init();
        },
        destroyed() {
            this.headroom.destroy();
        }
    }
</script>

<style lang="less" scoped rel="stylesheet/less">
    @import "Header.less";
    /* 头部动画效果 */
    .animated {
        -webkit-animation-duration: .4s;
        -moz-animation-duration: .4s;
        -o-animation-duration: .4s;
        animation-duration: .4s;
        -webkit-animation-fill-mode: both;
        -moz-animation-fill-mode: both;
        -o-animation-fill-mode: both;
        animation-fill-mode: both;
    }
    .animated.bounceInDown {
        -webkit-animation-name: bounceInDown;
        -moz-animation-name: bounceInDown;
        -o-animation-name: bounceInDown;
        animation-name: bounceInDown;
    }
    .animated.bounceOutUp {
        -webkit-animation-name: bounceOutUp;
        -moz-animation-name: bounceOutUp;
        -o-animation-name: bounceOutUp;
        animation-name: bounceOutUp;
    }
    @keyframes bounceOutUp {
        0% {
            transform: translateY(0);
        }
        30% {
            opacity: 1;
            transform: translateY(20px);
        }
        100% {
            opacity: 0;
            transform: translateY(-100px);
        }
    }
    @keyframes bounceInDown {
        0% {
            opacity: 0;
            transform: translateY(-100px);
        }
        30% {
            opacity: 1;
            transform: translateY(30px);
        }
        100% {
            transform: translateY(0px);
        }
    }
</style>


