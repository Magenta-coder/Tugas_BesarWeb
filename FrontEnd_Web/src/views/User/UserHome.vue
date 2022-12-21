<template>
  <div style="margin-top: 12px">
    <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="false">
      <div class="carousel-indicators">
        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
      </div>
      <div class="carousel-inner">
        <div class="carousel-item active">
          <img src="../../assets/s1.jpg" class="d-block w-100" alt="..." />
          <div class="carousel-caption d-none d-md-block test m-auto p-5">
            <h5>
              Selamat Datang di Supermarket kami, Pengguna <strong>{{ user.name }}</strong>
            </h5>
            <p>Sistem ini kami buat untuk mempermudah kegiatan bisnis dari sebuah supermarket</p>
          </div>
        </div>
        <div class="carousel-item">
          <img src="../../assets/s2.jpg" class="d-block w-100" alt="..." />
          <div class="carousel-caption d-none d-md-block test p-5">
            <h5>
              Selamat Datang di Supermarket kami, Pengguna <strong>{{ user.name }}</strong>
            </h5>
            <p>Sistem ini kami buat untuk mempermudah kegiatan bisnis dari sebuah supermarket</p>
          </div>
        </div>
        <div class="carousel-item">
          <img src="../../assets/s3.jpg" class="d-block w-100" alt="..." />
          <div class="carousel-caption d-none d-md-block test p-5">
            <h5>
              Selamat Datang di Supermarket kami, Pengguna <strong>{{ user.name }}</strong>
            </h5>
            <p>Sistem ini kami buat untuk mempermudah kegiatan bisnis dari sebuah supermarket</p>
          </div>
        </div>
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
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
