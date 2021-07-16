<template>
    <v-card flat class="mt-3 mb-5">
        <fs-toolbar
            :bus="bus"
            :year="year"
            @changeYear="changeYear"
            @changeReport="changeReport"
        >
        </fs-toolbar>
        <v-divider></v-divider>
        <fs-table
            :bus="bus"
            :rid="report.id"
            :report="report"
            :year="year"
            :period="period"
            :month="month"
            :quarter="quarter"
            :lvl="lvl"
            :search="search"
        ></fs-table>
    </v-card>
</template>

<script>
import reportInformation from "./repInfo";
import fsToolbar from "./fsToolbar";
import fsTable from "./fsTable";
export default {
    props: ["bus", "period", "month", "quarter", "lvl", "search"],
    components: {
        reportInformation,
        fsToolbar,
        fsTable
    },
    data: () => ({
        year: new Date().getFullYear(),
        report: []
    }),
    methods: {
        changeYear($payload) {
            this.year = $payload;
        },
        changeReport($payload) {
            this.report = $payload;
        }
    },
    created() {}
};
</script>

<style></style>
