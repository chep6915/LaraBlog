import * as Vue from 'vue' // in Vue 3
import axios from 'axios'
import VueAxios from 'vue-axios'
import ElementPlus from 'element-plus'
import 'element-plus/dist/index.css'
import App from './App.vue'
import router from './router'

import '@/styles/index.scss'
import store from './store'
// import './permission' // permission control

const app = Vue.createApp(App)
app.use(VueAxios, axios)
app.use(router)
app.use(store)
app.use(ElementPlus)
app.mount('#app')