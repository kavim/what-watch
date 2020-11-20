import Vue from 'vue'
import Vuex from 'vuex'
import axios from 'axios'
import { startCase } from 'lodash';
Vue.use(Vuex)

let tvshows = window.localStorage.getItem('tvshows');
let categories = window.localStorage.getItem('categories');
let status = window.localStorage.getItem('status');
let years = window.localStorage.getItem('years');

export default new Vuex.Store({
    state: {
        
      tvshows: tvshows ? JSON.parse(tvshows) : [],
      categories: categories ? JSON.parse(categories) : [],
      status: status ? JSON.parse(status) : [],
      years: years ? JSON.parse(years) : [],
      
    },
    getters: {

    },
    mutations:{
      store_tvshows(state, tvshows){
        state.tvshows = tvshows;
      },
      store_categories(state, cats){
        state.categories = cats;
      },
      store_status(state, status){
        state.status = status;
      },
      store_years(state, years){
        state.years = years;
      },
      save_tvShow(state, tvshow){
        
        let found = state.tvshows.find(ts => ts.id == tvshow.id );

        if(found){

            found = tvshow;

        }else{

          state.tvshows.push(tvshow);

        }

      },
      
    },
    actions: {
      getTvShows({ commit, dispatch  }) {
        axios.get('/api/get-tvshows/')
        .then(function (response) {
            commit('store_tvshows', response.data.tvshows);
        })
        .catch(function (error) {
            console.log(error);
            console.log("DEU ERRO getTvShow");
        });
      },
      getCategories({ commit }) {
        axios.get('/api/get-categories/')
        .then(function (response) {
            commit('store_categories', response.data);
        })
        .catch(function (error) {
            console.log(error);
            console.log("DEU ERRO get-categories");
        });
      },
      getStatus({ commit }) {
        axios.get('/api/get-status/')
        .then(function (response) {
            commit('store_status', response.data);
        })
        .catch(function (error) {
            console.log(error);
            console.log("DEU ERRO get-status");
        });
      },
      getYears({ commit }) {
        axios.get('/api/get-years/')
        .then(function (response) {
            commit('store_years', response.data);
        })
        .catch(function (error) {
            console.log(error);
            console.log("DEU ERRO get-status");
        });
      },
      
      saveTvShow({ commit }, tvshow) {
        
        commit('save_tvShow', tvshow);
        
      },

    },

  })
