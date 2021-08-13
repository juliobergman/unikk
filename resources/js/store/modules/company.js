import axios from "axios";

const state = {
    company: {}
};
const getters = {};
const actions = {
    getCompany({ commit }) {
        axios.get("company/current").then(response => {
            commit("setCompany", response.data);
        });
    }
};
const mutations = {
    setCompany(state, data) {
        state.company = data;
    }
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
};
