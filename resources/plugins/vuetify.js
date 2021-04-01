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
                primary: colors.blue.darken1, // #E53935
                secondary: colors.blue.darken2, // #FFCDD2
                accent: colors.blue.base // #3F51B5
            },
            dark: {
                primary: colors.blue.darken3, // #E53935
                secondary: colors.blue.lighten2, // #FFCDD2
                accent: colors.blue.base // #3F51B5
            }
        }
    }
};

export default new Vuetify(opts);
