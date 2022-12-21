<template>
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Produk List</h1>
  </div>
  <div class="container mt-5">
    <div class="row">
      <div class="col-md-12">
        <div class="card border-0 rounded shadow">
          <div class="card-body">
            <router-link :to="{ name: 'adminproductcreate' }" class="btn btn-md btn-success">TAMBAH PRODUK</router-link>
            <table class="table table-striped table-bordered mt-4">
              <thead class="thead-dark">
                <tr class="text-center">
                  <th scope="col">NAMA PRODUK</th>
                  <th scope="col">HARGA</th>
                  <th scope="col">STOK</th>
                  <th scope="col">AKSI</th>
                </tr>
              </thead>
              <tbody class="text-center">
                <tr v-for="(product, id) in products" :key="id">
                  <td>{{ product.nama_barang }}</td>
                  <td>{{ product.harga }}</td>
                  <td>{{ product.jumlah }}</td>
                  <td class="text-center">
                    <router-link :to="{ name: 'adminproductedit', params: { id: product.id } }" class="btn btn-sm btn-primary mr-1"> EDIT</router-link> <v-spacer></v-spacer>
                    <button class="btn btn-sm btn-danger ml-1" @click="del(product.id)">DELETE</button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import axios from "axios";
import { onMounted, ref } from "vue";
import { useRouter } from "vue-router";
import { createToaster } from "@meforma/vue-toaster";
export default {
  setup() {
    const toaster = createToaster({
      position: "top-right",
      duration: 2000,
    });
    //reactive state
    let products = ref([]);
    //state validation
    const validation = ref([]);
    const router = useRouter();
    const token = localStorage.getItem("token");
    //mounted
    onMounted(() => {
      if (!token) {
        router.push({
          name: "Login",
        });
      }
      //get API from Laravel Backend
      axios.defaults.headers.common["Authorization"] = `Bearer ${token}`;
      axios
        .get("http://localhost:8000/api/product")
        .then((response) => {
          //assign state posts with response data
          products.value = response.data.data;
        })
        .catch((error) => {
          console.log(error.response.data);
        });
    });
    function del(id) {
      axios
        .delete(`http://localhost:8000/api/product/${id}`, {})
        .then(() => {
          //redirect ke halaman login
          router
            .push({
              name: "adminhome",
            })
            .then(() => {
              toaster.warning(`Berhasil Delete Data Produk`);
            });
        })
        .catch((error) => {
          //assign state validation with error
          validation.value = error.response.data;
        });
    }
    //return
    return {
      products,
      del,
    };
  },
};
</script>
