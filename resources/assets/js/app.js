require('./bootstrap');

window.Vue = require('vue');

//support vuex
import Vuex from 'vuex';
Vue.use(Vuex);
import storeData from "./store/index";

const store = new Vuex.Store(
   storeData
)

Vue.component('example-component', require('./components/ExampleeComponent.vue'));
Vue.component('test', require('./components/Test.vue'));
Vue.component('main-component', require('./components/MainComponent.vue'));
Vue.component('new-survey', require('./components/NewSurvey.vue'));
Vue.component('survey', require('./components/Survey.vue'));
Vue.component('new-question', require('./components/NewQuestion.vue'));
Vue.component('question', require('./components/Question.vue'));

const app = new Vue({
    el: '#app',
    store, //vuex
});
