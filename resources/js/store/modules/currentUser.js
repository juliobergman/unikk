import axios from "axios";

const state = {
    user: {}
};
const getters = {};
const actions = {
    getUser({ commit }) {
        axios.get("user/current").then(response => {
            commit("setUser", response.data);
        });
    },
    loginUser({}, user) {
        return axios
            .post("login", {
                email: user.email,
                password: user.password,
                remember: user.remember
            })
            .then(response => {
                if (response.status === 204) {
                    window.location.replace("/home");
                }
            });
    }
};
const mutations = {
    setUser(state, data) {
        state.user = data;
    }
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
};
