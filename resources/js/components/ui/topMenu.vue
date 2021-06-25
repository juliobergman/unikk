<template>
    <div class="text-center">
        <v-menu offset-y>
            <template v-slot:activator="{ on, attrs }">
                <v-btn icon small v-bind="attrs" v-on="on">
                    <v-icon>
                        mdi-cog
                    </v-icon>
                </v-btn>
            </template>
            <top-menu-content :bus="bus"></top-menu-content>
        </v-menu>
    </div>
</template>

<script>
import topMenuContent from "./topMenuContent.vue";
export default {
    props: ["bus"],
    components: { topMenuContent }
};
</script>

<style></style>
