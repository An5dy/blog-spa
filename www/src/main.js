// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import App from './App'
import router from './router'
import store from './store'

/* 按需引入iview组件 */
import {Row, Col} from 'iview/src/components/grid'
import Input from 'iview/src/components/input'
import Button from 'iview/src/components/button'
import Dropdown from 'iview/src/components/dropdown'
import Icon from 'iview/src/components/icon'
import BackTop from 'iview/src/components/back-top'
import Spin from 'iview/src/components/spin'
import Card from 'iview/src/components/card'
import Tag from 'iview/src/components/tag'
import {Select, Option} from 'iview/src/components/select'
import Message from 'iview/src/components/message'
import Tabs from 'iview/src/components/tabs'
import Form from 'iview/src/components/form'
import Tooltip from 'iview/src/components/tooltip'
import Avatar from 'iview/src/components/avatar'
import Collapse from 'iview/src/components/collapse'
import Loading from 'iview/src/components/loading-bar'
import Upload from 'iview/src/components/upload'
import Modal from 'iview/src/components/modal'

Vue.component(Row.name, Row)
Vue.component(Col.name, Col)
Vue.component(Input.name, Input)
Vue.component(Button.name, Button)
Vue.component('ButtonGroup', Button.Group)
Vue.component(Dropdown.name, Dropdown)
Vue.component('DropdownMenu', Dropdown.Menu)
Vue.component('DropdownItem', Dropdown.Item)
Vue.component(Icon.name, Icon)
Vue.component('BackTop', BackTop)
Vue.component(Spin.name, Spin)
Vue.component(Card.name, Card)
Vue.component(Tag.name, Tag)
Vue.component('Select', Select)
Vue.component('Option', Option)
Vue.component('Tabs', Tabs)
Vue.component('TabPane', Tabs.Pane)
Vue.component('Form', Form)
Vue.component('FormItem', Form.Item)
Vue.prototype.$Message = Message
Vue.component(Tooltip.name, Tooltip)
Vue.component(Avatar.name, Avatar)
Vue.component(Collapse.name, Collapse)
Vue.component('Panel', Collapse.Panel)
Vue.prototype.$Loading = Loading
Vue.component(Upload.name, Upload)
Vue.prototype.$Modal = Modal

import 'iview/src/styles/index.less';

Vue.config.devtools = true;
Vue.config.productionTip = false

// 设置axios
import './util/axios'

/* eslint-disable no-new */
window.vm = new Vue({
  el: '#app',
  router,
  store,
  template: '<App/>',
  components: { App }
})
