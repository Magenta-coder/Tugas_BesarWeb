<template>
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">List Pemesanan</h1>
  </div>
  <div class="container mt-5">
    <div class="row">
      <div class="col-md-12">
        <div class="card border-0 rounded shadow">
          <div class="card-body">
            <table class="table table-striped table-bordered mt-4">
              <thead class="thead-dark">
                <tr class="text-center">
                  <th scope="col">NAMA BARANG</th>
                  <th scope="col">KODE PEMESANAN</th>
                  <th scope="col">TOTAL HARGA</th>
                  <th scope="col">JUMLAH</th>
                  <th scope="col">PENGGUNA</th>
                  <th scope="col">STATUS</th>
                  <th scope="col">AKSI</th>
                </tr>
              </thead>
              <tbody class="text-center">
                <tr v-for="(pemesanan, id) in pemesanans" :key="id">
                  <td>{{ pemesanan.nama_barang }}</td>
                  <td>{{ pemesanan.kode }}</td>
                  <td>{{ pemesanan.harga }}</td>
                  <td>{{ pemesanan.jumlah }}</td>
                  <td>{{ pemesanan.namauser }}</td>
                  <td v-if="pemesanan.status === 1">Menunggu Pembayaran</td>
                  <td v-else-if="pemesanan.status === 0">SELESAI</td>
                  <td class="text-center" v-if="pemesanan.status === 1">
                    <button class="btn btn-sm btn-danger ml-1" disabled>HAPUS</button>
                  </td>
                  <td class="text-center" v-else-if="pemesanan.status === 0">
                    <button class="btn btn-sm btn-danger ml-1" @click="del(pemesanan.id)">HAPUS</button>
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
    let pemesanans = ref([]);
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
        .get("http://localhost:8000/api/pemesanan")
        .then((response) => {
          //assign state posts with response data
          pemesanans.value = response.data.data;
        })
        .catch((error) => {
          console.log(error.response.data);
        });
    });
    function del(id) {
      axios
        .delete(`http://localhost:8000/api/pemesanan/${id}`, {})
        .then(() => {
          //redirect ke halaman login
          router
            .push({
              name: "adminhome",
            })
            .then(() => {
              toaster.warning(`Berhasil Menghapus Data Pemesanan`);
            });
        })
        .catch((error) => {
          //assign state validation with error
          validation.value = error.response.data;
        });
    }

    //return
    return {
      pemesanans,
      del,
    };
  },
};
</script>
