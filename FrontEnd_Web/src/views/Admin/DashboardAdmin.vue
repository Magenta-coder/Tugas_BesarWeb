<template>
  <div class="container-fluid">
    <div class="row flex-nowrap">
      <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-dark" style="position: fixed">
        <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100">
          <a class="d-flex align-items-center pb-3 mx-auto text-white text-decoration-none">
            <span class="fs-3 fw-semibold text-center mt-3">Menu Admin</span>
          </a>
          <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start" id="menu">
            <li class="nav-item">
              <router-link :to="{ name: 'adminhome' }" class="nav-link align-middle px-0"><i class="fs-4 bi-house"></i> <span class="ms-1 d-none d-sm-inline text-white">Home</span></router-link>
            </li>
            <li class="nav-item">
              <router-link :to="{ name: 'adminproduct' }" class="nav-link align-middle px-0"><i class="fs-4 bi bi-plus-square-fill"></i> <span class="ms-1 d-none d-sm-inline text-white">List Barang atau Jasa</span> </router-link>
            </li>
            <li>
              <router-link :to="{ name: 'adminlistpemesanan' }" class="nav-link align-middle px-0"><i class="fs-4 bi bi-cash-stack"></i><span class="ms-1 d-none d-sm-inline text-white">Cek List Pesanan</span> </router-link>
            </li>
            <li>
              <router-link :to="{ name: 'adminpegawai' }" class="nav-link align-middle px-0"><i class="fs-4 bi bi-diagram-3"></i><span class="ms-1 d-none d-sm-inline text-white">List Pegawai</span> </router-link>
            </li>
          </ul>
          <hr />
          <div class="dropdown pb-4">
            <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
              <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTQg2NGwYIETKo6qvR4fSOT5LRh1d-otYgXxQ&usqp=CAU" alt="hugenerd" width="30" height="30" class="rounded-circle" />
              <span class="d-none d-sm-inline mx-1">ADMIN</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
              <li @click.prevent="logout"><a class="dropdown-item">Log out</a></li>
            </ul>
          </div>
        </div>
      </div>
      <main class="col-md-9 ms-sm-auto col-lg-10">
        <!-- View Route -->
        <router-view></router-view>
      </main>
    </div>
  </div>
</template>
<script>
import { useRouter } from "vue-router";
import axios from "axios";
import { createToaster } from "@meforma/vue-toaster";
export default {
  setup() {
    const toaster = createToaster({
      position: "top-right",
      duration: 2000,
    });
    //inisialisasi vue router on Composition API
    const router = useRouter();

    //method logout
    function logout() {
      //logout

      axios
        .post("http://localhost:8000/api/logout")
        .then((response) => {
          if (response.data.success) {
            //remove localStorage
            localStorage.removeItem("token");

            //redirect ke halaman login
            router
              .push({
                name: "Home",
              })
              .then(() => {
                toaster.success(`Berhasil Logout [ADMIN]`);
              });
          }
        })
        .catch((error) => {
          console.log(error.response.data);
        });
    }

    return {
      logout, // <-- method logout
    };
  },
};
</script>
