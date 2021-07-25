<template>
    <v-main>
        <report-toolbar
            :bus="bus"
            :period="period"
            :lvl="lvl"
            @changePeriod="changePeriod"
            @changeLevel="changeLevel"
        >
        </report-toolbar>
        <v-divider></v-divider>
        <!-- <fs-top-bar :bus="bus"></fs-top-bar> -->
        <!-- <fs-table :bus="bus"></fs-table> -->
        <statement
            v-for="idx in 1"
            :key="idx"
            :period="period"
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
    }
};
</script>

<style>
.v-data-table__wrapper table tbody tr td {
    white-space: nowrap;
}
</style>
