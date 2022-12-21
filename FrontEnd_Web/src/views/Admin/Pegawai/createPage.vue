<template>
  <div class="container mt-5">
    <div class="row">
      <div class="col-md-12">
        <div class="card border-0 rounded shadow">
          <div class="card-body">
            <h4>TAMBAH PEGAWAI</h4>
            <hr />
            <form @submit.prevent="store">
              <div class="form-group mb-3">
                <label class="form-label">Nama Pegawai</label>
                <input type="text" class="form-control" v-model="pegawai.nama_pegawai" placeholder="Masukkan nama pegawai" />
                <!-- validation -->
                <div v-if="validation.nama_pegawai" class="mt-2 alert alert-danger">
                  {{ validation.nama_pegawai[0] }}
                </div>
              </div>
              <div class="form-group mb-3">
                <label for="content" class="form-label">Posisi</label>
                <input class="form-control" v-model="pegawai.posisi" placeholder="Masukkan posisi pegawai" />
                <!-- validation -->
                <div v-if="validation.posisi" class="mt-2 alert alert-danger">
                  {{ validation.posisi[0] }}
                </div>
              </div>
              <div class="form-group mb-3">
                <label for="content" class="form-label">Nomor Telepon</label>
                <input class="form-control" type="number" v-model="pegawai.nomor_telepon" placeholder="Masukkan Nomor Telepon" />
                <!-- validation -->
                <div v-if="validation.nomor_telepon" class="mt-2 alert alert-danger">
                  {{ validation.nomor_telepon[0] }}
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
import { reactive, ref } from "vue";
import { useRouter } from "vue-router";
import axios from "axios";
import { createToaster } from "@meforma/vue-toaster";
export default {
  setup() {
    const toaster = createToaster({
      position: "top-right",
      duration: 2000,
    });

    const pegawai = reactive({
      nama_pegawai: "",
      posisi: "",
      nomor_telepon: "",
    });

    //state validation
    const validation = ref([]);
    //vue router
    const router = useRouter();
    const token = localStorage.getItem("token");
    //method store
    function store() {
      let nama_pegawai = pegawai.nama_pegawai;
      let posisi = pegawai.posisi;
      let nomor_telepon = pegawai.nomor_telepon;
      axios.defaults.headers.common["Authorization"] = `Bearer ${token}`;
      axios
        .post("http://localhost:8000/api/pegawai", {
          nama_pegawai: nama_pegawai,
          posisi: posisi,
          nomor_telepon: nomor_telepon,
        })
        .then(() => {

          router
            .push({
              name: "adminpegawai",
            })
            .then(() => {
              toaster.success(`Berhasil Menambah Pegawai`);
            });
        })
        .catch((error) => {
          //assign state validation with error
          validation.value = error.response.data;
        });
    }
    //return
    return {
      pegawai,
      validation,
      router,
      store,
    };
  },
};
</script>
<style></style>
