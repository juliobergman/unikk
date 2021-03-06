import Vue from "vue";
import Vuetify from "vuetify/lib";
import colors from "vuetify/lib/util/colors";

// Custom Icons
import iconMain from "../js/components/ui/icons/main";

Vue.use(Vuetify);

const opts = {
    theme: {
        dark: false,
        themes: {
            light: {
                primary: "#262626",
                secondary: colors.blue.darken2,
                accent: colors.lightBlue.accent3,
                info: colors.lightBlue.lighten2,
                success: colors.green.base,
                warning: colors.yellow.base,
                danger: colors.red.lighten1,
                error: colors.red.base,
                disabled: colors.grey.lighten1,
                background: colors.shades.white,
                borderPie: colors.shades.white,
                qualitativePalette: [
                    "#1A1AFF99",
                    "#FF881A99",
                    "#34FF1A99",
                    "#FF1AD599",
                    "#00A37A99",
                    "#13386799",
                    "#FF1A1A99",
                    "#08800099",
                    "#1A1AFF99",
                    "#FF881A99",
                    "#34FF1A99",
                    "#FF1AD599",
                    "#00A37A99",
                    "#13386799",
                    "#FF1A1A99",
                    "#08800099",
                    "#1A1AFF99",
                    "#FF881A99",
                    "#34FF1A99",
                    "#FF1AD599",
                    "#00A37A99",
                    "#13386799",
                    "#FF1A1A99",
                    "#08800099"
                ]
            },
            dark: {
                primary: "#ffffff",
                secondary: colors.blue.lighten2,
                accent: colors.lightBlue.accent2,
                info: colors.lightBlue.lighten2,
                success: colors.green.base,
                warning: colors.yellow.base,
                danger: colors.red.darken1,
                error: colors.red.base,
                disabled: colors.grey.lighten2,
                background: "#121212",
                borderPie: "#1E1E1E",
                qualitativePalette: [
                    "#1A1AFF99",
                    "#FF881A99",
                    "#34FF1A99",
                    "#FF1AD599",
                    "#00A37A99",
                    "#13386799",
                    "#FF1A1A99",
                    "#08800099",
                    "#1A1AFF99",
                    "#FF881A99",
                    "#34FF1A99",
                    "#FF1AD599",
                    "#00A37A99",
                    "#13386799",
                    "#FF1A1A99",
                    "#08800099",
                    "#1A1AFF99",
                    "#FF881A99",
                    "#34FF1A99",
                    "#FF1AD599",
                    "#00A37A99",
                    "#13386799",
                    "#FF1A1A99",
                    "#08800099"
                ]
            }
        }
    }
};

export default new Vuetify(opts);
