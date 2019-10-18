import Vue from 'vue'
import VueRouter from 'vue-router'
import axios from 'axios'
import VueAxios from 'vue-axios'
import navigation from './components/navigation.vue'
import vuehead from './components/vuehead.vue'
import vueheaddesktop from './components/vuehead-desktop.vue'
import  home from './components/pages/home.vue'
import  account from './components/pages/account.vue'
import  elections from './components/pages/elections.vue'
import  referenda from './components/pages/referenda.vue'
import  referendum from './components/pages/details/referendum.vue'
import  apply from './components/pages/details/apply.vue'
import  election from './components/pages/details/election.vue'
import  group from './components/pages/details/group.vue'
import  party from './components/pages/details/party.vue'
import  user from './components/pages/details/user.vue'
import  newReferendum from './components/pages/details/newReferendum.vue'
import  groups from './components/pages/groups.vue'
import  parties from './components/pages/parties.vue'
import VeeValidate from 'vee-validate'
import VuePaginate from 'vue-paginate';
import lodash from 'lodash'
import VueLodash from 'vue-lodash/dist/vue-lodash.min'
import electionVote from './components/pages/details/electionVote.vue'

Vue.use(VeeValidate)
Vue.use(VueRouter)
Vue.use(VueAxios, axios)
Vue.use(VuePaginate)
Vue.use(VueLodash, lodash)

window.axios = require('axios');


/**set default header of axios with authorization api token*/
window.axios.defaults.headers.common = {
    'X-CSRF-TOKEN': window.Laravel.csrfToken,
    'X-Requested-With': 'XMLHttpRequest',
    'Authorization': 'Bearer ' + window.Laravel.api_token,
};

const routes = [
    {
        path: '/',
        component: home ,
        name: 'home',
    },
    {
        path: '/elections',
        component: elections,
        name: 'elections',
    },
    {
        path: '/elections/:id',
        component: election,
        name: 'election',
        props: true,
    },
    {
        path: '/elections/:id/vote',
        component: electionVote,
        name: 'electionVote',
        props: true,
    },
    {
        path: '/elections/:id/apply',
        component: apply,
        name: 'applyElection',
        props: true,
    },
    {
        path: '/referenda',
        component: referenda,
        name: 'referenda',
    },
    {
        path: '/referenda/new',
        component: newReferendum,
        name: 'newReferenda',
    },
    {
        path: '/referenda/:id',
        component: referendum,
        name: 'referendum',
        props: true,
    },
    {
        path: '/groups',
        component: groups,
        name: 'groups',
    },
    {
        path: '/groups/:id',
        component: group,
        name: 'group',
        props: true,
    },
    {
        path: '/parties',
        component: parties,
        name: 'parties',
    },
    {
        path: '/parties/:id',
        component: party,
        name: 'party',
        props: true,
    },
    {
        path: '/account',
        component: account,
        name: 'account',
    },
    {
        path: '/users/:id',
        component: user,
        name: 'user',
    },
]
const router = new VueRouter({
    // mode: 'history',
    routes // short for routes: routes
})
new Vue({
    router,
    el: '#app',
    components: {navigation, vuehead, vueheaddesktop}
})
