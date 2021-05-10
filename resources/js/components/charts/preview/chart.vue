<template>
    <div>
        <component
            v-if="loaded"
            :bus="bus"
            :width="1024"
            :height="768"
            :is="chart.type"
            :chart-id="'chart-' + chart.id"
            :chart-data="chart.chartdata"
            :options="chart.chartoptions"
            :mode="mode"
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
        bus: {},
        chart: { type: Object, required: true },
        mode: { type: String }
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
