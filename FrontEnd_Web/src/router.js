//import vue router
import { createRouter, createWebHistory } from "vue-router";
//define a routes
const routes = [
  {
    path: "/",
    name: "Home",
    component: () => import("@/components/HomePage.vue"),
  },
  {
    path: "/",
    name: "Login",
    component: () => import("@/components/LoginPage.vue"),
  },
  {
    path: "/",
    name: "Register",
    component: () => import("@/components/RegisterPage.vue"),
  },
  {
    path: "/",
    name: "User",
    component: () => import("@/views/User/DashboardUser.vue"),
    children: [
      //Home
      {
        path: "/user",
        name: "userhome",
        component: () => import("@/views/User/UserHome.vue"),
      },
      {
        path: "/userprofile",
        name: "userprofile",
        component: () => import("@/views/User/Profile/ProfileIndex.vue"),
      },
      {
        path: "/userdist",
        name: "userdist",
        component: () => import("@/views/User/ListDistributor.vue"),
      },
      {
        path: "/userproduct",
        name: "userproduct",
        component: () => import("@/views/User/Produk/ListProduct.vue"),
      },
      {
        path: "/userpesan",
        name: "userpesan",
        component: () => import("@/views/User/Produk/PesanProduct.vue"),
      },
      {
        path: "/userpesanlist",
        name: "userpesanlist",
        component: () => import("@/views/User/Pemesanan/ListPemesanan.vue"),
      },
      {
        path: "/userpesanedit",
        name: "userpesanedit",
        component: () => import("@/views/User/Pemesanan/editPemesanan.vue"),
      },
      {
        path: "/userbeli",
        name: "userbeli",
        component: () => import("@/views/User/Pemesanan/BeliPage.vue"),
      },
    ],
  },
  {
    path: "/",
    name: "Admin",
    component: () => import("@/views/Admin/DashboardAdmin.vue"),
    children: [
      //Home
      {
        path: "/admin",
        name: "adminhome",
        component: () => import("@/views/Admin/AdminHome.vue"),
      },
      {
        path: "/admin/pegawai",
        name: "adminpegawai",
        component: () => import("@/views/Admin/Pegawai/PegawaiIndex.vue"),
      },
      {
        path: "/admin/pegawai/create",
        name: "adminpegawaicreate",
        component: () => import("@/views/Admin/Pegawai/createPage.vue"),
      },
      {
        path: "/admin/pegawai/edit",
        name: "adminpegawaiedit",
        component: () => import("@/views/Admin/Pegawai/editPage.vue"),
      },
      {
        path: "/admin/product",
        name: "adminproduct",
        component: () => import("@/views/Admin/Product/ProductIndex.vue"),
      },
      {
        path: "/admin/product/create",
        name: "adminproductcreate",
        component: () => import("@/views/Admin/Product/createPage.vue"),
      },
      {
        path: "/admin/product/edit",
        name: "adminproductedit",
        component: () => import("@/views/Admin/Product/editPage.vue"),
      },
      {
        path: "/admin/listpemesanan",
        name: "adminlistpemesanan",
        component: () => import("@/views/Admin/ListPemesanan.vue"),
      },
    ],
  },
];
//create router
const router = createRouter({
  history: createWebHistory(),
  routes, // config routes
});
export default router;
