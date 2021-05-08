<template>
    <v-card color="background">
        <v-toolbar dense rounded="0">
            <v-btn-toggle group mandatory v-model="currentRoute">
                <v-tooltip bottom v-for="item in chartMenu" :key="item.title">
                    <template v-slot:activator="{ on, attrs }">
                        <v-btn :value="item.to" v-bind="attrs" v-on="on">
                            <v-icon> {{ item.icon }}</v-icon>
                        </v-btn>
                    </template>
                    <span>{{ item.title }}</span>
                </v-tooltip>
            </v-btn-toggle>
            <!-- Left Side Finish -->
            <v-spacer></v-spacer>
            <!-- Right Side Start -->
            <v-btn-toggle group>
                <v-tooltip bottom v-for="(item, idx) in toolsMenu" :key="idx">
                    <template v-slot:activator="{ on, attrs }">
                        <v-btn @click="item.action" v-bind="attrs" v-on="on">
                            <v-icon> {{ item.icon }} </v-icon>
                        </v-btn>
                    </template>
                    <span>{{ item.tooltip }}</span>
                </v-tooltip>
            </v-btn-toggle>
        </v-toolbar>
    </v-card>
</template>

<script>
export default {
    props: ["bus"],
    data: () => ({
        currentRoute: null,
        toolsMenu: [
            {
                tooltip: "Add New Data Set",
                icon: "mdi-chart-box-plus-outline",
                action: "addDataSet"
            },
            {
                tooltip: "Save Chart",
                icon: "mdi-content-save",
                action: "saveChart"
            },
            {
                tooltip: "Close",
                icon: "mdi-close",
                action: "closeDialog"
            }
        ],
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
            }
        ]
    }),
    methods: {
        storeChart(data) {
            if (!this.$route.params.id) {
                axios
                    .post("chart/store", data)
                    .then(response => {})
                    .catch(error => {
                        console.log(error);
                    });
            }

            if (this.$route.params.id) {
                axios
                    .put("chart/" + this.$route.params.id, data)
                    .then(response => {})
                    .catch(error => {
                        console.log(error);
                    });
            }
        },
        addDataSet() {
            this.bus.$emit("addDataSet");
        },
        saveChart() {
            this.bus.$emit("saveChart");
        },
        saveUpdatedChart() {
            this.bus.$emit("saveUpdatedChart");
        },
        updateChart() {
            this.bus.$emit("updateChart");
        },
        updateOptions() {
            this.bus.$emit("updateOptions");
        },
        closeDialog() {
            this.bus.$emit("closeDialog");
        }
    },
    mounted() {
        // if (this.$route.name === "newchart") {
        //     this.$router.push({ name: "newbarchart" });
        // }
        this.currentRoute = this.$route.name;
    }
};
</script>

<style scoped></style>
