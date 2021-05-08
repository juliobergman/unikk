import Vue from "vue";
import VueRouter from "vue-router";

Vue.use(VueRouter);

// Website
// import wsMain from "../components/website/main";
// Admin
import Dashboard from "../components/dashboard/container";
import Users from "../components/user/container";
import Contact from "../components/contact/container";
// Charts Retrieve
import Charts from "../components/charts/container";
import chartList from "../components/charts/views/list";
import chartCollection from "../components/charts/views/collection";
import chartView from "../components/charts/views/view";
// Charts Build
import newChart from "../components/charts/new/container";
import newBarChart from "../components/charts/new/bar";
import newLineChart from "../components/charts/new/line";
import newPieChart from "../components/charts/new/pie";

const routes = [
    {
        component: Users,
        name: "users",
        path: "/users"
    },
    {
        component: Dashboard,
        name: "dashboard",
        path: "/dashboard"
    },
    {
        component: Charts,
        path: "/charts",
        children: [
            {
                component: chartList,
                name: "charts",
                path: ""
            },
            {
                component: chartCollection,
                name: "chartCollection",
                path: "collection/:id"
            },
            {
                component: chartView,
                name: "chartView",
                path: "collection/view/:id"
            }
        ]
    },
    {
        component: newChart,
        name: "newchart",
        path: "/chart-build",
        children: [
            {
                component: newBarChart,
                name: "newbarchart",
                path: "bar",
                children: [
                    {
                        component: newBarChart,
                        name: "barChartUpdate",
                        path: ":id"
                    }
                ]
            },
            {
                component: newLineChart,
                name: "newlinechart",
                path: "line",
                children: [
                    {
                        component: newLineChart,
                        name: "lineChartUpdate",
                        path: ":id"
                    }
                ]
            },
            {
                component: newPieChart,
                name: "newpiechart",
                path: "pie",
                children: [
                    {
                        component: newPieChart,
                        name: "pieChartUpdate",
                        path: ":id"
                    }
                ]
            }
        ]
    },
    {
        component: Contact,
        name: "contact",
        path: "/contact"
    }
];

export default new VueRouter({
    routes // Short for routes: routes
});
