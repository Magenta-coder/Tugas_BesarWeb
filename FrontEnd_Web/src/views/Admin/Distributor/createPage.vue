<template>
  <div class="container mt-5">
    <div class="row">
      <div class="col-md-12">
        <div class="card border-0 rounded shadow">
          <div class="card-body">
            <h4>TAMBAH DISTRIBUTOR</h4>
            <hr />
            <form @submit.prevent="store">
              <div class="form-group mb-3">
                <label class="form-label">Nama Distributor</label>
                <input type="text" class="form-control" v-model="distributor.nama_distributor" placeholder="Masukkan nama distributor" />
                <!-- validation -->
                <div v-if="validation.nama_distributor" class="mt-2 alert alert-danger">
                  {{ validation.nama_distributor[0] }}
                </div>
              </div>
              <div class="form-group mb-3">
                <label for="content" class="form-label">Daerah</label>
                <input class="form-control" v-model="distributor.daerah" placeholder="Masukkan Daerah" />
                <!-- validation -->
                <div v-if="validation.daerah" class="mt-2 alert alert-danger">
                  {{ validation.daerah[0] }}
                </div>
              </div>
              <div class="form-group mb-3">
                <label for="content" class="form-label">Nomor Telepon</label>
                <input class="form-control" type="number" v-model="distributor.nomor_telepon" placeholder="Masukkan Nomor Telepon" />
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
    //state distributor
    const distributor = reactive({
      nama_distributor: "",
      daerah: "",
      nomor_telepon: "",
    });

    //state validation
    const validation = ref([]);
    //vue router
    const router = useRouter();
    const token = localStorage.getItem("token");
    //method store
    function store() {
      let nama_distributor = distributor.nama_distributor;
      let daerah = distributor.daerah;
      let nomor_telepon = distributor.nomor_telepon;
      axios.defaults.headers.common["Authorization"] = `Bearer ${token}`;
      axios
        .post("http://localhost:8000/api/distributor", {
          nama_distributor: nama_distributor,
          daerah: daerah,
          nomor_telepon: nomor_telepon,
        })
        .then(() => {
          //redirect ke post index

          router
            .push({
              name: "admindistributor",
            })
            .then(() => {
              toaster.success(`Berhasil Menambah Distributor`);
            });
        })
        .catch((error) => {
          //assign state validation with error
          validation.value = error.response.data;
        });
    }
    //return
    return {
      distributor,
      validation,
      router,
      store,
    };
  },
};
</script>
<style></style>
