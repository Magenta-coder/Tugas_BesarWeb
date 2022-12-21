<template>
  <div class="container mt-5">
    <div class="row">
      <div class="col-md-12">
        <div class="card border-0 rounded shadow">
          <div class="card-body">
            <h4>TAMBAH PRODUK</h4>
            <hr />
            <form @submit.prevent="store">
              <div class="form-group mb-3">
                <label class="form-label">Nama Barang</label>
                <input type="text" class="form-control" v-model="product.nama_barang" placeholder="Masukkan nama barang" />
                <!-- validation -->
                <div v-if="validation.nama_barang" class="mt-2 alert alert-danger">
                  {{ validation.nama_barang[0] }}
                </div>
              </div>
              <div class="form-group mb-3">
                <label for="content" class="form-label">Harga</label>
                <input class="form-control" v-model="product.harga" placeholder="Masukkan Harga" />
                <!-- validation -->
                <div v-if="validation.harga" class="mt-2 alert alert-danger">
                  {{ validation.harga[0] }}
                </div>
              </div>
              <div class="form-group mb-3">
                <label for="content" class="form-label">Stok</label>
                <input class="form-control" type="number" v-model="product.jumlah" placeholder="Masukkan Stok" />
                <!-- validation -->
                <div v-if="validation.jumlah" class="mt-2 alert alert-danger">
                  {{ validation.jumlah[0] }}
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
import { useRouter } from "vue-router";
import axios from "axios";
import { createToaster } from "@meforma/vue-toaster";
export default {
  setup() {
    const toaster = createToaster({
      position: "top-right",
      duration: 2000,
    });
    //state product
    const product = reactive({
      nama_barang: "",
      harga: "",
      jumlah: "",
    });

    //state validation
    const validation = ref([]);
    //vue router
    const router = useRouter();
    const token = localStorage.getItem("token");

    onMounted(() => {
      if (!token) {
        router.push({
          name: "Login",
        });
      }
    });
    //method store
    function store() {
      let nama_barang = product.nama_barang;
      let harga = product.harga;
      let jumlah = product.jumlah;
      axios.defaults.headers.common["Authorization"] = `Bearer ${token}`;
      axios
        .post("http://localhost:8000/api/product", {
          nama_barang: nama_barang,
          harga: harga,
          jumlah: jumlah,
        })
        .then(() => {
          //redirect ke post index

          router
            .push({
              name: "adminproduct",
            })
            .then(() => {
              toaster.success(`Berhasil Menambah product`);
            });
        })
        .catch((error) => {
          //assign state validation with error
          validation.value = error.response.data;
        });
    }
    //return
    return {
      product,
      validation,
      router,
      store,
    };
  },
};
</script>
<style></style>
