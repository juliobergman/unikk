<template>
    <component
        :width="width"
        :height="height"
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
        width: { type: Number, default: 1024 },
        height: { type: Number, default: 768 },
        chartData: { type: Object, required: true },
        options: { type: Object, required: false },
        type: { type: String, required: true }
    }
};
</script>
