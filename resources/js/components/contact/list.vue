<template>
    <div>
        <!-- Loader -->
        <v-overlay :value="!loaded" opacity="1" color="background">
            <v-progress-circular :size="30" color="primary" indeterminate>
            </v-progress-circular>
        </v-overlay>
        <!-- Tools -->
        <v-toolbar flat rounded dense>
            <v-text-field
                solo
                flat
                background-color="transparent"
                v-model="search"
                append-icon="mdi-magnify"
                label="Search"
                single-line
                hide-details
            ></v-text-field>

            <v-tooltip bottom>
                <template v-slot:activator="{ on, attrs }">
                    <div v-bind="attrs" v-on="on">
                        <new-contact-dialog></new-contact-dialog>
                    </div>
                </template>
                <span>Add New Contact</span>
            </v-tooltip>
        </v-toolbar>
        <v-divider></v-divider>
        <!-- Table -->
        <v-card flat>
            <v-data-table
                @click:row="showContact"
                :headers="headers"
                :items="contacts"
                :items-per-page="itemsperpage"
                :search="search"
                item-key="id"
                :loading="!loaded"
                sort-by="name"
                hide-default-header
                hide-default-footer
            >
            </v-data-table>
        </v-card>
    </div>
</template>

<script>
import NewContactDialog from "./newContactDialog";
export default {
    props: ["bus"],
    components: {
        NewContactDialog
    },
    data: () => ({
        loaded: true,
        search: "",
        itemsperpage: -1,
        headers: [
            {
                text: "Name",
                value: "name",
                align: "left"
            }
        ],
        contacts: []
    }),
    methods: {
        getContacts() {
            this.loaded = false;
            axios
                .get("contact/list")
                .then(response => {
                    // this.itemsperpage = response.data.length;
                    this.contacts = response.data;
                    this.loaded = true;
                })
                .catch(response => {
                    console.error(response);
                });
        },
        showContact(contact) {
            this.$router.push({
                name: "contactProfile",
                params: { id: contact.id }
            });
        }
    },
    created() {
        this.getContacts();
    }
};
</script>

<style scoped>
.contacts .datatable thead th.column.sortable i {
    display: none;
}
</style>
