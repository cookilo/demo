
// import Vue from 'vue';
import Vuex from 'vuex';
import state from './state';
import getters from './getters'
const store = new Vuex.Store({
    // modules,
    // actions,
    getters,
    // mutations,
    state,
});

export default store;