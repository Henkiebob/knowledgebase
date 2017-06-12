<template>
   <header>
  <nav class="navbar navbar-default navbar-static-top">

             <div class="container">
                <router-link to="/" class="navbar-brand">BIERWINKEL</router-link>
                <router-link to="/cart" class="navbar-right navbar-text">Winkelbierkrat</router-link>
             </div>
  </nav>
</header>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
