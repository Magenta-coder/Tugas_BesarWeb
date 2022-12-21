<template>
  <div class="m-auto mt-5 text-center">
    <div class="m-auto">
      <hr />
      <div class="card text-center mt-5 mb-5">
        <div class="card-header">Admin Page</div>
        <div class="card-body">
          <h5 class="card-title">Welcome to Admin Page</h5>
          <p class="card-text">Please Manage This Page As You Like</p>
        </div>
        <div class="card-footer text-muted">Admin</div>
      </div>

      <hr />
    </div>
  </div>
</template>
<script>
import { onMounted, ref } from "vue";
import { useRouter } from "vue-router";
import axios from "axios";

export default {
  setup() {
    //state token
    const token = localStorage.getItem("token");

    //inisialisasi vue router on Composition API
    const router = useRouter();

    //state user
    const user = ref("");

    //mounted properti
    onMounted(() => {
      //check Token exist
      if (!token) {
        router.push({
          name: "Login",
        });
      }

      //get data user
      axios.defaults.headers.common["Authorization"] = `Bearer ${token}`;
      axios
        .get("http://localhost:8000/api/user")
        .then((response) => {
          //console.log(response.data.name)
          user.value = response.data;
        })
        .catch((error) => {
          console.log(error.response.data);
        });
    });

    return {
      token, // <-- state token
      user, // <-- state user
    };
  },
};
</script>
