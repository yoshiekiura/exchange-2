import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

import contacts from '../views/contacts/index.vue'
import support from '../views/support/index.vue'
import profile from '../views/profile/index.vue'
import index from '../views/index.vue'
import requestStore from '../views/request/store.vue'
import requestShow from '../views/request/show.vue'
import requestShowPartial from '../views/request/show_partial.vue'
import userRequestShow from '../views/profile/request/show.vue'
import userReplyShow from '../views/profile/request/show_reply.vue'
import userRequests from '../views/profile/request/index.vue'
import userWallets from '../views/profile/wallet/index.vue'
import userRequestPartialShow from '../views/profile/request/show_partial.vue'
import resetPassword from '../components/modals/resetPassword.vue'

const router = new VueRouter({
    mode: 'history',

    routes: [
        { path: '/', component: index },
        { path: '/reset-password/:token', component: resetPassword, props: true },
        { path: '/support', component: support },
        { path: '/contacts', component: contacts },
        { path: '/makeExchange', component: requestStore },
        { path: '/viewExchange/:id', component: requestShow, props: true },
        { path: '/viewExchangePartial/:id', component: requestShowPartial, props: true },
        { path: '/viewUserRequest/:id', component: userRequestShow, props: true },
        { path: '/viewUserRequestPartial/:id', component: userRequestPartialShow, props: true },
        { path: '/viewUserReply/:id', component: userReplyShow, props: true },
        { path: '/profile', component: profile ,
            children: [
                { path: 'user-requests', component: userRequests, props: true},
                { path: 'user-wallets', component: userWallets, props: true },
            ]
        },
    ]

});

export default router;