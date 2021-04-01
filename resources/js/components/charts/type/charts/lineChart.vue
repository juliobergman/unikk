<template>
    <div>
        <line-chart
            :width="640"
            :height="440"
            :chart-data="chartData"
            :options="options"
        ></line-chart>
    </div>
</template>

<script>
import lineChart from "./config/lineChart";
export default {
    props: ["chartData", "options"],
    components: {
        lineChart
    }
};
</script>

<style></style>
