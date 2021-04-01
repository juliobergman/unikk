<template>
    <component v-on:itemchanged="getOptions" :is="type"></component>
</template>

<script>
import * as components from "./chart";
export default {
    components: {
        ...components
    },
    props: {
        //options: { type: Object, required: true },
        type: { type: String, required: true }
    },
    methods: {
        getOptions(options) {
            this.$emit("reloadchart", options);
        }
    }
};
</script>
