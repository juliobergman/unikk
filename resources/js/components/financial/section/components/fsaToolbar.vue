<template>
    <v-toolbar flat dense class="v-toolbar__no_pad mb-2 sticky">
        <v-btn
            small
            text
            height="48"
            width="30"
            tile
            color="primary"
            to="/financial/statement"
        >
            <v-icon>
                mdi-chevron-left
            </v-icon>
        </v-btn>
        <v-menu offset-y>
            <template v-slot:activator="{ on, attrs }">
                <v-btn
                    text
                    tile
                    height="48"
                    color="primary"
                    v-bind="attrs"
                    v-on="on"
                >
                    {{ report.name }}
                </v-btn>
            </template>

            <v-list>
                <v-list-item-group
                    v-model="report"
                    color="primary"
                    mandatory
                    @change="bus.$emit('setReport', report)"
                >
                    <v-list-item
                        v-for="(item, i) in reports"
                        :key="i"
                        :value="item"
                    >
                        <v-list-item-content>
                            <v-list-item-title
                                v-text="item.name"
                            ></v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                </v-list-item-group>
            </v-list>
        </v-menu>
        <v-spacer></v-spacer>
        <v-btn
            small
            text
            height="48"
            width="30"
            tile
            color="primary"
            @click="bus.$emit('saveFacts')"
        >
            <v-icon>
                mdi-content-save
            </v-icon>
        </v-btn>
        <!-- Year Menu -->
        <v-menu offset-y>
            <template v-slot:activator="{ on, attrs }">
                <v-btn
                    text
                    tile
                    height="48"
                    color="primary"
                    v-bind="attrs"
                    v-on="on"
                >
                    {{ moment(date).format("MMM, YYYY") }}
                </v-btn>
            </template>

            <v-date-picker
                v-model="date"
                min="2020-01-01"
                max="2030-12-31"
                type="month"
                @change="bus.$emit('setDate', date)"
            ></v-date-picker>
        </v-menu>
    </v-toolbar>
</template>

<script>
import axios from "axios";
export default {
    props: ["bus"],
    data: () => ({
        toolbarElevation: 0,
        date: new Date().toISOString().slice(0, 10),
        report: [],
        reports: []
    }),
    methods: {
        handleScroll(event) {
            // let ret = window.scrollY > 0 ? 0 : 0;
            // this.toolbarElevation = ret;
        },
        getReports() {
            axios
                .post("report/all", { not: "ratio" })
                .then(response => {
                    this.reports = response.data;
                    this.report = this.reports[0];
                    this.bus.$emit("setReport", this.report);
                })
                .catch(response => {
                    console.error(response);
                });
        }
    },
    created() {
        window.addEventListener("scroll", this.handleScroll);
        this.getReports();
    },
    destroyed() {
        window.removeEventListener("scroll", this.handleScroll);
    }
};
</script>

<style scoped>
.sticky {
    position: -webkit-sticky !important;
    position: sticky !important;
    top: 64px !important;
    z-index: 4 !important;
}
.v-toolbar__no_pad .v-toolbar__content {
    padding-left: 0 !important;
    padding-right: 0 !important;
}
</style>
