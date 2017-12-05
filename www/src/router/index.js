import Vue from 'vue'
import Router from 'vue-router'
import Nprogress from 'nprogress'
import 'nprogress/nprogress.css'
import JWT from '../util/jwt'

import Components from '../components'
Vue.use(Router)

let routes = [
    {
        path: '/',
        component: Components.Modules.Content,
        children: [
            {
                path: '',
                component: Components.Modules.Views.Home
            },
            {
                path: 'search',
                name: 'search',
                component: Components.Modules.Views.Home
            },
            {
                path: 'category/:id',
                name: 'category',
                component: Components.Modules.Views.Home
            },
            {
                path: 'author/:id',
                name: 'author',
                component: Components.Modules.Views.Home
            },
            {
                path: 'new',
                component: Components.Modules.Views.Home
            },
            {
                path: 'articles/add',
                component: Components.Modules.Views.Article.Add,
                meta: {
                    guest: true
                }
            },
            {
                path: 'articles/edit/:id',
                name: 'edit',
                component: Components.Modules.Views.Article.Add,
                meta: {
                    guest: true
                }
            },
            {
                path: 'articles/:id',
                name: 'show',
                component: Components.Modules.Views.Article.Show
            },
            {
                path: 'setting',
                component: Components.Modules.Views.Setting.Setting,
                redirect: '/setting/account',
                meta: {
                    guest: true
                },
                children: [
                    {
                        path: 'account',
                        component: Components.Modules.Views.Setting.Account
                    },
                    {
                        path: 'password',
                        component: Components.Modules.Views.Setting.Password
                    }
                ]
            }
        ]
    },
    {
        path: '/sign',
        component: Components.Sign
    }
]

const router = new Router ({
    mode: 'history',
    scrollBehavior: () => ({
        y: 0
    }),
    routes
})

// 路由加载设置Nprogress进度条
router.beforeEach((to, from, next) => {
    window.scroll(0, 0)// 重置导航栏
    Nprogress.start()
    if (to.matched.some(r => r.meta.guest)) {
        if (JWT.get()) {
            next()
        } else {
            next({ path:'/sign' })
        }
    }
    next()
})
router.afterEach(() => {
    Nprogress.done()
});

export default router
