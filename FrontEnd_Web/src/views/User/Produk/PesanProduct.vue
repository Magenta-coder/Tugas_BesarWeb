<template>
  <div class="container mt-5">
    <div class="row">
      <div class="col-md-12">
        <div class="card border-0 rounded shadow">
          <div class="card-body">
            <h4>PESAN PRODUK</h4>
            <hr />
            <form @submit.prevent="store">
              <div class="form-group mb-3">
                <label class="form-label">Nama Barang</label>
                <input type="text" class="form-control" v-model="product.nama_barang" readonly />
                <!-- validation -->
                <div v-if="validation.nama_barang" class="mt-2 alert alert-danger">
                  {{ validation.nama_barang[0] }}
                </div>
              </div>
              <div class="form-group mb-3">
                <label for="content" class="form-label">Jumlah</label>
                <input class="form-control" type="number" v-model="pemesanan.jumlah" placeholder="Masukkan Stok" />
                <!-- validation -->
                <div v-if="validation.jumlah" class="mt-2 alert alert-danger">
                  {{ validation.jumlah[0] }}
                </div>
              </div>
              <div class="form-group mb-3">
                <label for="content" class="form-label">Status</label>
                <select class="form-control">
                  <option value="" disabled hidden>Pilih Status</option>
                  <option value="1" selected>Dalam Pemesanan</option>
                  <option value="0" disabled>Sudah Bayar</option>
                </select>
                <!-- validation -->
                <div v-if="validation.staus" class="mt-2 alert alert-danger">
                  {{ validation.staus[0] }}
                </div>
              </div>
              <button type="submit" class="btn btn-primary">SIMPAN</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { reactive, ref, onMounted } from "vue";
import { useRouter, useRoute } from "vue-router";
import axios from "axios";
import { createToaster } from "@meforma/vue-toaster";
export default {
  setup() {
    const toaster = createToaster({
      position: "top-right",
      duration: 2000,
    });
    //state pemesanan
    const pemesanan = reactive({
      idUser: "",
      idProduct: "",
      nama_barang: "",
      jumlah: "",
      status: "",
      namauser: "",
      harga: "",
    });
    const product = reactive({
      nama_barang: "",
      harga: "",
      jumlah: "",
    });
    //state validation
    const validation = ref([]);
    //vue router
    const router = useRouter();
    const route = useRoute();
    const token = localStorage.getItem("token");
    const userId = localStorage.getItem("id");
    const userNama = localStorage.getItem("name");

    //method store

    onMounted(() => {
      if (!token) {
        router.push({
          name: "Login",
        });
      }
      axios.defaults.headers.common["Authorization"] = `Bearer ${token}`;
      getBarang();
    });

    function getBarang() {
      axios
        .get("http://localhost:8000/api/product/" + route.params.id)
        .then((response) => {
          //assign state posts with response data
          product.nama_barang = response.data.data.nama_barang;
          product.harga = response.data.data.harga;
          product.jumlah = response.data.data.jumlah;
        })
        .catch((error) => {
          console.log(error.response.data);
        });
    }
    function store() {
      let jumlah = pemesanan.jumlah;
      let harga = jumlah * product.harga;
      axios.defaults.headers.common["Authorization"] = `Bearer ${token}`;
      axios
        .post("http://localhost:8000/api/pemesanan", {
          idUser: userId,
          idProduct: route.params.id,
          nama_barang: product.nama_barang,
          jumlah: jumlah,
          status: 1,
          namauser: userNama,
          harga: harga,
        })
        .then(() => {
          //redirect ke post index

          router
            .push({
              name: "userproduct",
            })
            .then(() => {
              toaster.success(`Berhasil Menambah Product`);
            });
        })
        .catch((error) => {
          //assign state validation with error
          validation.value = error.response.data;
        });
    }
    //return
    return {
      pemesanan,
      product,
      validation,
      router,
      store,
    };
  },
};
</script>
<style></style>
