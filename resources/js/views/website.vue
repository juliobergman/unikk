<template>
    <v-app id="websiteAppBody">
        <v-app-bar
            v-scroll.#websiteAppBody="onScroll"
            :color="webAppBarColor"
            :class="webAppBarClass"
            elevate-on-scroll
            app
            id="websiteAppBar"
        >
            <v-container class="ma-0 pa-0 d-flex mx-auto">
                <v-btn tile icon class="d-none d-md-flex p-2 ml-3" disabled>
                    <nav-logo :fill="'white'"></nav-logo>
                </v-btn>
                <v-spacer></v-spacer>
                <v-btn-toggle v-model="activeSection" tile group dark>
                    <v-btn
                        active-class="btn-appbar-active"
                        v-for="(item, idx) in navigation"
                        :key="idx"
                        :value="item.link"
                        @click="scrollTo(item.link)"
                    >
                        {{ item.text }}
                    </v-btn>
                </v-btn-toggle>
            </v-container>
        </v-app-bar>
        <welcome id="welcome" ref="welcome"></welcome>
        <approach id="approach" ref="approach"></approach>
        <contact id="contact" ref="contact"></contact>
        <footer-container></footer-container>
    </v-app>
</template>

<script>
import welcome from "../components/website/welcome";
import approach from "../components/website/approach";
import contact from "../components/website/contact";
import footerContainer from "../components/website/footer";
import navLogo from "../components/ui/icons/main";
import * as easings from "vuetify/es5/services/goto/easing-patterns";
export default {
    components: {
        welcome,
        approach,
        contact,
        footerContainer,
        navLogo
    },
    data: () => ({
        activeSection: "welcome",
        webAppBarColor: "transparent",
        webAppBarClass: "d-flex justify-center d-md-inline",
        easings: Object.keys(easings),
        options: {
            duration: 600,
            offset: 0,
            easing: "easeInOutCubic"
        },
        navigation: [
            { text: "Home", link: "welcome" },
            { text: "Our Approach", link: "approach" },
            { text: "Contact Us", link: "contact" }
        ],
        links: ["Home", "Our Approach", "Contact Us"]
    }),
    methods: {
        scrollTo(e) {
            console.log(e);
            this.options.offset =
                document.getElementById("websiteAppBar").clientHeight * -1;

            this.$vuetify.goTo("#" + e, this.options);
        },
        onScroll() {
            let scrollPosition = window.scrollY;

            if (scrollPosition > 0) {
                this.webAppBarColor = "primary";
                this.webAppBarClass =
                    "d-flex justify-center d-md-inline main-gradient";
            }
            if (scrollPosition == 0) {
                this.webAppBarColor = "transparent";
                this.webAppBarClass = "d-flex justify-center d-md-inline";
            }

            // console.log(document.getElementById("approach").offsetTop);
        }
    }
};
</script>

<style scoped>
.v-btn::before {
    background-color: transparent;
}
</style>
