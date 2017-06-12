# Vue extended college Part 2

In deze les gaan we dit doen:
- Home pagina maken
- Api call doen
- Api data binden aan de pagina (producten laten zien).
- Opdracht: Zoekmachine maken.

## Homepagina maken
We gaan deze college nog niet werken met een router dus doen we het eerst met een simpele component.
In de map “js” onder resources/assets maken we een nieuwe map aan “pages”
Hierin dupliceren we even de het bestandje Example.vue uit de map components en hernoemen het naar Home.vue
```bash
js
├── app.js
├── bootstrap.js
├── components
│   ├── Example.vue
│   └── VueHeader.vue
└── pages
    └── Home.vue    ←-- hier deze
```
Dan voegen we home toe als component, onder de vue-header component.
```js
Vue.component('Home', require('./pages/Home.vue'));
```
Voor de tijdelijk opmaak voegen we deze html toe:
``` html
<main>
   <section id="results">
      <div class="container">
         <h3>Bier</h3>
      </div>
   </section>
</main>
```
Daarnaast niet te vergeten `<home>` toevoegen aan de HTML.
``` html
<div id="app">
   <vue-header></vue-header>
   <home></home>
</div>
```
## API
Ik heb voor jullie alvast een api geschreven. Deze api stuurt bij een GET request JSON data terug. In deze data zitten producten met random gegenereerde namen. Als je dit wil aanpassen kan dat hier:

http://localhost:8000/products
*Hier kun je ook zelf producten toevoegen als je wil.*

Voor het ophalen van data gebruiken we deze link:
http://localhost:8000/api/products
*Tip: Gebruik chrome extensie: json Formatter *

### API toevoegen aan Vue
In laravel maken ze gebruik van de http-client Axios. Die hebben ze standaard ingebouwd. Je kan ook een andere gebruiken als je wil, jQuery heeft er ook 1 maar ondersteund volgens mij niet alle request methodes. Axios ondersteund ieder geval alle request methodes: GET, POST, PUT, DELETE etc.

Laten axios toevoegen aan onze Home.vue.
Hiervoor gaan we een nieuwe methode schrijven en die noemen we `getProducts()`:
``` js
export default {
        mounted() {
            console.log('Component mounted.')
        },
        methods: {
           getProducts() {

           },
        }
    }
```
Omdat we de data graag willen gaan binden met de DOM (HTML) moeten we data kunnen opslaan in een data object.
Dus die gaan we aanmaken:
``` js
export default {
    data() {
        return {
            products: [],
        }
    },
...
```
Het toevoegen van data object in .vue templates zien er iets anders uit dan binnen de Vue functie zelf. In .vue templates is data een functie en return die de data.

Als we nu in Chrome extensie kijken, zien we dat products is toegevoegd

Nu gaan we de Api call maken:
``` js
getProducts() {
    axios.get('/api/products').then(response => this.products = response.data);
},
```
Als axios een response terug krijgt dan voegd axios response.data toe aan this.products.

Nu wordt alleen de methode(functie) nog niet aangeroepen.
We willen dat voor dat component wordt gemount dat de api-call gedaan is. Hiervoor hebben we hooks, Vue kent verschillende hooks: Created, Mounted, Updated en Destroyed.

Meer weten: https://vuejs.org/v2/guide/instance.html#Lifecycle-Diagram

We gebruiken voor de API call the Created hook:
``` js
created () {
     this.getProducts()
},
```
Als we nu in Chrome extensie kijken, zien we dat de data is toegevoegd aan vue.
## Data binden
Als jullie het nog weten van vorige 1e college dan mag je het zelf proberen.

Ik doe het hier nog een keer voor.
We gaan v-for gebruiken om de data toe te voegen:
``` html
<section id="results">
   <div class="container">
      <div class="product" v-for="product in products">
         {{ product.name }}
      </div>
   </div>
</section>
```
Voor een beetje stijling voeg ik er nog wat bootstrap classes toe:
``` html
<div class="product col-md-3 col-sm-6" v-for="product in products">
   <div class="product-body thumbnail">
      <div class="product-name caption">{{ product.name }}</div>
      <div class="product-price">&euro;{{ product.price }}</div>
   </div>
</div>
```
> ## Opdracht
> Bouw een zoekmachine!
> **Tip**: Gebruik de computed functie.
