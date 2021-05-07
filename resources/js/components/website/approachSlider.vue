<template>
    <v-card color="grey lighten-4" class="mt-4" elevation="1">
        <v-slide-group center-active>
            <v-slide-item
                v-for="(item, idx) in slider"
                :key="idx"
                v-slot="{ active, toggle }"
            >
                <v-card class="ma-4" width="300" @click="toggle">
                    <v-img height="150" :src="item.img"> </v-img>
                    <v-card-title>{{ item.title }}</v-card-title>
                    <v-card-subtitle>{{ item.text }}</v-card-subtitle>
                    <v-card-actions class="slider-card-action mt-3">
                        <v-btn color="primary">
                            Learn More
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-slide-item>
        </v-slide-group>
    </v-card>
</template>

<script>
export default {
    data: () => ({
        slider: [
            {
                title: "Global Capital Markets",
                text:
                    "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc luctus magna eu luctus commodo. Duis vitae velit sodales, semper nunc sit amet",
                img: "storage/financial_1.jpg"
            },
            {
                title: "Fundraising",
                text:
                    "mattis est. Fusce ut elit dolor. Praesent egestas, velit non eleifend facilisis, felis augue commodo est, sed imperdiet nulla nibh posuere mauris.",
                img: "storage/financial_2.jpg"
            },
            {
                title: "Corporate Finance",
                text:
                    "Nam tincidunt sollicitudin metus, pellentesque cursus nunc porttitor vel. Donec nibh nunc, venenatis id ligula a, auctor pulvinar nulla. Vivamus luctus arcu quis pretium laoreet. ",
                img: "storage/financial_3.jpg"
            },
            {
                title: "Credit Enhacing",
                text:
                    "Morbi in purus sit amet elit dapibus cursus eu eu dui. Curabitur dignissim facilisis diam vel condimentum. Donec vel massa in sapien aliquam rhoncus. Vestibulum at eros vitae libero aliquet lacinia.",
                img: "storage/financial_4.jpg"
            },
            {
                title: "Account Services",
                text:
                    "Proin porta luctus justo, in feugiat ligula consectetur sit amet. Nullam non hendrerit lorem. Donec vulputate dui ex, sit amet molestie metus iaculis ut. Quisque at scelerisque tortor.",
                img: "storage/financial_5.jpg"
            },
            {
                title: "Global Capital Markets",
                text:
                    "Curabitur sed dapibus leo, ac sollicitudin sem. Nam lobortis massa id fermentum condimentum. Cras blandit turpis vitae urna venenatis dapibus. Ut a diam dui. Fusce ut lobortis diam.",
                img: "storage/financial_6.jpg"
            }
        ]
    })
};
</script>

<style scoped>
.slider-card-action {
    position: absolute;
    bottom: 0;
    right: 0;
}
</style>
