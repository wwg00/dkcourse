import Vue from 'vue'
import App from './App.vue'
import router from './routers/index'
import ElementUI from '../node_modules/element-ui'
import rem from './utils/getRem';
import './scss/base.scss';
import Vuelazyload from 'vue-lazyload'

Vue.use(Vuelazyload, {
    error:require('./assets/image/error.jpg'),
    loading: require('./assets/image/loading.gif')
})

rem.rem();
new Vue({
  el: '#app',
  router,
  render: h => h(App)
})

