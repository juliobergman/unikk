<template>
    <v-app id="app-main">
        <app-bar />
        <drawer />
        <transition :name="transitionName" mode="out-in">
            <router-view />
        </transition>
        <app-navigator />
    </v-app>
</template>

<script>
import { bus } from "../../bus";
import AppBar from "./components/ui/AppBar.vue";
import Drawer from "./components/ui/Drawer.vue";
import AppNavigator from "./components/ui/AppNavigator.vue";
export default {
    name: "UnikkWebsite",
    components: {
        AppBar,
        Drawer,
        AppNavigator
    },
    data: () => ({
        rvid: 0,
        transitionName: "slide-down"
    }),
    methods: {
        appNavigator(action) {
            console.log(action);
        },
        onResize() {},
        scroll() {
            window.onscroll = () => {
                let bottomOfWindow =
                    Math.max(
                        window.pageYOffset,
                        document.documentElement.scrollTop,
                        document.body.scrollTop
                    ) +
                        window.innerHeight ===
                    document.documentElement.offsetHeight;

                if (bottomOfWindow) {
                    console.log("bottom");
                    // this.scrolledToBottom = true; // replace it with your code
                }
            };
        }
    },
    beforeDestroy() {
        if (typeof window === "undefined") return;
        window.removeEventListener("resize", this.onResize, { passive: true });
    },
    created() {
        if (!localStorage.getItem("lang")) {
            localStorage.setItem("lang", "en");
        }
    },
    mounted() {
        this.scroll();
        // Router Transitions
        this.$router.beforeEach((to, from, next) => {
            let toDepth = to.meta.depth;
            let fromDepth = from.meta.depth;
            this.rvid++;
            bus.$emit("key:update", this.rvid);
            this.transitionName =
                toDepth < fromDepth ? "slide-down" : "slide-up";
            next();
        });
        this.$router.afterEach(function(transition) {
            document.getElementById("container").focus();
        });
        // Resize
        this.onResize();
        window.addEventListener("resize", this.onResize, { passive: true });
    }
};
</script>
<style scoped>
.slide-enter,
.slide-leave-to {
    opacity: 0;
    transform: translateY(-200vh);
}
.slide-up-leave-to,
.slide-down-enter {
    opacity: 0;
    transform: translateY(-100vh);
}
.slide-down-leave-to,
.slide-up-enter {
    opacity: 0;
    transform: translateY(100vh);
}

.slide-enter-active,
.slide-leave-active,
.slide-down-enter-active,
.slide-down-leave-active,
.slide-up-enter-active,
.slide-up-leave-active {
    transition: all 0.3s ease;
}
</style>
