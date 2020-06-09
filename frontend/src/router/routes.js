import Home from '../pages/Index.vue'
import Admin from '../pages/Admin.vue'
import Products from '../components/Products.vue'
import Product from '../pages/Product.vue'
import Companies from '../components/Companies.vue'
import Company from '../pages/Company.vue'
import Contact from '../pages/Contact.vue'
import Login from '../pages/Login.vue'


import Calendar from '../pages/TimeEntries/Calendar.vue'

const routes = [
  {
    path: '/',
    component: () => import('layouts/MainLayout.vue'),
    children: [
      {
        path: '/',
        component: Home
      },
      {
        path: '/zeitdaten',
        component: Calendar
      },
      {
        path: '/products',
        component: Products
      },
      {
        path: '/products/:id',
        name: 'product',
        component: Product
      },
      {
        path: '/companies',
        component: Companies
      },
      {
        path: '/companies/:id',
        name: 'company',
        component: Company
      },
      {
        path: '/contact',
        name: 'contact',
        component: Contact
      },
      {
        path: '/login',
        name: 'login',
        component: Login
      },
      {
        path: '/admin',
        name: 'admin',
        component: Admin,
        meta: {
          requiresAuth: true
        }
      },
    ]
  }
]


// Always leave this as last one
if (process.env.MODE !== 'ssr') {
  routes.push({
    path: '*',
    component: () => import('pages/Error404.vue')
  })
}


export default routes
