<template>
    <v-main>
        <v-container fluid>
            <v-row>
                <v-col cols="12" md="7">
                    <v-row>
                        <v-col cols="12" md="6">
                            <c-place
                                :bus="bus"
                                style="height: 100px;"
                            ></c-place>
                        </v-col>
                        <v-col cols="12" md="6">
                            <c-place
                                :bus="bus"
                                style="height: 100px;"
                            ></c-place>
                        </v-col>
                        <v-col cols="12">
                            <insights :bus="bus"></insights>
                        </v-col>
                    </v-row>
                </v-col>
                <v-col cols="12" md="5">
                    <c-place :bus="bus" class="fill-height"></c-place>
                </v-col>
            </v-row>
        </v-container>
    </v-main>
</template>

<script>
import CPlace from "./components/cplace";
import Insights from "./components/insights";
export default {
    props: ["bus"],
    components: { CPlace, Insights },
    data: () => ({
        loaded: true
    }),
    computed: {},
    methods: {},
    created() {}
};
</script>
