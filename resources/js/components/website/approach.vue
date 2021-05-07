<template>
    <v-main>
        <v-container class="main-container">
            <v-row>
                <v-col>
                    <div class="page-title">
                        Lorem Ipsum Dolor
                    </div>
                </v-col>
            </v-row>
            <v-row>
                <v-col
                    class="page-text"
                    cols="12"
                    md="6"
                    order="1"
                    order-md="0"
                >
                    <mt></mt>
                </v-col>
                <v-col cols="12" md="6" order="0" order-md="1">
                    <v-img
                        src="storage/swiss1.jpg"
                        min-height="100%"
                        class="rounded"
                    >
                    </v-img>
                </v-col>
            </v-row>
            <v-row>
                <v-col>
                    <!-- Slider Component -->
                    <slider></slider>
                </v-col>
            </v-row>
        </v-container>
    </v-main>
</template>

<script>
import mt from "../ui/mockuptext";
import slider from "./approachSlider";
export default {
    components: {
        mt,
        slider
    }
};
</script>

<style scoped>
.main-container {
    /* min-height: 100vh; */
    padding-bottom: 64px;
}
.page-title {
    font-size: 2rem;
    /* padding-bottom: 0.7rem; */
    border-bottom: 2px solid;
}
.page-text {
    font-size: 1.1rem;
}
</style>
