<template>
    <v-main ref="dashboard" v-resize="onResize">
        <v-container fluid v-if="loaded">
            <v-row v-show="!fsinsights">
                <v-col cols="12" md="4" lg="3">
                    <result-card
                        id="comp1"
                        :bus="bus"
                        :darkTheme="darkTheme"
                        :style="'height: ' + cheight + ';'"
                        :inid="4"
                    ></result-card>
                </v-col>
                <v-col cols="12" md="4" lg="3">
                    <result-card
                        id="comp2"
                        :bus="bus"
                        :darkTheme="darkTheme"
                        :style="'height: ' + cheight + ';'"
                        :inid="21"
                    ></result-card>
                </v-col>
                <v-col cols="12" md="4" lg="3">
                    <result-card
                        id="comp3"
                        :bus="bus"
                        :darkTheme="darkTheme"
                        :style="'height: ' + cheight + ';'"
                        :inid="36"
                    ></result-card>
                </v-col>
                <v-col cols="12" md="4" lg="3">
                    <result-card
                        id="comp3"
                        :bus="bus"
                        :darkTheme="darkTheme"
                        :style="'height: ' + cheight + ';'"
                        :inid="20"
                    ></result-card>
                </v-col>
            </v-row>
            <v-row>
                <v-col
                    v-show="fsinhide[1]"
                    cols="12"
                    :md="fsinsize[0]"
                    :xl="fsinsize[1]"
                >
                    <insights
                        :key="insIds[0]"
                        id="insight"
                        :bus="bus"
                        :darkTheme="darkTheme"
                        :inid="16"
                        :ky="1"
                    ></insights>
                </v-col>
                <v-col
                    v-show="fsinhide[2]"
                    cols="12"
                    :md="fsinsize[0]"
                    :xl="fsinsize[1]"
                >
                    <insights
                        :key="insIds[1]"
                        id="insight2"
                        :bus="bus"
                        :darkTheme="darkTheme"
                        :inid="9"
                        :ky="2"
                    ></insights>
                </v-col>
                <v-col
                    v-show="fsinhide[3]"
                    cols="12"
                    :md="fsinsize[0]"
                    :xl="fsinsize[1]"
                >
                    <insights
                        :key="insIds[2]"
                        id="insight3"
                        :bus="bus"
                        :darkTheme="darkTheme"
                        :inid="21"
                        :ky="3"
                    ></insights>
                </v-col>
            </v-row>
        </v-container>
    </v-main>
</template>

<script>
import resultCard from "./components/resultCard";
import Sparks from "./components/sparks";
import SparkLine from "./components/sparkLine";
import Insights from "./components/insights";
export default {
    props: ["bus"],
    components: { resultCard, Sparks, Insights, SparkLine },
    data: () => ({
        loaded: true,
        sheight: null,
        cheight: "auto",
        fsinsights: false,
        fsinsights_id: null,
        insIds: [1, 2, 3]
    }),
    computed: {
        darkTheme() {
            return this.$vuetify.theme.dark ? true : false;
        },
        fsinsize() {
            return this.fsinsights ? [12, 12] : [6, 4];
        },
        fsinhide() {
            let mkey = this.fsinsights_id;
            let modules = {
                1: true,
                2: true,
                3: true
            };
            if (this.fsinsights) {
                modules = {
                    1: false,
                    2: false,
                    3: false
                };
                modules[mkey] = true;
            }
            return modules;
        }
    },
    methods: {
        sparkHeight() {
            this.loaded = false;
            setTimeout(() => {
                let h1 = document.getElementById("comp1")
                    ? document.getElementById("comp1").offsetHeight
                    : 0;
                let h2 = document.getElementById("insight")
                    ? document.getElementById("insight").offsetHeight
                    : 0;
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
        this.bus.$on("insights:fullscreen", fs => {
            this.fsinsights = fs.fullscreen;
            this.fsinsights_id = fs.ky;
        });
    }
};
</script>
