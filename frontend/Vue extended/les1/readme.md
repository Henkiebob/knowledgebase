# Getting started
Bij deze college gaan we vue niet gebruiken door vue.js toe te voegen als een javascript bestandje aan html bestand. Maar gaan we vue-cli gebruiken. CLI staat voor Command Line Interface. Dus we gaan Node.js gebruiken om vue te compilen naar javascript, het voordeel hiervan is dat we Objectgeoriënteerd te werk kunnen gaan en javascript kunnen laten compile naar 1 javascript bestand. Als je meer wil weten, na college vragen.
Het compilen doen we met Webpack

We gaan in dit college laravel gebruiken om een website te maken, als je geen ervaring hebt met laravel dan maakt het niet uit want we gaan voornamelijk gewoon met vue bezig, maar we gebruiken laravel als server. Daarnaast heeft laravel vue-cli en webpack ingebouwd.

## Wat hebben we nodig
- composer
- node.js
- git (voor het clonen van de repo)
- php (voor laravel)

> **Weet je niet zeker of je dit hebt:**
> ``` bash
> # Voor composer
> composer -V
> # Voor node.js
> node -v
> # Voor git
> git -- version
> ```

## Clonen
Cloon deze repo in je gewenste map. Deze repo is een fork van het laravel project van vorig jaar.

https://github.com/ericfennis/bierwinkel

*Voor de mensen die vorig jaar Laravel college van Tjerk en marijn hebben gevolgd ik zou niet het oude project erbij pakken want de versies kloppen dan niet meer. Ik heb deze geupdate naar de nieuwste versie van laravel.*

## Server werken krijgen
Laten we eerst zorgen dat we de server werkend hebben en dat we alle packages gedownload hebben om te kunnen beginnen met programmeren.

Pak je favoriete terminal erbij en run dit:
``` bash
composer update
```
En dan dit:
``` bash
npm install
```

Start dan de server:
``` bash
php artisan serve
```
Als het goed is word er een server gestart op **localhost:8000** of **127.0.0.1:8000** en zie je “hoi”.

## Mappenstructuur
``` bash
public
├── css
│   └── app.css   #(Dit is het gecompileerde css bestand)
├── js
│   └── app.js  #(Dit is het gecompileerde javascript bestand)
resources
├── assets
│   ├── js
│   │   ├── app.js     #(Hier schrijf je je javascript code in)
│   │   ├── bootstrap.js    #(Hier staan de packages gedefineerd)
│   │   └── components  #(Map voor je components)
│   │       └── Example.vue
│   └── sass
│       ├── app.scss  #(Hier schrijf je je css/sass code in)
│       └── _variables.scss

```
## Beginnen met Vue
In app.js zie je het bekende stukje code waarmee vue aangeroepen word. Hierin mag je het volgende inzetten onder “el: #app” :
``` js
template: '<h3>This Vue is working</h3>'
```
In welcome.blade.php mag je “Hoi” weghalen en een divje aanmaken met id: app.
``` html
<div id="app"></div>
```
Als je dan naar localhost:8000 gaat dan zie je ……… Niks.
Dat klopt want we moeten de Asset Builder nog runnen (webpack).

In Package.json staan 5 scripts gedefineerd:
``` json
"scripts": {
 "dev": "node node_modules/...",
 "watch": "node node_modules/...",
 "watch-poll": "node...",
 "hot": "node node_modules/...",
 "production": "node node_modules/...",
},
```
De drie belangrijkste om te weten zijn:
- **dev**,  eenmalig compilen in een development omgeving
- **watch**, start een watch functie, en compiled altijd wanneer je een js,css bestand wijzigt.
- **production**, Compiled bestanden voor een productie omgeving. Dus wanneer je klaar bent met het ontwikkelen van je website run je dit script. Dit compressed alle bestanden voor optimale laad tijden.

Wij gebruiken nu even dit command:
``` bash
npm run watch
```
Als je dan gaat checken in de browser zie je als het goed is staan:
```
This Vue is working
```
Nu mag je  `template: '<h3>This Vue is working</h3>'` weer weghalen uit app.js want we gaan een custom element maken.

## Custom elements (single file components)
We gaan nu een custom element aanmaken. Onder het mapje components zien we al een bestandje voor ons aangemaakt: example.vue. Deze mag je dupliceren en een naam geven.
Ik geef hem de naam: `VueHeader.vue`
Belangrijk is dat je naam naam niet gaat benoemen naar een bestaande HTML Element, dit mag namelijk **niet.**

Dan in app.js mag je “Example” veranderen naar je naam van je custom element.
``` js
Vue.component('VueHeader', require('./components/VueHeader.vue'));
```
*Als je niks ziet, even `template: '<h3>This Vue is working</h3>'` weghalen.*

We voegen ook nog even wat html toe in de template:
``` html
<header>
   <nav class="navbar navbar-default navbar-static-top">

              <div class="container">
                 <a href="/" class="navbar-brand">BIERKOERIER</a>
              </div>

        </div>
   </nav>
</header>
```
Als laatste moeten we onze custom element nog plaatsen in html.
``` html
<div id="app">
   <vue-header></vue-header>
</div>
```
**Let op:** In html mag je geen gebruik maken van hoofdletters, dus moet het in kleine letters. Vue kan camelCase, PascalCase en veel manier van variables lezen. Er moet nog wel een streepje tussen anders zie vue het als 1 woord.
