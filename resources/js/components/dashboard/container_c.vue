<template>
    <v-main>
        <v-container fluid>
            <insights :bus="bus"></insights>
        </v-container>
    </v-main>
</template>

<script>
import Insights from "./components/insights";
export default {
    props: ["bus"],
    components: { Insights },
    data: () => ({
        loaded: true
    }),
    computed: {},
    methods: {},
    created() {}
};
</script>
