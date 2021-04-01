<template>
    <div>
        <pie-chart :chart-data="chartData" :options="options"></pie-chart>
    </div>
</template>

<script>
import pieChart from "./config/pieChart";
export default {
    props: ["chartData", "options"],
    components: {
        pieChart
    }
};
</script>

<style></style>
