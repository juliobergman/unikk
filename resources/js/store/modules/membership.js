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
        axios.put("membership/default/" + data).then(response => {
            if (response.status == 200) {
                localStorage.setItem("company", data);
                state.company = data;
            }
        });
    }
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
};
