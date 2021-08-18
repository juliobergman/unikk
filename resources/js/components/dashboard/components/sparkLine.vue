<template>
    <v-card flat>
        <v-card-text class="subtitle-2" v-text="name"></v-card-text>
        <v-card-text>
            <v-sparkline
                height="75"
                :value="value"
                :labels="labels"
                :gradient="gradient"
                :smooth="radius || false"
                :padding="padding"
                :line-width="width"
                :stroke-linecap="lineCap"
                :gradient-direction="gradientDirection"
                :fill="fill"
                :type="type"
                :auto-line-width="autoLineWidth"
                auto-draw
                :auto-draw-duration="4000"
            ></v-sparkline>
        </v-card-text>
    </v-card>
</template>

<script>
export default {
    props: ["bus", "name", "value", "labels", "darkTheme"],
    data: () => ({
        width: 4,
        radius: 5,
        padding: 24,
        lineCap: "round",
        gradient: ["#5895ff", "#58ffb1"],
        gradientDirection: "top",
        fill: false,
        type: "trend",
        autoLineWidth: true
    })
};
</script>

<style scoped>
.subtitle-2 {
    font-size: 1.05rem !important;
    font-weight: 500 !important;
    padding-top: 0.3rem;
    padding-bottom: 0.3rem;
    margin-bottom: 0.5rem;
}
</style>
