import { createRouter, createWebHistory } from "vue-router";
import AdminDashboard from "@/admin-panel/views/Dashboard.vue";
import AdminForms from "@/admin-panel/views/Forms.vue";
import ContactUs from "@/admin-panel/views/ContactUs.vue";
import Products from "@/admin-panel/views/Products.vue";
import Product from "@/front-panel/views/Product.vue";
import FrontPage from "@/front-panel/views/FrontPage.vue";
import CartsAdd from "@/admin-panel/fazle/views/CartsAdd.vue";
import CartLayout from "@/admin-panel/fazle/views/CartLayout.vue";

import CartTable from "@/admin-panel/fazle/views/CartTable.vue";
import UpdateCart from "@/admin-panel/fazle/views/UpdateCart.vue";

import ProductsList from "@/admin-panel/devhelal/products/ProductsList.vue";
import AddProduct from "@/admin-panel/devhelal/products/AddProduct.vue";

import Roles from "@/admin-panel/nazad/Roles/Roles.vue";
import Users from "@/admin-panel/nazad/Users/Users.vue";
import UserCreate from "@/admin-panel/nazad/Users/UserCreate.vue";
import RoleCreate from "@/admin-panel/nazad/Roles/RoleCreate.vue";
import UserEdit from "@/admin-panel/nazad/Users/UserEdit.vue";
import RoleEdit from "@/admin-panel/nazad/Roles/RoleEdit.vue";
import Payment from "@/admin-panel/nazad/Payment/Payment.vue";
import PaytmentCreate from "@/admin-panel/nazad/Payment/PaytmentCreate.vue";
import PaymentEdit from "@/admin-panel/nazad/Payment/PaymentEdit.vue";
import UpdateProduct from "@/admin-panel/devhelal/products/UpdateProduct.vue";

import Categorylist from "@/admin-panel/foysal/components/category/Categorylist.vue";
import Categoryadd from "@/admin-panel/foysal/components/category/Categoryadd.vue";
import Sub_categoryAdd from "@/admin-panel/foysal/components/category/sub_category/Sub_categoryAdd.vue";
import Sub_categoryLayout from "@/admin-panel/foysal/components/category/sub_category/Sub_categoryLayout.vue";
import Categoryupdate from "@/admin-panel/foysal/components/category/Categoryupdate.vue";
import Sub_categorylist from "@/admin-panel/foysal/components/category/sub_category/Sub_categorylist.vue";
import Sub_categoryupdate from "@/admin-panel/foysal/components/category/sub_category/Sub_categoryupdate.vue";
import Wishlistlayout from "@/admin-panel/foysal/components/wishlist/Wishlistlayout.vue";
import Wishlistadd from "@/admin-panel/foysal/components/wishlist/Wishlistadd.vue";
import Wishlisttable from "@/admin-panel/foysal/components/wishlist/Wishlisttable.vue";
import Wishlistupdate from "@/admin-panel/foysal/components/wishlist/Wishlistupdate.vue";
import OrderTable from "@/admin-panel/fazle/order/OrderTable.vue";
import OrderLayout from "@/admin-panel/fazle/order/OrderLayout.vue";
import OrderDetails from "@/admin-panel/fazle/order/OrderDetails.vue";
import store from "@/stores";
import AddPurchases from "@/admin-panel/devhelal/purchases/AddPurchases.vue";
import PurchasesList from "@/admin-panel/devhelal/purchases/PurchasesList.vue";
const routes = [
  {
    path: "/admin",
    name: "admin",
    component: () => import("@/admin-panel/views/Master.vue"),
    children: [
      {
        path: "login",
        name: "login",
        meta: {
          middleware: "guest",
          title: "vadmin",
        },
        component: () => import("@/admin-panel/views/LogIn.vue"),
      },
      {
        path: "",
        name: "main-layout",
        component: () => import("@/admin-panel/views/MainLayout.vue"),
        meta: {
          middleware: "admin",
          title: "vadmin",
        },
        children: [
          {
            path: "",
            name: "dashboard",
            component: AdminDashboard,
          },
          {
            path: "forms",
            name: "adminforms",
            component: AdminForms,
          },
          {
            path: "contact",
            name: "contactus",
            component: ContactUs,
          },
          {
            path: "productlist",
            name: "productslist",
            component: ProductsList,
          },
          {
            path: "addproduct",
            name: "addproducts",
            component: AddProduct,
          },
          {
            path: "updateproduct/:id",
            name: "updateproduct",
            component: UpdateProduct,
          },
          {
            path: "product",
            name: "products",
            component: Products,
          },
          {
            path: "purchaseslist",
            name: "purchaseslist",
            component: PurchasesList,
          },
          {
            path: "addpurchases",
            name: "addpurchases",
            component: AddPurchases,
          },
          {
            path: "coupons",
            name: "coupons",
            component: () =>
              import("@/admin-panel/ruhul/views/CouponsLaout.vue"),
            children: [
              {
                path: "coupons-add",
                name: "couponsAdd",
                component: () =>
                  import("@/admin-panel/ruhul/views/CouponsAdd.vue"),
              },
              {
                path: "coupons-list",
                name: "couponsshow",
                component: () =>
                  import("@/admin-panel/ruhul/views/CouponsList.vue"),
              },
              {
                path: "coupons-update/:id",
                name: "couponsUpdate",
                component: () =>
                  import("@/admin-panel/ruhul/views/UpdateCupons.vue"),
              },
              {
                path: "coupons-use",
                name: "couponsUse",
                component: () =>
                  import("@/admin-panel/ruhul/views/UseCuponsAdd.vue"),
              },
              {
                path: "coupons-uselist",
                name: "couponsUselist",
                component: () =>
                  import("@/admin-panel/ruhul/views/UsecuponList.vue"),
              },
              {
                path: "coupons-useupdate/:id",
                name: "couponsUseUpdate",
                component: () =>
                  import("@/admin-panel/ruhul/views/UpdateUseCoupon.vue"),
              },
            ],
          },
          {
            path: "categorylist",
            name: "categorylist",
            component: Categorylist,
          },
          {
            path: "category",
            name: "category",
            component: Categoryadd,
          },
          {
            path: "categoryupdate/:id",
            name: "categoryupdate",
            component: Categoryupdate,
          },
          {
            path: "sub_category",
            name: "sub-category",
            component: Sub_categoryLayout,
            children: [
              {
                path: "sub_add",
                name: "sub_add",
                component: Sub_categoryAdd,
              },
              {
                path: "sub_list",
                name: "sub_list",
                component: Sub_categorylist,
              },
              {
                path: "sub_update/:id",
                name: "sub_update",
                component: Sub_categoryupdate,
              },
            ],
          },
          {
            path: "wishlist",
            name: "wishlist",
            component: Wishlistlayout,
            children: [
              {
                path: "wishlistadd",
                name: "wishlistadd",
                component: Wishlistadd,
              },
              {
                path: "wishlisttable",
                name: "wishlisttable",
                component: Wishlisttable,
              },
              {
                path: "wishlistupdate/:id",
                name: "wishlistupdate",
                component: Wishlistupdate,
              },
            ],
          },
          {
            path: "roles",
            name: "roles",
            component: Roles,
          },
          {
            path: "rolecreate",
            name: "rolecreate",
            component: RoleCreate,
          },
          {
            path: "roleedit/:id",
            name: "roleedit",
            component: RoleEdit,
          },
          {
            path: "users",
            name: "users",
            component: Users,
          },
          {
            path: "usercreate",
            name: "usercreate",
            component: UserCreate,
          },
          {
            path: "useredit/:id",
            name: "useredit",
            component: UserEdit,
          },
          {
            path: "payment",
            name: "payment",
            component: Payment,
          },
          {
            path: "paymentcreate",
            name: "paymentcreate",
            component: PaytmentCreate,
          },
          {
            path: "paymentedit/:id",
            name: "paymentedit",
            component: PaymentEdit,
          },
          {
            path: "shipment",
            name: "shipment",
            component: () =>
              import("@/admin-panel/ruhul/views/ShipmentLayout.vue"),
            children: [
              {
                path: "shipment-add",
                name: "shipment-add",
                component: () =>
                  import("@/admin-panel/ruhul/views/ShipmentAdd.vue"),
              },
              {
                path: "shipment-list",
                name: "shipment-list",
                component: () =>
                  import("@/admin-panel/ruhul/views/ShipmentList.vue"),
              },
              {
                path: "shipment-edit/:id",
                name: "shipment-edit",
                component: () =>
                  import("@/admin-panel/ruhul/views/UpdateShipment.vue"),
              },
            ],
          },
          {
            path: "product-review",
            name: "product-review",
            component: () =>
              import("@/admin-panel/ruhul/views/ProductReviewLayout.vue"),
            children: [
              {
                path: "product-review-add",
                name: "product-review-add",
                component: () =>
                  import("@/admin-panel/ruhul/views/ProductReviewCreate.vue"),
              },
              {
                path: "product-review-list",
                name: "product-review-list",
                component: () =>
                  import("@/admin-panel/ruhul/views/ProductReviewTable.vue"),
              },
              {
                path: "product-review-edit/:id",
                name: "product-review-edit",
                component: () =>
                  import("@/admin-panel/ruhul/views/ProductReviewEdit.vue"),
              },
            ],
          },
          {
          path: 'inventory',
          name: 'inventory',
          component: ()=>import("@/admin-panel/foysal/components/inventory/Inventory.vue"),
          children: [ 
            {
              path: 'inventoryadd',
              name: 'inventoryadd',
              component: ()=>import("@/admin-panel/foysal/components/inventory/Inventoryadd.vue"),
            },
            {
              path: 'inventorylist',
              name: 'inventorylist',
              component: ()=>import("@/admin-panel/foysal/components/inventory/Inventorylist.vue"),
            },
            {
              path: 'inventoryupdate/:id',
              name: 'inventoryupdate',
              component: ()=>import("@/admin-panel/foysal/components/inventory/Inventoryupdate.vue"),
            },
          ]
        },
          {
            path: "product-price",
            name: "product-price",
            component: () =>
              import("@/admin-panel/ruhul/views/ProductPriceLayout.vue"),
            children: [
              {
                path: "product-price-add",
                name: "product-price-add",
                component: () =>
                  import("@/admin-panel/ruhul/views/ProductPriceCreate.vue"),
              },
              {
                path: "product-price-list",
                name: "product-price-list",
                component: () =>
                  import("@/admin-panel/ruhul/views/ProductPriceTable.vue"),
              },
              {
                path: "product-price-edit/:id",
                name: "product-price-edit",
                component: () =>
                  import("@/admin-panel/ruhul/views/ProductPriceEdit.vue"),
              },
            ],
          },
          {
            path: "cart1",
            name: "cartOne",
            component: CartLayout,
            children: [
              {
                path: "cart-add",
                name: "cartAdd",
                component: CartsAdd,
              },
              {
                path: "cart-table",
                name: "cartTable",
                component: CartTable,
              },
              {
                path: "cart-update/:id",
                name: "cartUpdate",
                component: UpdateCart,
              },
              {
                path: "flight",
                name: "flight",
                component: () =>
                  import("@/admin-panel/fazle/views/FlightTable.vue"),
              },
            ],
          },
          {
            path: "customer-report",
            name: "customer-report",
            component: () =>
              import("@/admin-panel/fazle/customer-report/components/CustomerLayout.vue"),
            children: [
              {
                path: "customer-list",
                name: "customer-list",
                component: () =>
                  import("@/admin-panel/fazle/customer-report/views/CustomerList.vue"),
              },
              {
                path: "creport/:id",
                name: "creport",
                component: () =>
                  import("@/admin-panel/fazle/customer-report/views/CustomerReport.vue"),
              },
              {
                path: "coreport/:id",
                name: "coreport",
                component: () =>
                  import("@/admin-panel/fazle/customer-report/views/CustomerOrderReport.vue"),
              },
            ],
          },
          {
            path: "order-layout",
            name: "order-layout",
            component: OrderLayout,
            children: [
              {
                path: "order-list",
                name: "order-list",
                component: OrderTable,
              },
              {
                path: "order-details/:id",
                name: "order-details",
                component: OrderDetails,
              },
            ],
          },
        ],
      },
    ],
  },
  {
    path: "/",
    name: "main",
    component: () => import("@/front-panel/views/MainLayout.vue"),
    meta: {
      middleware: "guest",
      title: "vcommerce",
    },
    children: [
      {
        path: "",
        name: "home",
        component: FrontPage,
      },
      {
        path: "products",
        name: "products",
        component: Product,
      },
      {
        path: "about",
        name: "about",
        component: () => import("@/front-panel/views/AboutPage.vue"),
      },
      {
        path: "modalshow",
        name: "modalshow",
        component: () => import("@/front-panel/fazle/views/ModalShow.vue"),
      },
      {
        path: "shopping-cart",
        name: "cart",
        component: () => import("@/front-panel/views/ShoppingCart.vue"),
      },
      {
        path: "testone",
        name: "testone",
        component: () => import("@/front-panel/views/TestOne.vue"),
      },
      {
        path: "vendor",
        name: "vendor",
        component: () => import("@/front-panel/fazle/views/Vendor.vue"),
        meta: {
          middleware: "vendor",
          title: "Vendor Dashboard",
        },
      },
      {
        path: "customer",
        name: "customer",
        component: () => import("@/front-panel/fazle/views/Customer.vue"),
        meta: {
          middleware: "customer",
          title: "Customer Dashboard",
        },
        redirect: { name: "customer-order-list" },
        children: [
          {
            path: "",
            name: "customer-order-list",
            component: () =>
              import("@/front-panel/fazle/components/OrderList.vue"),
          },
          {
            path: "customer-wish-list",
            name: "customer-wish-list",
            component: () =>
              import("@/front-panel/fazle/components/WishList.vue"),
          },
          {
            path: "customer-invoice",
            name: "customer-invoice",
            component: () =>
              import("@/front-panel/fazle/components/Cinvoice.vue"),
          },
        ],
      },
    ],
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
  scrollBehavior(to, from, savedPosition) {
    return { top: 0 };
  },
});

router.beforeEach((to, from, next) => {
  const title = to.meta.title;
  if (title) {
    document.title = title;
  }
  if (to.meta.middleware == "guest") {
    next();
  } else if (to.meta.middleware == "customer") {
    if (store.state.auth.authenticated && store.state.auth.user.role_id == 2) {
      next();
    } else {
      next({ name: "login" });
    }
  } else if (to.meta.middleware == "vendor") {
    if (store.state.auth.authenticated && store.state.auth.user.role_id == 3) {
      next();
    } else {
      next({ name: "login" });
    }
  } else if (to.meta.middleware == "admin") {
    if (store.state.auth.authenticated && store.state.auth.user.role_id == 1) {
      next();
    } else {
      next({ name: "login" });
    }
  }
});

export default router;
