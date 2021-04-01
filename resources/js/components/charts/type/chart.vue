<template>
    <component
        :width="640"
        :height="440"
        :is="type"
        :chart-data="chartData"
        :options="options"
        :bus="bus"
    ></component>
</template>

<script>
import * as components from "./charts";
export default {
    components: {
        ...components
    },
    props: {
        bus: {},
        chartData: { type: Object, required: true },
        options: { type: Object, required: false },
        type: { type: String, required: true }
    }
};
</script>
