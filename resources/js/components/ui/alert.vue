<template>
    <v-dialog
        v-model="dialog"
        :max-width="options.width"
        :style="{ zIndex: options.zIndex }"
        @keydown.esc="cancel"
    >
        <v-card>
            <v-toolbar dense flat>
                <v-toolbar-title :class="options.color + '--text'">{{
                    title
                }}</v-toolbar-title>
            </v-toolbar>
            <v-card-text v-show="!!message" class="pa-4">{{
                message
            }}</v-card-text>
            <v-card-actions class="pt-0">
                <v-spacer></v-spacer>
                <v-btn :color="options.color" text @click.native="accept"
                    >Ok</v-btn
                >
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
export default {
    data: () => ({
        dialog: false,
        resolve: null,
        reject: null,
        message: null,
        title: null,
        options: {
            color: "primary",
            width: 290,
            zIndex: 200
        }
    }),
    methods: {
        open(title, message, options) {
            this.dialog = true;
            this.title = title;
            this.message = message;
            this.options = Object.assign(this.options, options);
            return new Promise(resolve => {
                this.resolve = resolve;
            });
        },
        accept() {
            this.resolve(true);
            this.dialog = false;
        }
    }
};
</script>
