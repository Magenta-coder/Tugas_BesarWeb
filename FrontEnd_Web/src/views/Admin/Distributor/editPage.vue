<template>
  <div class="container mt-5">
    <div class="row">
      <div class="col-md-12">
        <div class="card border-0 rounded shadow">
          <div class="card-body">
            <h4>EDIT DISTRIBUTOR</h4>
            <hr />
            <form @submit.prevent="update">
              <div class="form-group mb-3">
                <label class="form-label">Nama Distributor</label>
                <input type="text" class="form-control" v-model="distributor.nama_distributor" placeholder="Masukkan nama distributor" />
                <!-- validation -->
                <div v-if="validation.nama_distributor" class="mt-2 alert alert-danger">
                  {{ validation.nama_distributor[0] }}
                </div>
              </div>
              <div class="form-group mb-3">
                <label for="content" class="form-label">Kode</label>
                <input class="form-control" v-model="distributor.kode" readonly disabled />
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
    //state distributor
    const distributor = reactive({
      nama_distributor: "",
      kode: "",
      daerah: "",
      nomor_telepon: "",
    });
    //state validation
    const validation = ref([]);
    //vue router
    const router = useRouter();
    //params id
    const route = useRoute();
    const token = localStorage.getItem("token");
    onMounted(() => {
      axios.defaults.headers.common["Authorization"] = `Bearer ${token}`;
      axios
        .get("http://localhost:8000/api/distributor/" + route.params.id)
        .then((response) => {
          distributor.nama_distributor = response.data.data.nama_distributor;
          distributor.kode = response.data.data.kode;
          distributor.daerah = response.data.data.daerah;
          distributor.nomor_telepon = response.data.data.nomor_telepon;
        })
        .catch((error) => {
          console.log(error.response.data);
        });
    });

    //method update
    function update() {
      let nama_distributor = distributor.nama_distributor;
      let daerah = distributor.daerah;
      let nomor_telepon = distributor.nomor_telepon;
      let kode = distributor.kode;
      axios
        .put("http://localhost:8000/api/distributor/" + route.params.id, {
          nama_distributor: nama_distributor,
          kode: kode,
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
              toaster.info(`Berhasil Edit Distributor`);
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
      update,
    };
  },
};
</script>
