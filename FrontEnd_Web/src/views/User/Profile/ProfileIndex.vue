<template>
  <div id="bg" class="min-vh-100 d-flex align-items-center">
    <div class="container py-5">
      <div class="row">
        <div class="col-lg-3 m-auto">
          <div class="card mb-4">
            <div class="card-body text-center">
              <img src="https://ps.w.org/user-avatar-reloaded/assets/icon-256x256.png?rev=2540745" alt="avatar" class="rounded-circle img-fluid" style="width: 215px; height: 215px" />
              <h5 class="my-3">{{ user.name }}</h5>
              <hr />
              <p class="text-muted mb-1">User Supermarket</p>
              <p class="text-muted mb-4">{{ user.email }}</p>
            </div>
          </div>
        </div>
        <div class="col m-auto">
          <div class="card mb-4">
            <div class="card-body text-start">
              <h3>EDIT PROFILE</h3>
              <hr />
              <form @submit.prevent="update">
                <div class="form-group mb-3">
                  <label class="form-label">Nama Pengguna</label>
                  <input type="text" class="form-control" v-model="user.name" placeholder="Masukkan nama pengguna" />
                  <!-- validation -->
                  <div v-if="validation.name" class="mt-2 alert alert-danger">
                    {{ validation.name[0] }}
                  </div>
                </div>
                <div class="form-group mb-3">
                  <label for="content" class="form-label">Email</label>
                  <input class="form-control" v-model="user.email" placeholder="Masukkan Email" />
                  <!-- validation -->
                  <div v-if="validation.email" class="mt-2 alert alert-danger">
                    {{ validation.email[0] }}
                  </div>
                </div>
                <div class="form-group mb-3">
                  <label for="content" class="form-label">Password</label>
                  <input class="form-control" type="password" v-model="user.password" placeholder="Masukkan Password Baru" />
                  <!-- validation -->
                  <div v-if="validation.password" class="mt-2 alert alert-danger">
                    {{ validation.password[0] }}
                  </div>
                </div>

                <button type="submit" class="btn btn-primary">SIMPAN</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<style scoped>
#bg {
  background: linear-gradient(rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.3)), url(https://png.pngtree.com/background/20210716/original/pngtree-colorful-colorful-green-orange-yellow-gold-line-watercolor-background-picture-image_1330385.jpg);
  background-position: center;
  background-size: cover;
}
</style>

<script>
import { reactive, ref, onMounted } from "vue";
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
    const user = reactive({
      name: "",
      email: "",
      password: "",
    });
    //state validation
    const validation = ref([]);
    //vue router
    const router = useRouter();
    //params id

    const token = localStorage.getItem("token");
    const idUser = localStorage.getItem("id");
    onMounted(() => {
      if (!token) {
        router.push({
          name: "Login",
        });
      }
      axios.defaults.headers.common["Authorization"] = `Bearer ${token}`;
      axios
        .get("http://localhost:8000/api/user/" + idUser)
        .then((response) => {
          user.name = response.data.data.name;
          user.email = response.data.data.email;
          user.password = response.data.data.password;
        })
        .catch((error) => {
          console.log(error.response.data);
        });
    });

    //method update
    function update() {
      let name = user.name;
      let email = user.email;
      let password = user.password;

      axios
        .put("http://localhost:8000/api/user/" + idUser, {
          name: name,
          email: email,
          password: password,
        })

        .then(() => {
          //redirect ke post index
          router
            .push({
              name: "userhome",
            })
            .then(() => {
              toaster.info(`Berhasil Edit Profile`);
            });
        })
        .catch((error) => {
          //assign state validation with error
          validation.value = error.response.data;
        });
    }
    //return
    return {
      user,
      validation,
      router,
      update,
    };
  },
};
</script>
