<template>
    <v-sheet class="d-flex">
        <v-card v-for="(report, idx) in reports" :key="idx" class="mx-auto">
            <v-card-title v-text="report.title"></v-card-title>
            <v-card-text v-text="report.description"></v-card-text>
            <v-card-actions>
                <v-btn :to="report.to" color="primary" icon class="ml-auto">
                    <v-icon>
                        mdi-chevron-right-circle
                    </v-icon>
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-sheet>
</template>

<script>
export default {
    props: ["bus"],
    components: {},
    data: () => ({
        reports: [
            {
                title: "Income Statements",
                description: "Lorem Ipsum Dolor sit Amet",
                to: "/financial/statement"
            },
            {
                title: "Balance Sheet",
                description: "Lorem Ipsum Dolor sit Amet",
                to: "/financial/statement"
            },
            {
                title: "Financial Ratio",
                description: "Lorem Ipsum Dolor sit Amet",
                to: "/financial/statement"
            }
        ]
    }),
    methods: {},
    created() {}
};
</script>

<style></style>
