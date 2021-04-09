import axios from "axios";

const state = {
    user: {}
};
const getters = {};
const actions = {
    getUser({ commit }) {
        axios.get("/api/v1/user/current").then(response => {
            commit("setUser", response.data);
        });
    },
    loginUser({}, user) {
        return axios
            .post("login", {
                _token: user.csrf_token,
                email: user.email,
                password: user.password,
                remember: user.remember
            })
            .then(response => {
                if (response.data.access_token) {
                    // Save the Token
                    localStorage.setItem(
                        "api_token",
                        response.data.access_token
                    );
                    window.location.replace("/");
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
