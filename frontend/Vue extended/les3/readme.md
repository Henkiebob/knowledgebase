# Vue extended college Part 3

In deze les gaan we dit doen:Router toevoegen
- Router toevoegen
- Routes aanmaken.
- Pagina toevoegen

Vorige keer hebben met vue en laravel een vue app gemaakt die data ophaalt uit de server en die laat zien op de pagina. En ik gaf jullie opdracht een zoekmachine te maken.

## Zoekmachine
Dit is mijn javascript in `Home.vue`:
``` js
computed: {
    // Deze functie zoekt op producten
    filteredData: function() {
        var results_array = this.searchResults,
            searchString = this.searchString;
        // Als de zoekstring leeg is stuur de products array terug
        if (!searchString) {
            return this.products;
        }
        // We willen dat zoek machine niet hoofdletter gevoelig is, dus maken we alles kleine letters.
        searchString = searchString.trim().toLowerCase();

        // Als zoekstring is ingevuld
        if (searchString) {
            //filter functie
            results_array = this.products.filter(function(product) {
                // als productnaam in kleine letters gelijk is aan de searchString stuur product terug.
                if (product.name.toLowerCase().indexOf(searchString) !== -1) {
                    return product;
                }
            })
        }
        //return product
        return results_array;
    },

},
```
En dit is mijn html in `Home.vue`:
``` html
<section id="search-engine" class="jumbotron" :class="{ filled: searchString.length !== 0 }">
    <div class="container">
        <h1 class="">Bier&#127866;</h1>
        <div class="input-group">
            <input type="text" class="form-control" v-model="searchString" placeholder="Zoek bier...">
            <span class="input-group-btn">
              <button class="btn btn-primary" type="button">Geef!</button>
            </span>
        </div>
    </div>
</section>
```
En ik heb de for loop functie veranderd van products naar filteredData:
``` html
<div class="product col-md-3 col-sm-6" v-for="product in filteredData">
```
Kort uitgelegd hoe ik het heb gedaan:
> Ik heb een html input aangemaakt met een v-model naar een nieuwe dataobject searchString. 
> Alles wat hier in word gevuld word toegevoegd aan de dataobject.
>
> In javascript heb ik een computed functie gemaakt waar het zoeken word gedaan in de productsArray dataobject. Hierin stuurt hij alleen > producten terug als er gezocht word, anders stuurt de functie gewoon de productsArray terug.
> 
> V-for die we eerder hebben aangemaakt, heb ik de products veranderd naar filteredData de functienaam van de filter Computedfunctie.

## Vue Router
Vue-router is een module die gebruikt wordt voor het terugsturen van de juiste template van route (het pad). Vue router is een een module van Vue zelf en werkt dus heel goed. Je kunt het ook zelf bouwen, maar deze module is aardig compleet en werkt ook met de browser extentie van chrome.

### Router toevoegen aan Vue
Voor het installeren van vue-router gaan we NPM gebruiken. 
Voer deze command uit in je terminal:
``` bash
npm install --save vue-router
```
NPM installeerd vue-router nu in je `Node_modules`
Om vue router te gebruiken in ons project moeten de vue-router linken met onze javascript.
Dus moeten we deze regels toevoegen boven aan in onze `App.js`:
``` js
import VueRouter from 'vue-router';
 
Vue.use(VueRouter);

```
`Vue.use` is een functie dat Vue weet dat dit een plugin is.

In onze html in welcome.blade.php staat nog onze Home component die gaan we vervangen door de router-view tag, zodat de router bepaald wat er laten zien word.
``` html
<div id="app">
   <vue-header></vue-header>
   <router-view></router-view>
</div>
```

Nu we de module hebben toegevoegd kunnen we een nieuwe Router instance aanmaken.
``` js
const router = new VueRouter({
 
});
```
De router moeten we ook nog toevoegen aan de Vue instance, dan kunnen we Route object bekijken in de chrome extentie:
``` js
const app = new Vue({
    el: '#app',
    router
});
```
*Als het goed is zien we nu alleen een header. Dit komt omdat we nog geen routes hebben toegevoegd aan de router.*

We kunnen de routes object direct in de Router instance zetten maar dat is lelijk en maakt de code onoverzichtelijk dus gaan we een aparte javascript bestand aanmaken voor alle routes.

*Aangezien webpack toch alles voor ons compiled maakt het de website niet slomer. Je kan zoveel structuren en linken als je wil.* 

Maak een `Routes.js` aan in js folder. dezelfde map als `app.js`. 
Daarin mag je deze javascript plakken:
``` js
export default 
[
    {
    	path: '*',
    	name: 'Error 404',
      meta: {
        title: "Page not Found - Bierwinkel"
      },
    	component: { template: '<main><p>Page not found</p></main>' }
    }
];
```
Als je nu je browser checkt, dan zie je als het goed is: “Page not found”.
Dat klopt want de enige route die toegevoegd is 404 met het path “*”.
Deze laten we staan want die handeld 404 request af.
### Pagina’s toevoegen aan de router.
We gaan nu home bovenaan toevoegen aan de routes:
``` js
{
     path: '/',
     name: 'Home',
     meta: {
      title: "Homepagina - Bierwinkel"
     },
     component: require('./pages/Home.vue')
  },
```
**Let op!**: *Dit moet boven de 404, javascript leest van boven naar onder.*
> Uitleg opties in een route:
> - **Name**: De naam van de Route. 
> - **Meta**: Dit is voor meta data, hierin kan je bijvoorbeeld parameters. Wij slaan hier nu de pagina titel in op, deze kunnen we straks gebruiken om de titel van de pagina te veranderen.
> - **Component**: Hierin geef je aan welke component de router moet weergeven.

Als je nu je browser refresh zie je als het goed is de homepagina weer.
We gaan nu een pagina aanmaken voor de winkelwagen voor ons pils.

Dupliceer example.vue naar de map Pages. 
En geef het de naam: `Cart.vue`

Om de pagina Cart te zien gaan we cart ook toevoegen aan de routes:
``` js
{
     path: '/cart',
     name: 'Cart',
     meta: {
      title: "Bierkrat - Bierwinkel"
     },
     component: require('./pages/Cart.vue')
  },
```
Als het goed is zie je nu example component in je scherm.
 
We willen dat mensen naar hun shopping cart kunnen klikken. Dus gaan we een link toevoegen aan de header:
``` html
<router-link to="/cart" class="navbar-right navbar-text">Winkelbierkrat</router-link>
```
Router link is de tag die Vue-router gebruikt voor het linken naar pagina’s. Deze naam kun je ook veranderen als je wil. Zie Vue-router documentatie.
 
Ook willen we dat mensen op het logo kunnen klikken om weer terug te gaan.
Dus gaan we de a tag veranderen naar `<router-link>`:
``` html
<router-link to="/" class="navbar-brand">BIERWINKEL</router-link>
```
### Extra
We hadden bij de meta-tag een title meegegeven, deze kunnen we gebruiken voor het veranderen van de HTML document title. Voeg deze functie toe aan je app.js:
``` js
router.beforeEach((to, from, next) => {
  document.title = to.meta.title
  next()
})
```


