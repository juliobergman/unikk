<template>
    <v-main>
        <fs-toolbar :bus="bus" :report="report" :period="period"> </fs-toolbar>
        <v-divider v-show="!darkTheme"></v-divider>
        <v-slide-y-transition>
            <fs-top-bar
                v-show="report.type != 'ratio'"
                :bus="bus"
                :period="period"
                :lvl="lvl"
            ></fs-top-bar>
        </v-slide-y-transition>
        <v-divider v-show="!darkTheme && report.type != 'ratio'"></v-divider>
        <fs-table
            style="overflow:hidden; !important"
            v-if="report"
            :bus="bus"
            :rid="report.id"
            :report="report"
            :lvl="lvl"
            :period="period"
            :search="search"
        ></fs-table>
    </v-main>
</template>
<script>
import fsTopBar from "./components/fsTopBar";
import fsToolbar from "./components/fsToolbar";
import fsTable from "./components/fsTable";
export default {
    components: {
        fsTopBar,
        fsToolbar,
        fsTable
    },
    props: ["bus"],
    data: () => ({
        reportMenu: [],
        report: {},
        period: {
            window: { data: "yearly", name: "By Year" },
            month: { data: "jan", name: "January" },
            quarter: { data: "qa", name: "Only Quarters" },
            year: new Date().getFullYear()
        },
        lvl: { data: "lvl1", name: "Level 1" },
        search: "yearly"
    }),
    computed: {
        darkTheme() {
            return this.$vuetify.theme.dark ? true : false;
        }
    },
    methods: {
        updateReport(data) {
            this.report = data;
            localStorage.setItem("fs_report", JSON.stringify(data));
        },
        defaultReport() {
            if (!_.isEmpty(this.report)) return;
            axios
                .post("report/show", { id: 1 })
                .then(response => {
                    if (response.status == 200) {
                        this.report = response.data;
                        localStorage.setItem(
                            "fs_report",
                            JSON.stringify(response.data)
                        );
                    }
                })
                .catch(response => {
                    console.error(response);
                });
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
        },
        changeYear($payload) {
            this.period.year = $payload;
            localStorage.setItem("fs_period", JSON.stringify(this.period));
        }
    },
    created() {
        if (localStorage.fs_report) {
            this.report = JSON.parse(localStorage.getItem("fs_report"));
        }
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
        this.bus.$on("report:update", this.updateReport);
        this.bus.$on("year:change", this.changeYear);
        this.bus.$on("period:change", this.changePeriod);
        this.bus.$on("level:change", this.changeLevel);
    }
};
</script>

<style>
.v-data-table__wrapper table tbody tr td {
    white-space: nowrap;
}
</style>
