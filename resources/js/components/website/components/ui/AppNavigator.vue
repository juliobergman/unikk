<template>
    <v-footer fixed color="rgba(0,0,0,0)" :dark="darkNavs">
        <v-card
            tile
            flat
            color="rgba(0,0,0,0)"
            width="100%"
            class="text-center"
        >
            <v-btn @click="goto('prev')" class="mx-2" icon>
                <v-icon>mdi-chevron-up</v-icon>
            </v-btn>
            <v-btn @click="goto('next')" class="mx-2" icon>
                <v-icon>mdi-chevron-down</v-icon>
            </v-btn>
        </v-card>
    </v-footer>
</template>

<script>
import { bus } from "../../../../bus";
export default {
    data: () => ({
        currentRoute: null,
        routes: []
    }),
    methods: {
        busEmit(name, data = null) {
            bus.$emit(name, data);
        },
        goto(action) {
            let go;
            if (action == "prev") {
                go = parseInt(this.$router.currentRoute.meta.depth) - 1;
                if (go <= 0) {
                    go = 0;
                }
            }
            if (action == "next") {
                go = parseInt(this.$router.currentRoute.meta.depth) + 1;
                if (this.$router.currentRoute.meta.depth >= 5) {
                    go = 0;
                }
            }
            let route = this.routes[go].name;
            if (this.$route.name == route) {
                return;
            }
            this.$router.push({ name: route });
        }
    },
    computed: {
        darkNavs() {
            return this.$route.meta.darkNavs;
        }
    },
    created() {
        this.currentRoute = this.$router.currentRoute.meta.depth;
        this.$router.options.routes.forEach((e, i) => {
            this.routes.push({
                key: i,
                name: e.name
            });
        });
    },
    mounted() {
        window.addEventListener("keyup", e => {
            if (e.key === "ArrowUp" || e.key === "ArrowLeft") {
                this.goto("prev");
            }
            if (e.key === "ArrowDown" || e.key === "ArrowRight") {
                this.goto("next");
            }
        });
    }
};
</script>

<style scoped>
.navcontainer {
    position: absolute;
    bottom: 0;
    z-index: 10;
    background: gold;
    color: #fff;
}
</style>
