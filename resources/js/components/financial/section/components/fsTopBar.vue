<template>
    <v-card flat class="mb-2 border-bottom">
        <v-card-text v-text="title" class="title primary--text pb-0">
        </v-card-text>
        <v-card-text v-text="subtitle" class="subtitle-1 primary--text pt-0">
        </v-card-text>
        <v-card-text v-text="info" class="subtitle-2 primary--text pt-0">
        </v-card-text>
    </v-card>
</template>

<script>
export default {
    props: ["bus"],
    data: () => ({
        title: "Financial Title",
        subtitle: "Financial Subtitle",
        info: "Lorem Ipsum Dolor sit amet consecteur"
    }),
    methods: {},
    created() {}
};
</script>

<style></style>
