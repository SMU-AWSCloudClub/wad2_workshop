// import './assets/main.css'

import { createApp } from 'vue'
import App from './App.vue'
// import bootstrap from 'bootstrap'
import '../src/assets/styles.scss'

window.global = window;
createApp(App).mount('#app')
