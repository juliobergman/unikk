import Vue from "vue";
import Vuex from "vuex";
import user from "./modules/user";
import membership from "./modules/membership";

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        user,
        membership
    }
});
