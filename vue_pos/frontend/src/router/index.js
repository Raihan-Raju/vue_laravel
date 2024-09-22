import { createRouter, createWebHistory } from "vue-router";
import HomeView from "../views/HomeView.vue";

import Dash from "@/views/adminPanel/Dash.vue";

import ExpenseCategory from "@/components/ExpenseCategory.vue";

import Expense from "@/components/Expense.vue";

import EmployeeList from "@/components/Employee/EmployeeList.vue";
import AddEmployee from "@/components/Employee/AddEmployee.vue";
import EditEmployee from "@/components/Employee/EditEmployee.vue";

import SupplierList from "@/components/supplier/SupplierList.vue";
import AddSupplier from "@/components/supplier/AddSupplier.vue";
import EditSupplier from "@/components/supplier/EditSupplier.vue";

import CustomerList from "@/components/customer/CustomerList.vue";
import AddCustomer from "@/components/customer/AddCustomer.vue";
import EditCustomer from "@/components/customer/EditCustomer.vue";
import Unit from "@/components/Unit.vue";
import Payment from "@/components/Payment.vue";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: "/",
      name: "home",
      component: HomeView,
    },
    {
      path: "/dash",
      name: "dash",
      component: Dash,
      children: [
        {
          path: "/content",
          name: "content",
          component: () => import("../components/Content.vue"),
        },
        {
          path: "/category",
          name: "category",
          component: () => import("../components/Category.vue"),
        },
        {
          path: "/subcategory",
          name: "subcategory",
          component: () => import("../components/SubCategory.vue"),
        },
        {
          path: "/brand",
          name: "brand",
          component: () => import("../components/Brand.vue"),
        },
        {
          path: "/product",
          name: "product",
          component: () => import("../components/Product/ProductList.vue"),
        },
        {
          path: "/addproduct",
          name: "addproduct",
          component: () => import("../components/Product/AddProduct.vue"),
        },
        {
          path: "/editproduct/:id",
          name: "editproduct",
          component: () => import("../components/Product/EditProduct.vue"),
        },
        {
          path: "/expensecategory",
          name: "expncat",
          component: ExpenseCategory,
        },
        {
          path: "/expense",
          name: "expn",
          component: Expense,
        },
        {
          path: "/employee",
          name: "employee",
          component: EmployeeList,
        },
        {
          path: "/addEmployee",
          name: "addEmployee",
          component: AddEmployee,
        },
        {
          path: "/editemployee/:id",
          name: "editemployee",
          component: EditEmployee,
        },
        {
          path: "/supplier",
          name: "supplier",
          component: SupplierList,
        },
        {
          path: "/addsupplier",
          name: "addsupplier",
          component: AddSupplier,
        },
        {
          path: "/editsupplier/:id",
          name: "editsupplier",
          component: EditSupplier,
        },
        {
          path: "/customer",
          name: "customer",
          component: CustomerList,
        },
        {
          path: "/addcustomer",
          name: "addcustomer",
          component: AddCustomer,
        },
        {
          path: "/editcustomer/:id",
          name: "editcustomer",
          component: EditCustomer,
        },
        {
          path: "/unit",
          name: "unit",
          component: Unit,
        },
        {
          path: "/payment",
          name: "payment",
          component: Payment,
        },
        
      ],
    },
    {
      path: "/about",
      name: "about",
      // route level code-splitting
      // this generates a separate chunk (About.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component: () => import("../views/AboutView.vue"),
    },
  ],
});

export default router;
