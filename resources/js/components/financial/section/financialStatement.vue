<template>
    <v-main>
        <report-toolbar
            :bus="bus"
            :period="period"
            :lvl="lvl"
            @changePeriod="changePeriod"
            @changeLevel="changeLevel"
            @duplicateReport="addReport"
        >
        </report-toolbar>
        <v-divider></v-divider>
        <!-- <fs-top-bar :bus="bus"></fs-top-bar> -->
        <!-- <fs-table :bus="bus"></fs-table> -->
        <statement
            v-for="(item, idx) in reports"
            :key="idx"
            :index="idx"
            :period="period"
            :repdata="item"
            :lvl="lvl"
            :search="search"
            :bus="bus"
        ></statement>
    </v-main>
</template>
<script>
import reportToolbar from "../ui/reportToolbar";
import Statement from "./components/statement";
import fsTable from "./components/fsTable";
import fsTopBar from "./components/fsTopBar";
export default {
    components: {
        reportToolbar,
        Statement,
        fsTable,
        fsTopBar
    },
    props: ["bus"],
    methods: {
        defaultReport() {
            if (this.reports.lenght > 0) return;
            axios
                .post("report/show", { id: 1 })
                .then(response => {
                    if (response.status == 200) {
                        this.addReport(response.data);
                    }
                })
                .catch(response => {
                    console.error(response);
                });
        },
        addReport($payload) {
            this.reports = [...this.reports, $payload];
        },
        deleteReport($payload) {
            let arr = this.reports;
            this.reports = arr
                .slice(0, $payload)
                .concat(arr.slice($payload + 1, arr.length));
            return;
        },
        changePeriod($payload, $search) {
            this.period = $payload;
            this.search = $search;
            localStorage.setItem("fs_period", JSON.stringify($payload));
            localStorage.setItem("fs_search", $search);
            return;
        },
        changeLevel($payload) {
            this.lvl = $payload;
            localStorage.setItem("fs_lvl", JSON.stringify($payload));
            this.changePeriod(this.period, this.search);
        }
    },
    data: () => ({
        reportMenu: [],
        reports: [],
        period: {
            window: { data: "yearly", name: "By Year" },
            month: { data: "jan", name: "January" },
            quarter: { data: "qa", name: "Only Quarters" }
        },
        lvl: { data: "lvl1", name: "Level 1" },
        search: "yearly"
    }),
    created() {
        if (localStorage.fs_period) {
            this.period = JSON.parse(localStorage.getItem("fs_period"));
        }
        if (localStorage.fs_lvl) {
            this.lvl = JSON.parse(localStorage.getItem("fs_lvl"));
        }
        if (localStorage.fs_search) {
            this.search = localStorage.getItem("fs_search");
        }
        this.changePeriod(this.period, this.search);
        this.changeLevel(this.lvl);
        this.defaultReport();
    },
    mounted() {
        this.bus.$on("closeReport", this.deleteReport);
    }
};
</script>

<style>
.v-data-table__wrapper table tbody tr td {
    white-space: nowrap;
}
</style>
