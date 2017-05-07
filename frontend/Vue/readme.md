# Les 1 - Data binding
Laten we beginnen met implementeren van Vue in een doodnormale HTML pagina, zo kan je zien wat voor coole dingen Vue.js allemaal te bieden heeft!

We beginnen dus met een stukje HTML, maak een `index.html` bestand aan en knal dit erin.

```html
<!DOCTYPE html>
<html>
    <head>
        <title>Vue wat is databinding??</title>
    </head>
    <body>
		<!-- hier komt nog wat !-->
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

# Les 2 Templating en Methods
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

Je kan de code nog opschonen door het veld leeg te maken wanneer je een nieuwe hebt toegevoegd, voeg dit toe aan je addName() methode.

`this.newName = "";`

## Les 3 Computed Properties

We gaan een Todo lijstje maken, hiervoor gaan we gebruik maken van computer properties, dat betekent we gaan de data die er in onze applicatie wordt gebruikt aanpassen aan onze wensen, zie het zo, wanneer je data wil gaan laten zien zoals: "Welke taken staan er op todo? en welke zijn klaar?" Dan moet je de Taken gaan manipuleren of filteren zodat alleen de gedane taken worden getoond, deze logica zit ingebouwd in Vue.

We starten met een stukje html en een taken lijstje, onze taken hebben nu een extra attribuut, namelijk completed hiermee kunnen we straks gaan filteren.

```html
<!DOCTYPE html>
<html>
    <head>
        <title>Vue takenlijst met computed properties</title>
    </head>

    <body>

        <div id="root">
            <h1>Todo</h1>
            <ul>
                <li v-for="task in tasks">
                    {{ task.description }}
                </li>
            </ul>
        </div>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.3.0/vue.js"></script>
        <script>

        new Vue({
            el: '#root',
            data : {
                tasks : [
                    { description: 'Boodschappen doen', completed: true },
                    { description: 'Afwassen', completed: true },
                    { description: 'Koken', completed: false },
                ]
            }
        })
        </script>
    </body>
</html>
```

Laten we de computed property toevoegen, we kunnen deze zelf een naam geven, wil de huidige tasks filteren, zodat ik alleen de taken te zien krijg die al gedaan zijn. Ik gebruik hiervoor de standaard Javascript filter functie, maar wil in de nieuwe Javascript syntax, dit werkt dus niet in oude browsers maar dit kan je altijd herschrijven.

Voor referentie: [Array filter documentatie](https://developer.mozilla.org/nl/docs/Web/JavaScript/Reference/Global_Objects/Array/filter)

```javascript
computed: {
    completedTasks() {
        return this.tasks.filter(task => task.completed);
    },
}
```

Dus laten we een onderscheid maken, pas de html aan naar het volgende:

```html
<h1>Done</h1>

<li v-for="task in completedTasks">
    {{ task.description }}
</li>

```

Cool, laten we het zelfde doen voor taken die nog niet klaar zijn.
Doodsimpel eigenlijk.

```javascript
incompleteTasks() {
     return this.tasks.filter(task => ! task.completed);
}
```

Daarna krijgen we dus:

```html
<h1>Todo</h1>

<li v-for="task in incompletedTasks">
    {{ task.description }}
</li>


<h1>Done</h1>

<li v-for="task in completedTasks">
    {{ task.description }}
</li>

```

Top, maar hoe gaan we nu een taak afronden? Nou als het goed is weet je al hoe we een methode moeten maken.

Laten we eerst maar even een checkbox toevoegen aan de html. Zit dit in de v-for nog een mooi voorbeeld, we kunnen de data aan elkaar koppelen, dus de checkbox is gekoppeld aan de data die wij binnen krijgen, de checkbox is automatisch aangevinkt wanneer de task `completed = true` heeft.

```html
    <input type="checkbox" v-model="task.completed"/>
```

En klaar, je takenlijst werkt! Probeer anders een een tekst te tonen wanneer er geen taken meer zijn, hint je hebt hiervoor een `v-if` statement en een `.length` functie nodig.

Of combineer de vorige opdracht zodat je ook taken kan toevoegen!
