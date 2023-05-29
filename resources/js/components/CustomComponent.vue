<template>
    <div class="container mx-auto my-auto py-4">
      <ul v-if="loading">
        <li>Cargando productos...</li>
      </ul>
      <ul v-else>
        <li v-for="product in products" :key="product.id">
          {{ product.name }} - $USD {{ product.price }}
        </li>
      </ul>
      <div v-if="nextPageUrl">
        <button @click="loadNextPage">Cargar siguiente página</button>
      </div>
    </div>
</template>
  
  <script>
  import axios from 'axios';
import { toHandlers } from 'vue';
  
  export default {
    data() {
      return {
        loading: false,
        currentPage: 1,
        nextPageUrl: null,
        products: []
      };
    },
    created() {
      this.loadProducts();
    },
    methods: {
      async loadProducts() {
        try {
          this.loading = true;
  
          const url = this.nextPageUrl || '/load?page=' + this.currentPage;
          const response = await axios.get(url);
  
          this.products = response.data.data;
          this.nextPageUrl = response.data.path + '?page=' + this.currentPage;
          console.log(this.nextPageUrl);
  
          this.loading = false;
        } catch (error) {
          console.log(error);
          this.loading = false;
        }
      },
      loadNextPage() {
        this.currentPage++;
        // this.nextPageUrl = response.data.next_page_url
        this.loadProducts();
      }
    }
  };
  </script>
  