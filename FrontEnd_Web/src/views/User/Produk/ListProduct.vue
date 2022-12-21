<template>
  <h1 class="mt-3">Product atau Jasa</h1>
  <hr />

  <div class="container mt-3">
    <div class="row row-cols-1 row-cols-md-3 g-4">
      <div class="col" style="max-width: 18rem" v-for="(product, id) in products" :key="id">
        <div class="card border-dark mb-3">
          <img src="https://png.pngtree.com/png-vector/20210501/ourlarge/pngtree-goddess-illustration-for-beauty-care-salon-logo-png-image_3250488.jpg" style="max-height: 150px; max-width: 150px" class="card-img-top m-auto" alt="..." />
          <div class="card-body text-center">
            <hr />
            <h5 class="card-title text-center">{{ product.nama_barang }}</h5>
            <div class="badge bg-dark text-wrap">
              <p class="card-text">Rp.{{ product.harga }} | Stok : {{ product.jumlah }}</p>
            </div>
            <br />
            <hr />
            <span v-if="product.jumlah === '0'"><button class="btn btn-secondary btn-sm" disabled>Pesan Product atau Jasa</button></span>
            <span v-else
              ><router-link :to="{ name: 'userpesan', params: { id: product.id } }"><button class="btn btn-outline-success btn-sm">Pesan Product atau Jasa</button></router-link></span
            >
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
export default {
  setup() {
    //reactive state
    let products = ref([]);
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
        .get("http://localhost:8000/api/product")
        .then((response) => {
          //assign state posts with response data
          products.value = response.data.data;
        })
        .catch((error) => {
          console.log(error.response.data);
        });
    });

    //return
    return {
      products,
    };
  },
};
</script>
