// let Vue = require('vue');
import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

let routes = [
    {
        path: '/',
        component: require('./components/MainComponent'),
        name: 'MainComponent',

    },
    {
        path: '/survey/:id',
        name: 'edit',
        component: require('./components/Survey')
    },
    // {
    //     path: '/guide',
    //     component: require('./components/UserGuide')
    // },
    // {
    //     path: '/unfilteredResults',
    //     name: 'unfilteredResults',
    //     component: require('./components/UnfilteredResults')
    // },
    // {
    //     path: '/evaluations',
    //     name: 'evaluations',
    //     component: require('./components/Evaluations')
    // },
    // {
    //     path: '/finalevaluations',
    //     name: 'finalevaluations',
    //     component: require('./components/EvaluationsFinal')
    // }
];

export default new VueRouter({
    routes
});