<template>
  <div style="margin-top: 12px">
    <div class="carousel-item active">
    <img src="https://images-wixmp-ed30a86b8c4ca887773594c2.wixmp.com/f/cb613cb5-33b4-4412-98ba-bcf0ea22d4a2/d56oqze-056200ee-f4cd-4141-9175-40c75fa5de32.jpg/v1/fill/w_1600,h_1000,q_75,strp/eurovision_turkey_fan_page_background_by_alisarikaya_d56oqze-fullview.jpg?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJ1cm46YXBwOjdlMGQxODg5ODIyNjQzNzNhNWYwZDQxNWVhMGQyNmUwIiwiaXNzIjoidXJuOmFwcDo3ZTBkMTg4OTgyMjY0MzczYTVmMGQ0MTVlYTBkMjZlMCIsIm9iaiI6W1t7ImhlaWdodCI6Ijw9MTAwMCIsInBhdGgiOiJcL2ZcL2NiNjEzY2I1LTMzYjQtNDQxMi05OGJhLWJjZjBlYTIyZDRhMlwvZDU2b3F6ZS0wNTYyMDBlZS1mNGNkLTQxNDEtOTE3NS00MGM3NWZhNWRlMzIuanBnIiwid2lkdGgiOiI8PTE2MDAifV1dLCJhdWQiOlsidXJuOnNlcnZpY2U6aW1hZ2Uub3BlcmF0aW9ucyJdfQ.DfyfiFQLiAdSLzmTv6JcuIOi3w1Pueerhawrwwtw8eI" class="d-block w-100" />
          <div class="carousel-caption d-none d-md-block test m-auto p-5">
            <h5 style="color: black;"> <strong>Selamat Datang di Dashboard Admin</strong></h5>
            </div>
          </div>
  </div>
</template>

<style scoped>
.test {
  background-color: white;
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
