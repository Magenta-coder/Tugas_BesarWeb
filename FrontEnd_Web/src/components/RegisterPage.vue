<template>
  <section class="vh-100" id="bg">
    <div class="container py-auto h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-12 col-md-8 col-lg-6 col-xl-5">
          <div class="card bg-dark text-white" style="border-radius: 1rem">
            <div class="card-body p-4 text-center">
              <div>
                <h2 class="fw-bold text-uppercase">Register</h2>

                <form @submit.prevent="register">
                  <div class="row">
                    <div class="form-group form-white mb-4 text-start">
                      <label class="form-label text-end" for="typeUsernameX">Name</label>
                      <input v-model="user.name" type="text" id="typeUsernameX" class="form-control" placeholder="Insert Your Name" />
                      <div v-if="validation.name" class="mt-2 alert alert-danger">
                        {{ validation.name[0] }}
                      </div>
                    </div>

                    <div class="form-group form-white mb-4 text-start">
                      <label class="form-label text-end" for="typeEmailX">Email</label>
                      <input v-model="user.email" type="email" id="typeEmailX" class="form-control" placeholder="Insert Your Email" />
                      <div v-if="validation.email" class="mt-2 alert alert-danger">
                        {{ validation.email[0] }}
                      </div>
                    </div>
                  </div>

                  <div class="form-group form-white mb-4 text-start">
                    <label class="form-label" for="typePasswordX">Password</label>
                    <input v-model="user.password" type="password" id="typePasswordX" class="form-control" placeholder="Insert Your Password" />
                    <div v-if="validation.password" class="mt-2 alert alert-danger">
                      {{ validation.password[0] }}
                    </div>
                  </div>

                  <button class="btn btn-outline-light btn-lg" type="submit">Register</button>
                </form>
              </div>

              <div>
                <p class="mb-0 mt-2">
                  Already have an account? <a href="#!" class="text-white fw-bold"><router-link :to="{ name: 'Login' }">Login</router-link></a>
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
  background-repeat: no-repeat;
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
      name: "",
      email: "",
      password: "",
    });

    //state validation
    const validation = ref([]);

    //method register
    function register() {
      //send server with axios
      axios
        .post("http://localhost:8000/api/register", user)
        .then(() => {
          //redirect ke halaman login
          router
            .push({
              name: "Login",
            })
            .then(() => {
              toaster.success(`Berhasil Register`);
            });
        })
        .catch((error) => {
          //set validation dari error response
          validation.value = error.response.data;
        });
    }

    return {
      user, // <-- state user
      validation, // <-- state validation
      router,
      register, // <-- method register
    };
  },
};
</script>
