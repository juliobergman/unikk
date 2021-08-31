<template>
    <v-container fluid class="pa-0">
        <v-row>
            <v-col
                v-for="item in items"
                :key="item.title"
                cols="6"
                :md="item.colmd"
            >
                <v-card dark flat tile>
                    <v-img
                        :aspect-ratio="10 / 7"
                        :src="'storage/web/investment/' + item.img"
                    >
                        <v-container
                            fill-height
                            fluid
                            class="pa-0 d-flex align-content-end"
                        >
                            <v-container
                                class="
                  title-container
                  text-caption text-md-body-1
                  pa-1
                  font-weight-medium
                  text-center
                "
                            >
                                {{ $t(item.title) }}
                            </v-container>
                        </v-container>
                    </v-img>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
export default {
    data: () => ({
        items: [
            {
                img: "stock-and-bonds.jpg",
                title: "investment-slide-1",
                colmd: "6"
            },
            {
                img: "early-stage-investments.jpg",
                title: "investment-slide-2",
                colmd: "6"
            },
            {
                img: "investment-private-equity.jpg",
                title: "investment-slide-3",
                colmd: "4"
            },
            {
                img: "crypto.jpg",
                title: "investment-slide-4",
                colmd: "4"
            },
            {
                img: "direct-investment.jpg",
                title: "investment-slide-5",
                colmd: "4"
            }
        ]
    }),
    methods: {
        img(image) {
            return images[image];
        }
    }
};
</script>

<style scoped>
.title-container {
    background: rgba(0, 0, 0, 0.5);
}
</style>
