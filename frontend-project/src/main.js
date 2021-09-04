import { createApp } from 'vue'
import App from './App.vue'
import router from './router'

import '@/styles/index.scss'
import store from './store'
// import './permission' // permission control

const app = createApp(App)
app.use(router)
app.use(store)
app.mount('#app')