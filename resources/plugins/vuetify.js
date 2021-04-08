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
                info: colors.lightBlue.lighten2,
                success: colors.green.base,
                warning: colors.yellow.base,
                danger: colors.red.lighten1,
                error: colors.red.base,
                background: colors.shades.white,
                borderPie: colors.shades.white
            },
            dark: {
                primary: colors.blue.darken2,
                secondary: colors.blue.lighten2,
                accent: colors.blue.base,
                info: colors.lightBlue.lighten2,
                success: colors.green.base,
                warning: colors.yellow.base,
                danger: colors.red.darken1,
                error: colors.red.base,
                background: "#121212",
                borderPie: "#1E1E1E"
            }
        }
    }
};

export default new Vuetify(opts);
