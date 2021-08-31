<template>
    <v-navigation-drawer
        v-model="drawer"
        right
        app
        dark
        temporary
        color="rgba(0,0,0,0.7)"
    >
        <v-list-item class="pa-10">
            <logo :fill="'white'" />
        </v-list-item>

        <v-divider></v-divider>

        <v-list dense nav class="mt-1">
            <v-menu offset-y dark>
                <template v-slot:activator="{ on, attrs }">
                    <v-list-item link v-bind="attrs" v-on="on">
                        <v-list-item-icon>
                            <v-icon>mdi-translate</v-icon>
                        </v-list-item-icon>

                        <v-list-item-content>
                            <v-list-item-title>{{ lang }}</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                </template>
                <v-list>
                    <v-list-item
                        v-for="language in languages"
                        :key="language.name"
                        @click="setLanguage(language)"
                    >
                        <v-list-item-title>{{
                            language.name
                        }}</v-list-item-title>
                    </v-list-item>
                </v-list>
            </v-menu>
        </v-list>

        <v-divider></v-divider>

        <v-list dense nav>
            <v-list-item
                v-for="item in items"
                :key="item.title"
                @click="goto(item)"
                link
            >
                <v-list-item-icon>
                    <v-icon>{{ item.icon }}</v-icon>
                </v-list-item-icon>

                <v-list-item-content>
                    <v-list-item-title>{{ $t(item.lang) }}</v-list-item-title>
                </v-list-item-content>
            </v-list-item>
        </v-list>
    </v-navigation-drawer>
</template>

<script>
import { bus } from "../../../../bus";
import Logo from "./icons/logo.vue";
export default {
    components: {
        Logo
    },
    data: () => ({
        drawer: false,
        selected: 0,
        lang: "",
        languages: [
            { name: "English", value: "en" },
            { name: "Deutsch", value: "de" },
            { name: "Español", value: "es" }
        ],
        items: [
            {
                icon: "mdi-home",
                to: "webwelcome",
                lang: "welcome"
            },
            {
                icon: "mdi-domain",
                to: "webabout",
                lang: "about"
            },
            {
                icon: "mdi-finance",
                to: "webinvestment",
                lang: "investment"
            },
            {
                icon: "mdi-earth",
                to: "webgeofocus",
                lang: "geofocus"
            },
            {
                icon: "mdi-at",
                to: "webcontact",
                lang: "contact"
            }
        ]
    }),
    methods: {
        goto(item) {
            if (item.to == this.$router.currentRoute.name) {
                this.drawer = false;
                return;
            }
            this.$router.push({ name: item.to });
        },
        setLanguage(language) {
            localStorage.setItem("lang", language.value);
            localStorage.setItem("language", language.name);
            this.lang = language.name;
            window.location.reload();
        }
    },
    created() {
        this.lang = localStorage.getItem("language") || "English";
        this.items.findIndex((element, index) => {
            if (element.to == this.$router.currentRoute.name) {
                this.selected = index;
            }
        });
        bus.$on("drawer:set", payload => {
            this.drawer = payload;
        });
        bus.$on("drawer:toggle", () => {
            this.drawer = !this.drawer;
        });
        bus.$on("menu:go", this.goto);
    },
    watch: {}
};
</script>

<style></style>
