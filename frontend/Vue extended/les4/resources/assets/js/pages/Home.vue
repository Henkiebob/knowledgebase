<template>
   <main>
      <section id="search-engine" class="jumbotron" :class="{ filled: searchString.length !== 0 }">
        <div class="container">
          <h1 class="">Bier&#127866;</h1>
          <div class="input-group">
            <input type="text" class="form-control" v-model="searchString" placeholder="Zoek bier...">
            <span class="input-group-btn">
              <button class="btn btn-primary" type="button">Geef!</button>
            </span>
          </div><!-- /input-group -->
        </div>
      </section>

        <section id="results">
           <div class="container">

              <div class="product col-md-3 col-sm-6" v-for="product in filteredData">
               <div class="product-body thumbnail">
                  <div class="product-name caption">{{ product.name }}</div>
                  <div class="product-price">&euro;{{ product.price }}</div>
                  <button class="btn btn-primary product-button" type="button" @click="addToCart(product)">In winkelwagen</button>
               </div>
            </div>
           </div>
        </section>
</main>
</template>

<script>
   import cart from '../store/cart.js';
    export default {
      data() {
         return {
            products: [],
            searchString:"",
            searchResults:[]
         }
      },
        mounted() {
            console.log('Component mounted.')
        },
        created() {
          this.getProducts();
        },
        computed: {
          // Deze functie zoekt op producten
          filteredData: function () {
             var results_array = this.searchResults,
                 searchString = this.searchString;
             // Als de zoekstring leeg is stuur de products array terug
             if(!searchString){
                return this.products;
             }
             // We willen dat zoek machine niet hoofdletter gevoelig is, dus maken we alles kleine letters.
             searchString = searchString.trim().toLowerCase();

             // Als zoekstring is ingevuld
             if (searchString) {
                //filter functie
                results_array = this.products.filter(function(product){
                   // als productnaam in kleine letters gelijk is aan de searchString stuur product terug.
                   if(product.name.toLowerCase().indexOf(searchString) !== -1){
                      return product;
                   }
                })
                }
                //return product
             return results_array;
          },

         },
        methods: {
           getProducts() {
            axios.get('/api/products').then(response => this.products = response.data);
         },
         addToCart(product) {
            var   products = cart.state.products;
            var    foundProduct = false;
            //Doorzoek alle producten in winkelwagen
            for (var i = 0; i < products.length; i++) {
               // als product ID gelijk is aan toegevoegde product ID, voeg nieuwe toe.
               if(products[i].id === product.id) {
                  var newProduct = products[i];
                  // totaal aantal van dat product +1
                  newProduct.quantity++;
                  cart.state.itemTotal++;
                  // werk de winkelwagen bij
                  cart.setProduct([i], newProduct);
                  //Als product gevonden wordt, stop de rest van de functie
                  foundProduct = true;
                  break;
               }
            }
            if(!foundProduct) {
              product.quantity = 1;
              cart.state.itemTotal++;
              cart.addProduct(product);
            }
         }
        }
    }
</script>
