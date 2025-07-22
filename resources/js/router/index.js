import { createRouter, createWebHistory } from "vue-router";

import MainLayout from "../layouts/MainLayout.vue";
import Home from "../pages/Home.vue";
import FreelancerDetail from "../pages/FreelancerDetail.vue";
import RekrutForm from "../pages/RekrutForm.vue";


const routes = [
    {
        path: "/",
        component: MainLayout,
        children: [
            {
                path: "",
                name: "home",
                component: Home,
            },
            {
                path: "/freelancers/:id",
                name: "freelancer.detail",
                component: FreelancerDetail,
            },
            {
                path: "/rekrut",
                name: "rekrut",
                component: RekrutForm,
            },
        ],
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
