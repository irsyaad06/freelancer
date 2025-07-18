import { createRouter, createWebHistory } from 'vue-router'

import MainLayout from '../layouts/MainLayout.vue'
import Home from '../pages/Home.vue'
import FreelancerList from '../pages/FreelancerList.vue'
import FreelancerDetail from '../pages/FreelancerDetail.vue'
import ServiceList from '../pages/ServiceList.vue'
import ServiceDetail from '../pages/ServiceDetail.vue'

const routes = [
  {
    path: '/',
    component: MainLayout,
    children: [
      {
        path: '',
        name: 'home',
        component: Home
      },
      {
        path: '/freelancers',
        name: 'freelancers',
        component: FreelancerList
      },
      {
        path: '/freelancers/:id',
        name: 'freelancer.detail',
        component: FreelancerDetail
      },
      {
        path: '/services',
        name: 'services',
        component: ServiceList
      },
      {
        path: '/services/:id',
        name: 'service.detail',
        component: ServiceDetail
      }
    ]
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

export default router
