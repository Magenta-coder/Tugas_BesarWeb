<template>
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Distributor List</h1>
  </div>
  <div class="container mt-5">
    <div class="row">
      <div class="col-md-12">
        <div class="card border-0 rounded shadow">
          <div class="card-body">
            <router-link :to="{ name: 'admindistributorcreate' }" class="btn btn-md btn-success">TAMBAH DISTRIBUTOR</router-link>
            <table class="table table-striped table-bordered mt-4">
              <thead class="thead-dark">
                <tr class="text-center">
                  <th scope="col">NAMA DISTRIBUTOR</th>
                  <th scope="col">KODE DISTRIBUTOR</th>
                  <th scope="col">DAERAH</th>
                  <th scope="col">TELEPON</th>
                  <th scope="col">AKSI</th>
                </tr>
              </thead>
              <tbody class="text-center">
                <tr v-for="(distributor, id) in distributors" :key="id">
                  <td>{{ distributor.nama_distributor }}</td>
                  <td>{{ distributor.kode }}</td>
                  <td>{{ distributor.daerah }}</td>
                  <td>{{ distributor.nomor_telepon }}</td>
                  <td class="text-center">
                    <router-link :to="{ name: 'admindistributoredit', params: { id: distributor.id } }" class="btn btn-sm btn-primary mr-1"> EDIT</router-link> <v-spacer></v-spacer>
                    <button class="btn btn-sm btn-danger ml-1" @click="del(distributor.id)">DELETE</button>
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
    let distributors = ref([]);
    //state validation
    const validation = ref([]);
    const router = useRouter();
    const token = localStorage.getItem("token");
    //mounted
    onMounted(() => {
      //get API from Laravel Backend
      axios.defaults.headers.common["Authorization"] = `Bearer ${token}`;
      axios
        .get("http://localhost:8000/api/distributor")
        .then((response) => {
          //assign state posts with response data
          distributors.value = response.data.data;
        })
        .catch((error) => {
          console.log(error.response.data);
        });
    });
    function del(id) {
      axios
        .delete(`http://localhost:8000/api/distributor/${id}`, {})
        .then(() => {
          //redirect ke halaman login
          router
            .push({
              name: "adminhome",
            })
            .then(() => {
              toaster.warning(`Berhasil Delete Data Departemen`);
            });
        })
        .catch((error) => {
          //assign state validation with error
          validation.value = error.response.data;
        });
    }
    //return
    return {
      distributors,
      del,
    };
  },
};
</script>
