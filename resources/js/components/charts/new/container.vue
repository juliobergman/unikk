<template>
    <v-main>
        <v-toolbar elevation="2" dense>
            <v-btn-toggle mandatory tile group v-model="currentRoute">
                <v-tooltip bottom v-for="item in chartMenu" :key="item.title">
                    <template v-slot:activator="{ on, attrs }">
                        <v-btn
                            :value="item.to"
                            @click="$router.push({ name: item.to })"
                            v-bind="attrs"
                            v-on="on"
                        >
                            <v-icon>{{ item.icon }}</v-icon>
                        </v-btn>
                    </template>
                    <span>{{ item.title }}</span>
                </v-tooltip>
            </v-btn-toggle>
            <!-- Left Side Finish -->
            <v-spacer></v-spacer>
            <!-- Right Side Start -->
            <v-btn @click="addDataSet()" text color="grey darken-3">
                Add Data Set
            </v-btn>
            <v-btn @click="saveChart()" text color="grey darken-3">
                SAVE
                <v-icon class="ml-2">mdi-content-save</v-icon>
            </v-btn>
        </v-toolbar>
        <router-view
            :bus="bus"
            v-on:savechart.capture="storeChart($event)"
        ></router-view>
    </v-main>
</template>

<script>
export default {
    props: [],
    data: () => ({
        bus: new Vue(),
        currentRoute: null,
        chartMenu: [
            {
                title: "New Bar Chart",
                icon: "mdi-chart-bar",
                to: "newbarchart"
            },
            {
                title: "New Line Chart",
                icon: "mdi-chart-areaspline-variant",
                to: "newlinechart"
            },
            {
                title: "New Pie Chart",
                icon: "mdi-chart-pie",
                to: "newpiechart"
            },
            {
                title: "New Donut Chart",
                icon: "mdi-chart-donut",
                to: "newdonutchart"
            }
        ]
    }),
    methods: {
        storeChart(data) {
            if (!data.type) {
                return;
            }

            axios
                .post("api/v1/chart/store", data)
                .then(response => {
                    // console.log(response.data);
                })
                .catch(error => {
                    console.log(error);
                });
        },
        addDataSet() {
            this.bus.$emit("addDataSet");
        },
        saveChart() {
            this.bus.$emit("saveChart");
        },
        updateChart() {
            this.bus.$emit("updateChart");
        },
        updateOptions() {
            this.bus.$emit("updateOptions");
        }
    },
    computed: {
        currentRouteName() {
            return this.$route.name;
        }
    },
    created() {
        if (this.$route.name == "newchart") {
            this.$router.push({ name: "newbarchart" });
        }
        this.currentRoute = this.$route.name;
    }
};
</script>

<style></style>
