<template>
  <section class="vh-100" id="bg">
    <div class="container py-auto h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-12 col-md-8 col-lg-6 col-xl-5">
          <div class="card bg-dark text-white" style="border-radius: 1rem">
            <div class="card-body p-3 text-center">
              <div class="mb-md-5 mt-md-4 pb-2">
                <h2 class="fw-bold mb-2 text-uppercase">Login</h2>
                <p class="text-white-50 mb-5">Please enter your login and password!</p>
                <div v-if="loginFailed" class="alert alert-danger">Email atau Password Anda salah.</div>
                <form @submit.prevent="login">
                  <div class="form-group form-white mb-2 text-start">
                    <label class="form-label text-end" for="typeEmailX">Email</label>
                    <input v-model="user.email" type="email" id="typeEmailX" class="form-control" />
                  </div>
                  <div v-if="validation.email" class="mt-2 alert alert-danger">
                    {{ validation.email[0] }}
                  </div>

                  <div class="form-group form-white mb-4 text-start">
                    <label class="form-label" for="typePasswordX">Password</label>
                    <input v-model="user.password" type="password" id="typePasswordX" class="form-control" />
                  </div>
                  <div v-if="validation.password" class="mt-2 alert alert-danger">
                    {{ validation.password[0] }}
                  </div>
                  <!-- <router-link :to="{ name: 'userhome' }">test</router-link> -->
                  <button class="btn btn-outline-light btn-lg px-5" type="submit">Login</button>
                </form>
              </div>

              <div>
                <p class="mb-0">
                  Don't have an account? <a href="#!" class="text-white-50 fw-bold"><router-link :to="{ name: 'Register' }">Sign Up </router-link></a>
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<style scoped>
#bg {
  background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.5)), url(https://img.freepik.com/premium-vector/grocery-supermarket-interior-with-full-product-shelves_53562-8921.jpg?w=2000);
  background-position: center;
  background-size: cover;
}
</style>

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
    //inisialisasi vue router on Composition API
    const router = useRouter();

    //state user
    const user = reactive({
      email: "",
      password: "",
    });

    //state validation
    const validation = ref([]);

    //state loginFailed
    const loginFailed = ref(null);

    //method login
    function login() {
      //send server with axios
      axios
        .post("http://localhost:8000/api/login", user)
        .then((response) => {
          if (response.data.success) {
            //set token
            localStorage.setItem("id", response.data.user.id);
            localStorage.setItem("name", response.data.user.name);
            localStorage.setItem("email", response.data.user.email);
            localStorage.setItem("token", response.data.access_token);

            //redirect ke halaman dashboard
            if (response.data.user.id === 1) {
              router
                .push({
                  name: "adminhome",
                })
                .then(() => {
                  toaster.success(`Berhasil Login sebagai Admin`);
                });
            } else if (response.data.user.id !== 1) {
              router
                .push({
                  name: "userhome",
                })
                .then(() => {
                  toaster.success(`Berhasil Login sebagai User`);
                });
            }
          }

          //set state loggedIn to true
        })
        .catch((error) => {
          console.log("error login");
          localStorage.removeItem("token");
          loginFailed.value = true;
          //set validation dari error response
          validation.value = error.response.data;
        });
    }

    return {
      user, // <-- state user
      validation, // <-- state validation
      loginFailed, // <-- state loggedIn
      login, // <-- method login
    };
  },
};
</script>
