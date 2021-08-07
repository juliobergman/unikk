<template>
    <fs-table
        v-if="false"
        :bus="bus"
        :search="search"
        :rid="report.id"
        :report="report"
        :lvl="lvl"
        :period="period"
    ></fs-table>
</template>

<script>
import fsToolbar from "./fsToolbar";
import fsTable from "./fsTable";
export default {
    props: ["bus", "period", "search", "lvl", "report", "index"],
    components: {
        fsToolbar,
        fsTable
    },
    data: () => ({}),
    methods: {},
    created() {}
};
</script>

<style></style>
