<template>
    <v-main id="container">
        <v-container fluid class="align-stretch fill-height pa-0 cont">
            <v-row no-gutters class="fill-height">
                <!-- v-if="$isMobile()" -->
                <v-col
                    order="2"
                    order-md="2"
                    cols="12"
                    md="9"
                    class="px-6 py-12 px-md-16 pt-md-3 mt-md-10"
                >
                    <!-- <div
            class="
              zcontainer
              d-none d-md-inline
              text-h4 text-md-h2
              primary
              py-16
              px-16
              white--text
            "
          >
            {{ $t("investment") }}
          </div> -->
                    <div class="text-h4 text-md-h2 primary--text mb-9 mb-md-16">
                        {{ $t("investment") }}
                    </div>
                    <div
                        class="first-text text-body-1 text-md-h5 mb-7 mb-md-14"
                    >
                        {{ $t("investment-1") }}
                    </div>
                    <div class="mb-7 mb-md-14">
                        <slide />
                    </div>
                </v-col>
                <v-col order="0" order-md="0" cols="12" md="3">
                    <v-img
                        height="100%"
                        max-width="100vw"
                        src="storage/web/investment.jpg"
                    ></v-img>
                </v-col>
            </v-row>
        </v-container>
    </v-main>
</template>

<script>
import Slide from "./components/investmentSlide.vue";
export default {
    components: { Slide },
    data: () => ({}),
    methods: {},
    created() {},
    mounted() {}
};
</script>

<style scoped>
.zcontainer {
    z-index: 5;
    position: absolute;
    left: 0;
    width: 100vw;
}
.slider {
    position: absolute;
    margin: auto;
    left: 0;
    z-index: 2;
    width: 100vw;
}
@media (min-width: 960px) {
    .first-text {
        margin-top: 0px;
    }
}
</style>
