import Vue from 'vue';
import App from './App.vue';
import router from './router';
import store from './store';
import './registerServiceWorker';

import ApiClient from '@/ts/core/apiClient';
import { faSpinner } from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { library } from '@fortawesome/fontawesome-svg-core';
import { RequestFactory } from '@/ts/core/requestFactory';

library.add(faSpinner);

Vue.config.productionTip = false;

// Use the API URL defined in the .env.local file if present, otherwise default to the live URL.
const BASE_URL = process.env.VUE_APP_BASE_URL || 'https://secure.chapmandigital.co.uk/horribleweather';
const apiClient = new ApiClient(BASE_URL);

const myWindow: any = window;
myWindow.apiClient = apiClient;

const requestFactory = new RequestFactory(apiClient);

Vue.use(apiClient);
Vue.use(requestFactory);

Vue.component('font-awesome-icon', FontAwesomeIcon);

new Vue({
  router,
  store,
  render: (h) => h(App),
}).$mount('#app');
