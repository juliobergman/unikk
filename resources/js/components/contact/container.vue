<template>
    <v-main>
        <list :bus="bus"></list>
    </v-main>
</template>

<script>
import List from "./list";
export default {
    props: ["bus"],
    components: {
        List
    },
    data: () => ({})
};
</script>

<style></style>
