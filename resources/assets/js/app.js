require('./bootstrap');

import Vue from 'vue'
import App from './components/App.vue'
import router from './router'
import AsyncComputed from 'vue-async-computed'
import infiniteScroll from 'vue-infinite-scroll'

Vue.use(infiniteScroll);
Vue.use(AsyncComputed);

const app = new Vue({
    el: '#app',
    template: '<app></app>',
    components: {
        App
    },
    router
});
