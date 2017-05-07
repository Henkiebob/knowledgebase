# Les 1
Laten we beginnen met implementeren van Vue in een doodnormale HTML pagina, zo kan je zien wat voor coole dingen Vue.js allemaal te bieden heeft!

We beginnen dus met een stukje HTML, maak een `index.html` bestand aan en knal dit erin.

```html
<!DOCTYPE html>
<html>
    <head>
        <title>Vue wat is databinding??</title>
    </head>
    <body>

    </body>
</html>

```

Prima, om Vue.js te downloaden kan je simpelweg naar  https://vuejs.org/v2/guide/ gaan, hier staat ook alle documentatie beschreven over de principes die we vandaag gaan gebruiken.

We gaan Vue.js via een CDN inladen, het linkje van de CDN kan je vinden op de bovenstaande site, maar voor de luie mensen is dat: https://cdnjs.cloudflare.com/ajax/libs/vue/2.3.0/vue.js

Dit gaan we voor  het sluiten van de `<body>` tag  inladen met een script tag dus als volgt:

`<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.3.0/vue.js"></script>`

Vue.js kan je binden aan een stukje HTML, dat kan een div zijn of een html tag zoals de body, Vue.js moet weten waar moet ik gaan luisteren? Dit ga je later ook wel tegenkomen met Vue componenten.

Laten we dit Vue.js gaan vertellen, laten we onder de script tag die je net geplaatst hebt een nieuw stukje script openen.

```javascript
<script>
  new Vue({
    el: '#root',
    data : {
      message : 'Hello World'
    }
   })
</script>
```        


We maken een instantie van het Vue object en binden deze aan een ID genaamd root (dit mag alles zijn wat je wil) en we stellen een nieuw data attribuut in genaamd `message` Zoals alle programmeer voorbeelden, willen we eerst hallo zeggen tegen de wereld.

Dus gooi dit tussen je body tags:

```html
<div id="root">
  <p>Het bericht is: {{ message }}
 </div>
```

Nu komt het leuke gedeelte, wat nou als we dit bericht willen veranderen? Normaal gezien zou je met Javascript het element op moeten zoeken en de value veranderen, wij gaat dit doen met data-binding, we gebruiken hier het v-model tag om onze message te koppelen aan deze input tag.

Knal dit boven je bericht!

```html
  <input type="text" id="input" v-model="message">
```

Bam, dikke data-binding, alles wat in de input komt, staat ook direct in de HTML, cool toch?

# Les 2
Voor deze les gaan we ook bezig met de Vue devtools, wanneer je in Vue.js gaat ontwikkelen zijn deze essentieel.

 [Vue.js devtools - Chrome Web Store](https://chrome.google.com/webstore/detail/vuejs-devtools/nhdogjmejiglipccpnnnanhbledajbpd?hl=en)

Installeer vue-devtools -> manage extensions -> allow file-urls.
Hiermee kan je ook lokaal bezig met devtools.

## Lijstje maken

We gaan een lijst maken, hiermee kan je goed zien wat voor coole template mogelijkheden Vue.js allemaal heeft.

We beginnen hiermee.

```html

<!DOCTYPE html>
<html>
    <head>
        <title>Vue lijstjes maken!</title>
    </head>
    <body>
        <div id="root">

        </div>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.3.0/vue.js"></script>
     </body>
</html>

```

Ok laten we weer een nieuw Vue object maken en deze aan root koppelen, we voegen ook alvast een array met namen toe, met Vue doe je dit in een bijbehorend data object.

```javascript
<script>
	new Vue({
	    el: '#root',
	    data : {
	        names : ['Henk', 'Eric', 'Dirk', 'Tjerk', 'Renze']
	    },
	})
</script>

```

Vervolgens kunnen we met de v-for syntax een lijstje maken, we zeggen voor elke name binnen de names array, maak een li item en plak hier de naam tussen, wanneer je data vanuit Vue wil gebruiken gebruik je de moustache syntax.{{ name }}

```html
<ul>
    <li v-for="name in names">{{ name }}</li>
</ul>
```
Als het goed is heb je nu een lijstje met namen!
Laten we nu deze data manipuleren met de Vue.js plugin van Chrome.
Wanneer je op het root component klikt zie je de data die daaraan gekoppeld is, dus onze namen.

Je kan nu direct in de console een naam toevoegen door het volgende commando uit te voeren in de console. ($vm0 wordt automatisch gekoppeld, zodat we er dingen mee kunnen doen)

`$vm0.names.push('nieuwe naam');`

Zoals je kan zien, de naam komt er direct bij te staan.
Maar laten we dit maken met een input veld. Zet dit boven het lijstje met namen.

Je zit hier een input waaraan we de model `newName` hebben gekoppeld, dit gaan we afvangen. Het mooie aan Vue is dat erg makkelijk evenementen kunnen koppelen aan onze html, we maken hier een button met een `@click` functie, hier kan je alle standaard Javascript evenementen meer defineren, we zeggen nu wanneer je op dit knopje klikt voer dan de methode AddName uit, deze methode moeten we nu nog gaan maken.

```html
<input type="text" v-model="newName">
<button @click="addName">Voeg een naam toe</button>
```

Laten we beginnen met een simpele alert, zodat we kunnen zien dat het werkt. Voeg na het stukje data een blokje methods toe, let goed op de `,` deze methode noemen we addName.

```javascript
<script>
new Vue({
 	el: '#root',
    data : {
    	newName : '',
    	names : ['Henk', 'Eric', 'Dirk', 'Tjerk', 'Renze']
    },
    methods: {
        addName(){
            alert('Hallo!');
        }
    }
})
</script>
```

Ok, top we zien een alert, laten we nu hetzelfde doen wat we in de console deden dus.

```javascript
this.names.push(this.newName);
```
En bam, je hebt een nieuwe naam, je kan hetzelfde doen met een keydown.enter dus wanneer je op enter drukt, heb je een nieuwe naam.

```html
<input type="text" v-model="newName" @keyup.enter="addName">
```

Je kan de code nog opschonen door het veld leeg te maken wanneer je een nieuwe hebt toegevoegd.

`this.newName = "";`

