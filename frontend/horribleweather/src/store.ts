import Vue from 'vue';
import Vuex from 'vuex';
import createPersistedState from 'vuex-persistedstate';
import { WeatherStore } from '@/ts/domains/weather/store/WeatherStore';

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        weather: WeatherStore,
    },
    plugins: [createPersistedState()],
});
