/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("./bootstrap");

// window.axios.defaults.headers.common["X-CSRF-TOKEN"] = $(
//     'meta[name="csrf-token"]'
// ).attr("content");

window.Vue = require("vue").default;

import Vuetify from "../plugins/vuetify";
import i18n from "../plugins/i18n";
import store from "./store";
import router from "./router";
import AOS from "aos";
import "aos/dist/aos.css";
import moment from "moment";

Vue.prototype.moment = moment;

Vue.component("view-login", require("./views/login.vue").default);
Vue.component(
    "view-create-password",
    require("./views/createPassword.vue").default
);
Vue.component("app-container", require("./views/appContainer.vue").default);
Vue.component(
    "website-container",
    require("./components/website/App.vue").default
);

const app = new Vue({
    store,
    router,
    vuetify: Vuetify,
    i18n,
    created() {
        AOS.init();
    },
    el: "#app"
});
