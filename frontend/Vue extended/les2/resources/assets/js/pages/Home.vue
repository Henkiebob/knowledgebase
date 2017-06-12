<template>
   <main>
      <div class="product col-md-3 col-sm-6" v-for="product in products">

        <div class="product-body thumbnail">
           <div class="product-name caption">{{ product.name }}</div>
           <div class="product-price">&euro;{{ product.price }}</div>
        </div>

      </div>
   </main>
</template>

<script>
    export default {
      data() {
        return {
          products: [
            'hoi'
          ],
        }
      },
      created () {
      	 this.getProducts()
      },
      mounted() {
         console.log('Component mounted.')
      },
      methods: {
        getProducts() {
            axios.get('/api/products').then(response => this.products = response.data);
        },
      }
    }
</script>
