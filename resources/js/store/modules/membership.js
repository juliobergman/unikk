import axios from "axios";

const state = {
    company: null
};
const getters = {};
const actions = {
    getCompany({ commit }) {
        axios.get("membership/current").then(response => {
            commit("setCompany", response.data);
        });
    }
};
const mutations = {
    setCompany(state, data) {
        localStorage.setItem("company", data);
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
