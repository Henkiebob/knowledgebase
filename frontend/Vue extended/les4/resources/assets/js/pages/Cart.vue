<template>
   <main>
     <section id="cart">
        <div class="container">
           <h1>Winkelbierkrat</h1>

           <div class="panel panel-default">
              <table class="table">
                 <thead>
                  <tr>
                    <th>Bier</th>
                    <th>Aantal</th>
                    <th>Prijs</th>
                  </tr>
                 </thead>
                 <tbody>
                  <tr v-for="product in products">
                    <td>{{product.name}}</td>
                    <td>{{product.quantity}}</td>
                    <td>{{product.price}}</td>
                  </tr>
                 </tbody>
                 <tfoot>
                    <tr>
                       <td></td>
                       <td align="right">Totaal:</td>
                       <td>0</td>
                   </tr>
                </tfoot>
              </table>
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
            products: cart.state.products
         }
      },
      mounted() {
         console.log('Component mounted.')
      }
   }
</script>
