import axios from "axios";

const state = {
    membership: null,
    membership_id: null,
    company_id: null
};
const getters = {};
const actions = {
    getMembership({ commit }) {
        axios.get("membership/current").then(response => {
            commit("setMembership", response.data);
        });
    },
    getMembershipId({ commit }) {
        axios.get("membership/current").then(response => {
            commit("setMembershipId", response.data.id);
        });
    },
    getCompanyId({ commit }) {
        axios.get("membership/current").then(response => {
            commit("setCompanyId", response.data.company_id);
        });
    }
};
const mutations = {
    setMembership(state, data) {
        state.membership = data;
    },
    setMembershipId(state, data) {
        axios.put("membership/default/" + data).then(response => {
            if (response.status == 200) {
                localStorage.setItem("company", response.data.company_id);
                state.membership = response.data;
                state.membership_id = response.data.id;
                state.company_id = response.data.company_id;
            }
        });
    },
    setCompanyId(state, data) {
        state.company_id = data;
    }
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
};
