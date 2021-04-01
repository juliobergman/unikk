<template>
    <div>
        <doughnut-chart
            :chart-data="chartData"
            :options="options"
        ></doughnut-chart>
    </div>
</template>

<script>
import DoughnutChart from "./config/doughnutChart";
export default {
    props: ["chartData", "options"],
    components: {
        DoughnutChart
    }
};
</script>

<style></style>
