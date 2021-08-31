import Vue from "vue";
import VueRouter from "vue-router";

Vue.use(VueRouter);

// Website
import WebWelcome from "../components/website/components/pages/welcome.vue";
import WebAbout from "../components/website/components/pages/about.vue";
import WebInvestment from "../components/website/components/pages/investment.vue";
import WebGeofocus from "../components/website/components/pages/geofocus.vue";
import WebEarth from "../components/website/components/pages/geofocus2.vue";
import WebContact from "../components/website/components/pages/contact.vue";

// Admin
import Dashboard from "../components/dashboard/container";
// User
import Users from "../components/user/container";
import Account from "../components/user/accountContainer.vue";
import Company from "../components/company/container";
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
//Contacts
import Contact from "../components/contact/container";
import ContactProfile from "../components/contact/contactProfile";
//Peccs
import Pecc from "../components/pecc/container";
import PeccProfile from "../components/pecc/peccProfile";
//Target
import Target from "../components/target/container";
import TargetProfile from "../components/target/targetProfile";
// Reporting
import Financial from "../components/financial/container";
import FinancialStatementAdd from "../components/financial/section/financialStatementAdd";
import FinancialStatement from "../components/financial/section/financialStatement";

const routes = [
    // Web
    {
        component: WebWelcome,
        name: "webwelcome",
        path: "/",
        meta: {
            depth: "0",
            darkLogo: true,
            darkBtn: true,
            darkNavs: true
        }
    },
    {
        component: WebAbout,
        name: "webabout",
        path: "/about",
        meta: {
            depth: "1",
            darkLogo: false,
            darkBtn: true,
            darkNavs: false
        }
    },
    {
        component: WebInvestment,
        name: "webinvestment",
        path: "/investment",
        meta: {
            depth: "2",
            darkLogo: true,
            darkBtn: false,
            darkNavs: false
        }
    },
    {
        component: WebGeofocus,
        name: "webgeofocus",
        path: "/geofocus",
        meta: {
            depth: "3",
            darkLogo: true,
            darkBtn: true,
            darkNavs: true
        }
    },
    {
        component: WebEarth,
        name: "webearth",
        path: "/earth",
        meta: {
            depth: "4",
            darkLogo: true,
            darkBtn: true,
            darkNavs: true
        }
    },
    {
        component: WebContact,
        name: "webcontact",
        path: "/contact",
        meta: {
            depth: "5",
            darkLogo: false,
            darkBtn: false,
            darkNavs: false
        }
    },
    // App
    {
        component: Dashboard,
        name: "dashboard",
        path: "/app",
        meta: { section: "dashboard" }
    },
    {
        component: Company,
        name: "company",
        path: "/app/company",
        meta: { section: "company" }
    },
    {
        component: Account,
        name: "account",
        path: "/app/account",
        meta: { section: "account" }
    },
    {
        component: Users,
        name: "users",
        path: "/app/users",
        meta: { section: "users" }
    },
    {
        component: Charts,
        path: "/app/charts",
        meta: { section: "charts" },
        children: [
            {
                component: chartList,
                name: "charts",
                path: "",
                meta: { section: "charts" }
            },
            {
                component: chartCollection,
                name: "chartCollection",
                path: "collection/:collection",
                meta: { section: "charts" }
            },
            {
                component: chartView,
                name: "chartView",
                path: "collection/:collection/:id",
                meta: { section: "charts" }
            }
        ]
    },
    {
        component: newChart,
        name: "newchart",
        path: "/app/chart-build",
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
        path: "/app/contact",
        meta: { section: "contact" }
    },
    {
        component: ContactProfile,
        name: "contactProfile",
        path: "/app/contact/:id",
        meta: { section: "contact" }
    },
    {
        component: Pecc,
        name: "pecc",
        path: "/app/pecc",
        meta: { section: "pecc" }
    },
    {
        component: PeccProfile,
        name: "peccProfile",
        path: "/app/pecc/:id/:ref?",
        meta: { section: "pecc" }
    },
    {
        component: Target,
        name: "target",
        path: "/app/target",
        meta: { section: "target" }
    },
    {
        component: TargetProfile,
        name: "targetProfile",
        path: "/app/target/:id/:ref?",
        meta: { section: "target" }
    },
    {
        component: Financial,
        name: "financial",
        path: "/app/financial",
        meta: { section: "financial" }
    },
    {
        component: FinancialStatement,
        name: "financialStatement",
        path: "/app/financial/statement",
        meta: { section: "financial" }
    },
    {
        component: FinancialStatementAdd,
        name: "financialStatementAdd",
        path: "/app/financial/statement/add",
        meta: { section: "financial" }
    }
];

export default new VueRouter({
    mode: "history",
    routes
});
