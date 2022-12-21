<template>
  <div style="margin-top: 12px">
    <div class="carousel-item active">
    <img src="https://img.freepik.com/free-vector/makeup-beautician-hairdresser-salon-illustration_1284-59326.jpg?w=2000" class="d-block w-100" />
          <div class="carousel-caption d-none d-md-block test m-auto p-5">
            <h5>Selamat Datang di Go Salon, <strong>{{ user.name }}</strong></h5>
            </div>
          </div>
  </div>
</template>
<style scoped>
.test {
  background-color: black;
  opacity: 75%;
  border-radius: 10px;
}

.carousel-caption {
  top: 50%;
  transform: translateY(-50%);
  bottom: initial;
}
</style>
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
