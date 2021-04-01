<template>
    <div>
        <v-list-item>
            <v-list-item-content>
                <v-list-item-title class="title">
                    {{ user.name }}
                </v-list-item-title>
                <v-list-item-subtitle>
                    {{ user.email }}
                </v-list-item-subtitle>
            </v-list-item-content>
        </v-list-item>

        <v-divider></v-divider>

        <v-list dense nav>
            <div v-for="item in items" :key="item.title">
                <v-list-item
                    v-if="!item.children"
                    @click="$router.push({ name: item.to })"
                    link
                >
                    <v-list-item-icon>
                        <v-icon>{{ item.icon }}</v-icon>
                    </v-list-item-icon>
                    <v-list-item-content>
                        <v-list-item-title>{{ item.title }}</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
                <!-- List -->
                <v-list-group
                    v-if="item.children"
                    no-action
                    :prepend-icon="item.icon"
                >
                    <template v-slot:activator>
                        <v-list-item-content>
                            <v-list-item-title>{{
                                item.title
                            }}</v-list-item-title>
                        </v-list-item-content>
                    </template>

                    <v-list-item
                        v-for="child in item.children"
                        :key="child.title"
                        @click="$router.push({ name: child.to })"
                        link
                    >
                        <!-- <v-list-item-icon>
                            <v-icon>{{ child.icon }}</v-icon>
                        </v-list-item-icon> -->
                        <v-list-item-content>
                            <v-list-item-title>{{
                                child.title
                            }}</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                </v-list-group>
            </div>
        </v-list>
    </div>
</template>

<script>
export default {
    props: ["user"],
    data: () => ({
        items: [
            { title: "Dashboard", icon: "mdi-view-dashboard", to: "dashboard" },
            {
                title: "Charts",
                icon: "mdi-chart-areaspline",
                children: [
                    {
                        title: "My Charts",
                        icon: "mdi-chart-areaspline-variant",
                        to: "charts"
                    },
                    {
                        title: "New Chart",
                        icon: "mdi-chart-line",
                        to: "newchart"
                    }
                ]
            },
            { title: "Contact", icon: "mdi-contacts", to: "contact" }
        ]
    })
};
</script>
