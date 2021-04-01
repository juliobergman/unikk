<template>
    <div>
        <bar-chart
            :width="640"
            :height="440"
            :chart-data="chartData"
            :options="options"
        ></bar-chart>
    </div>
</template>

<script>
import BarChart from "./config/barChart";
export default {
    props: ["chartData", "options"],
    components: {
        BarChart
    }
};
</script>

<style></style>
