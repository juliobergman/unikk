<template>
    <v-card :outlined="!darkTheme" flat>
        <v-card-title>Component</v-card-title>
    </v-card>
</template>

<script>
export default {
    props: ["bus"],
    components: {},
    data: () => ({}),
    computed: {
        darkTheme() {
            return this.$vuetify.theme.dark ? true : false;
        }
    },
    methods: {},
    created() {}
};
</script>

<style></style>
