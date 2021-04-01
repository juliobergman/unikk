<template>
    <v-container fluid style="background: #C0C6CF;">
        <v-row>
            <v-col>
                <v-checkbox
                    v-model="options.title.display"
                    label="Display Title"
                    color="red"
                    hide-details
                    @change="updateChart()"
                ></v-checkbox>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
export default {
    data: () => ({
        options: {
            responsive: true,
            maintainAspectRatio: false,
            title: {
                display: true,
                text: "Chart Title",
                fontSize: 20
            },
            legend: {
                display: true,
                position: "bottom"
            },
            scales: {
                xAxes: [
                    {
                        stacked: false
                    }
                ],
                yAxes: [
                    {
                        stacked: false,
                        ticks: {
                            suggestedMin: 0,
                            suggestedMax: null
                        }
                    }
                ]
            }
        }
    }),
    methods: {
        updateChart() {}
    },
    created() {
        this.$emit("itemchanged", this.options);
    }
};
</script>

<style></style>
