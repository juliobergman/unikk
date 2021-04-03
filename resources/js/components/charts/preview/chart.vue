<template>
    <div>
        <component
            v-if="loaded"
            :width="1024"
            :height="768"
            :is="chart.type"
            :chart-id="'chart-' + chart.id"
            :chart-data="chart.chartdata"
            :options="chart.chartoptions"
        ></component>
    </div>
</template>

<script>
import * as components from "./charts";
export default {
    components: {
        ...components
    },
    props: {
        chart: { type: Object, required: true }
    },
    data: () => ({
        loaded: true
    }),
    methods: {
        newChartData() {},
        newOptions() {}
    },
    created() {}
};
</script>
