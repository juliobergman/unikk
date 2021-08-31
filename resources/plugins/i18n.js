import en from "./lang/en.json";
import de from "./lang/de.json";
import es from "./lang/es.json";

import Vue from "vue";
import VueI18n from "vue-i18n";
Vue.use(VueI18n);
export default new VueI18n({
    locale: localStorage.getItem("lang") || en,
    messages: {
        en: en,
        de: de,
        es: es
    }
});
