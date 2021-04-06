import Vue from "vue";
import Vuetify from "vuetify/lib";
import colors from "vuetify/lib/util/colors";

Vue.use(Vuetify);

const opts = {
    theme: {
        light: false,
        dark: false,
        themes: {
            light: {
                primary: colors.blue.lighten1,
                secondary: colors.blue.darken2,
                accent: colors.blue.base,
                danger: colors.red.lighten1,
                background: colors.shades.white
            },
            dark: {
                primary: colors.blue.darken2,
                secondary: colors.blue.lighten2,
                accent: colors.blue.base,
                danger: colors.red.darken1,
                background: colors.grey.darken4
            }
        }
    }
};

export default new Vuetify(opts);
