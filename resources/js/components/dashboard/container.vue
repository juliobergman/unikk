<template>
    <v-main ref="dashboard" v-resize="onResize">
        <v-container fluid>
            <v-row>
                <v-col cols="12" :md="fsinsize">
                    <v-row>
                        <v-col v-show="!fsinsights" cols="12" md="4">
                            <result-card
                                id="comp1"
                                :bus="bus"
                                :darkTheme="darkTheme"
                                :style="'height: ' + cheight + 'px;'"
                                :resid="4"
                            ></result-card>
                        </v-col>
                        <v-col v-show="!fsinsights" cols="12" md="4">
                            <result-card
                                id="comp2"
                                :bus="bus"
                                :darkTheme="darkTheme"
                                :style="'height: ' + cheight + 'px;'"
                                :resid="21"
                            ></result-card>
                        </v-col>
                        <v-col v-show="!fsinsights" cols="12" md="4">
                            <result-card
                                id="comp3"
                                :bus="bus"
                                :darkTheme="darkTheme"
                                :style="'height: ' + cheight + 'px;'"
                                :resid="36"
                            ></result-card>
                        </v-col>
                        <v-col cols="12">
                            <insights
                                id="sparks"
                                :bus="bus"
                                :darkTheme="darkTheme"
                            ></insights>
                        </v-col>
                    </v-row>
                </v-col>
                <v-col v-show="!fsinsights" cols="12" md="5">
                    <sparks
                        v-if="loaded"
                        :bus="bus"
                        :darkTheme="darkTheme"
                        :mheight="sheight"
                    ></sparks>
                </v-col>
            </v-row>
        </v-container>
    </v-main>
</template>

<script>
import resultCard from "./components/resultCard";
import Sparks from "./components/sparks";
import Insights from "./components/insights";
export default {
    props: ["bus"],
    components: { resultCard, Sparks, Insights },
    data: () => ({
        loaded: true,
        sheight: null,
        cheight: 120,
        fsinsights: false
    }),
    computed: {
        darkTheme() {
            return this.$vuetify.theme.dark ? true : false;
        },
        fsinsize() {
            return this.fsinsights ? 12 : 7;
        }
    },
    methods: {
        sparkHeight() {
            this.loaded = false;
            setTimeout(() => {
                let h1 = document.getElementById("comp1").offsetHeight;
                let h2 = document.getElementById("sparks").offsetHeight;
                let height = h1 + h2 + 24;
                this.sheight = height;
                if (window.innerWidth < 960) {
                    this.sheight = "auto";
                }
            }, 1);
            this.loaded = true;
        },
        onResize() {
            this.sparkHeight();
        }
    },
    created() {
        this.bus.$on("insights:loaded", () => {
            this.sparkHeight();
        });
        this.bus.$on("insights:fullscreen", data => {
            this.fsinsights = data;
        });
    }
};
</script>
