# Vue extended college Part 4

In deze les gaan we dit doen:
- Een winkelmandje maken
- Store maken (State Management)
- Data opslaan in localstorage

We gaan bij deze les een winkelmandje maken doormiddel van State Management. State Manage is een code-pattern die ook vaak toegepast wordt in andere javascript template engines als React en Angular. Bekende State Management Frameworks zijn: Redux, Flux en voor Vue.js heb je Vuex.

Het idee van een State Management is dat je een aparte deel hebt waar je je data kan opslaan, ophalen en functies kan aanroepen etc. In een ontwikkelomgeving waar je een applicatie hebt met componenten zoals wij. Is dit handig als je bij meerdere components bij dezelfde data en functies moet zijn. 

Als je een zeer geavanceerde applicatie moet bouwen raad ik je aan vuex te gebruiken, maar in dit geval gebruiken we dit enkel voor een winkelwagentje, dus gaan we het zelf bouwen. Vue.js ondersteund een simpele vorm van state management.

## State Management
Eerst gaan we nieuwe map aanmaken met een nieuw javascript bestand.
``` bash
├── app.js
├── bootstrap.js
├── components
│   ├── Example.vue
│   └── VueHeader.vue
├── pages
│   ├── Cart.vue
│   └── Home.vue
├── routes.js
└── store
    └── cart.js
```
De map noemen we `store` en het bestand: `cart.js`.

In cart.js gaan we nieuwe variable aanmaken met een object. Vergeet “Export default cart” niet. Anders wordt het niet geëxporteerd.
``` js
var cart = {
   
}
export default cart;
```
Nu gaan we in deze variabele een state object aanmaken waarin we data gaan opslaan:
``` js
state: {
      products: [
         "test"
      ]
   }
```
Voor de test heb “test” toegevoegd.
Nu gaan we de store toevoegen aan `Cart.vue`:
``` js
import cart from '../store/cart.js';
   
   export default {
...
```
We willen de data dat in de store is opgeslagen gebruikt kan worden in de template, dus gaan we de store toevoegen aan de data object:
``` js
data() {
    return {
        products: cart.state.products
    }
},
```
Als we nu in de vue panel kijken, zien we dat test toegevoegd is aan products. Nu gaan we een functie schrijven die producten kan toevoegen aan store.
 
Aangezien we geen functies direct kunnen aanroepen vanuit de template naar de state, gaan we de functie schrijven in `Home.vue`.
 
Deze Methode gaan we AddToCart noemen en moet communiceren met de Cart store. Dus moeten we ook `Cart.js` importeren in `Home.vue`.
``` js
import cart from '../cart.js';
```
Nu gaan we deze methode(functie) toevoegen:
```js
addToCart(product) {
    var products = cart.state.products;
    var foundProduct = false;
    //Doorzoek alle producten in winkelwagen
    for (var i = 0; i < products.length; i++) {
        // als product ID gelijk is aan toegevoegde product ID, voeg nieuwe toe.
        if (products[i].id === product.id) {
            var newProduct = products[i];
            // totaal aantal van dat product +1
            newProduct.quantity++;
            // werk de winkelwagen bij
            cart.setProduct([i], newProduct);
            //Als product gevonden wordt, stopt de rest van de functie
            foundProduct = true;
            break;
        }
    }
    // Als het product niet gevonden word nieuw product toevoegen
    if (!foundProduct) {
        // nieuw variabele quantity vor het bijhouden van de aantallen
        product.quantity = 1;
        // voeg product toe
        cart.addProduct(product);
    }
}
```
Deze functie gebruikt nog twee functies in de store namelijk: `setProduct()` en `addProduct()`, deze moeten we nog schrijven. De rede dat we deze appart hebben geschreven is dat we deze later ook kunnen gebruiken om producten weer af te trekken en te verwijderen. Ook is dit straks handig voor de localstorage.
Deze addToCart() functie zou ook kunnen geschreven worden in de store, is maar net wat je wil in je applicatie.
 
Voeg deze twee functies toe aan je Cart store:
``` js
setProduct (number,value) {
      console.log('setProduct triggered '+this.state.products);
      // verander de quantity van het product
      this.state.products[number] = value;
   },
   addProduct (value) {
      console.log('addProduct triggered '+this.state.products);
      //voeg nieuwe product toe
      this.state.products.push(value);
   },
```
Om te checken of de addToCart functie werkt, gaan we buttons toevoegen aan de de producten. heel simpel:
``` html
<button class="btn btn-primary product-button" type="button" @click="addToCart(product)">In winkelwagen</button>
```
vergeet niet “test” weg te halen uit je store.
 
We zien nu dat er producten worden toegevoegd aan de cart in de vue panel.
 
Om het in de cart zichtbaar te maken kun je deze html toevoegen:
``` html
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
```

## Localstorage
Alleen het probleem is nu als je je pagina herlaad, zijn al je producten weg. Dit kunnen we oplossen door localstorage.

Localstorage is bedoeld voor het opslaan van data wat je lokaal wilt opslaan en later wil te kunnen hergebruiken. Je moet je wel bedenken, dat als mensen hun browser cache verwijderen dat vaak ook deze data word verwijderd. In dit geval voor het gebruiken van winkelwagentje is het prima.
localstorage werkt met twee parameters: Een key en een value:
Je kunt data opslaan en je kunt data ophalen. heel simpel dus.
```js
localStorage.setItem(key,value); //opslaan
localStorage.getItem(key,value); //ophalen
```
Wij willen elke keer als er iets wordt toegevoegd de data opgeslagen word. Voor naam van de key gebruiken we zo logisch mogelijk: `“Cart”`.
Dit mag je toevoegen onderaan `setProduct()` en `addProduct()`.
```js
localStorage.setItem("cart", this.state.products);
```
Als we dit nu uittesten en we kijken in onze localstorage van de browser dat zien we dat er dit staat.
```
[object Object],[object Object],[object Object],[object Object]
```
 
Dit is niet wat we willen, dit komt omdat localstorage alleen een string accepteert. Voordat een javascript object een string wordt moeten we de data eerst omzetten naar een string. Dat doen we met deze functie:
``` js
localStorage.setItem("cart", JSON.stringify(this.state.products));
```
Als we de localstorage nu checken, zit er data in.
Alleen als bij het refreshen van de data wordt data nog niet teruggeplaatst. Dit doen we door een aparte functie aan te maken en die in de state aan te roepen.
```js
// Functie ophalen van localstorage
function fetchLocalStorage(key) {
   // kijken of localstorage gevuld is met data van de cart.
   if(localStorage.getItem(key)) {
     //stuur data terug
      return JSON.parse(localStorage.getItem(key));
   } else {
      // is het leeg, stuur lege array terug
      return [];
   }
}
```
voeg dit toe aan de state:
``` js
products: fetchLocalStorage("cart"),
``` 
Als we nu herladen zien we dat het werkt.

## Opdracht & Extra
- In het tabel wordt de prijs nog niet opgeteld, zorg ervoor dat de prijs opgeteld word.
- **Extra:** Maak een bestelpagina en zorg dat het wordt opgeslagen in de server.
