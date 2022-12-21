<template>
  <div class="container mt-5">
    <div class="row">
      <div class="col-md-12">
        <div class="card border-0 rounded shadow">
          <div class="card-body">
            <h4>PEMBAYARAN</h4>
            <hr />
            <form @submit.prevent="update">
              <div class="form-group mb-3">
                <label class="form-label">Nama Product atau Jasa</label>
                <input type="text" class="form-control" v-model="pemesanan.nama_barang" readonly disabled />
                <!-- validation -->
                <div v-if="validation.nama_barang" class="mt-2 alert alert-danger">
                  {{ validation.nama_barang[0] }}
                </div>
              </div>
              <div class="form-group mb-3">
                <label for="content" class="form-label">Jumlah</label>
                <input class="form-control" type="number" v-model="pemesanan.jumlah" placeholder="Masukkan Stok" readonly disabled />
                <!-- validation -->
                <div v-if="validation.jumlah" class="mt-2 alert alert-danger">
                  {{ validation.jumlah[0] }}
                </div>
              </div>
              <div class="form-group mb-3">
                <label for="content" class="form-label">Status</label>
                <select class="form-control" disabled>
                  <option value="" hidden>Pilih Status</option>
                  <option value="1">Dalam Pemesanan</option>
                  <option value="0" selected>BAYAR</option>
                </select>
                <!-- validation -->
                <div v-if="validation.staus" class="mt-2 alert alert-danger">
                  {{ validation.staus[0] }}
                </div>
              </div>
              <button type="submit" class="btn btn-primary">SIMPAN</button>&nbsp;
              <button type="submit" @click="batal" class="btn btn-danger">CANCEL</button>
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

    //state validation
    const validation = ref([]);
    //vue router
    const router = useRouter();
    //params id
    const route = useRoute();
    const token = localStorage.getItem("token");

    onMounted(() => {
      if (!token) {
        router.push({
          name: "Login",
        });
      }
      axios.defaults.headers.common["Authorization"] = `Bearer ${token}`;
      axios
        .get("http://localhost:8000/api/pemesanan/" + route.params.id)
        .then((response) => {
          pemesanan.idUser = response.data.data.idUser;
          pemesanan.idProduct = response.data.data.idProduct;
          pemesanan.nama_barang = response.data.data.nama_barang;
          pemesanan.jumlah = response.data.data.jumlah;
          pemesanan.status = response.data.data.status;
          pemesanan.harga = response.data.data.harga;
          pemesanan.namauser = response.data.data.namauser;
        })
        .catch((error) => {
          console.log(error.response.data);
        });
    });

    //method update
    function update() {
      let idUser = pemesanan.idUser;
      let idProduct = pemesanan.idProduct;
      let nama_barang = pemesanan.nama_barang;
      let jumlah = pemesanan.jumlah;
      let status = 0;
      let harga = pemesanan.harga;
      let namauser = pemesanan.namauser;
      axios
        .put("http://localhost:8000/api/pemesanan/" + route.params.id, {
          idUser: idUser,
          idProduct: idProduct,
          nama_barang: nama_barang,
          harga: harga,
          jumlah: jumlah,
          status: status,
          namauser: namauser,
        })

        .then(() => {
          //redirect ke post index
          router
            .push({
              name: "userpesanlist",
            })
            .then(() => {
              toaster.info(`Berhasil Melakukan Pembayaran`);
            });
        })
        .catch((error) => {
          //assign state validation with error
          validation.value = error.response.data;
        });
    }

    function batal() {
      router.push({
        name: "userpesanlist",
      });
    }
    //return
    return {
      pemesanan,
      validation,
      router,
      update,
      batal,
    };
  },
};
</script>
