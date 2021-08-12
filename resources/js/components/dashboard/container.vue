<template>
    <v-main>
        <v-container fluid>
            <v-row>
                <v-col cols="12" md="9">
                    <v-row>
                        <v-col cols="12" md="4">
                            <insights style="height: 180px;"></insights>
                        </v-col>
                        <v-col cols="12" md="4">
                            <insights style="height: 180px;"></insights>
                        </v-col>
                        <v-col cols="12" md="4">
                            <insights style="height: 180px;"></insights>
                        </v-col>
                        <v-col cols="12">
                            <insights style="height: 650px;"></insights>
                        </v-col>
                    </v-row>
                </v-col>
                <v-col cols="12" md="3">
                    <insights style="height: 100%;"></insights>
                </v-col>
            </v-row>
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
