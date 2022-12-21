<template>
  <h1 class="mt-3">Distributor Supermarket Kami</h1>
  <hr />
  <div class="container mt-3">
    <div class="row row-cols-1 row-cols-md-3 g-4">
      <div class="card text-bg-dark mb-3 me-2" style="max-width: 18rem" v-for="(distributor, id) in distributors" :key="id">
        <div class="card-header">{{ distributor.kode }}</div>
        <div class="card-body">
          <h5 class="card-title">{{ distributor.nama_distributor }}</h5>
          <p class="card-text">{{ distributor.daerah }} | {{ distributor.nomor_telepon }}</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import { onMounted, ref } from "vue";
import { useRouter } from "vue-router";
export default {
  setup() {
    //reactive state
    let distributors = ref([]);
    //state validation
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
        .get("http://localhost:8000/api/distributor")
        .then((response) => {
          //assign state posts with response data
          distributors.value = response.data.data;
        })
        .catch((error) => {
          console.log(error.response.data);
        });
    });

    //return
    return {
      distributors,
    };
  },
};
</script>
