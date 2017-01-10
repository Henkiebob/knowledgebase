#Lesplan 5


##locatie ophalen
Ga naar de create order template!
`resources/views/orders/create.blade.php`

Wij moeten hier een locatieknop toevoegen! Zodat we de latitude en de longitude meesturen met ons formulier. Er zijn meerdere wegen naar Rome, vandaag nemen wij de snelste weg (dus vergeef het hoge snippet gehalte)

Plaats de volgende velden ergens tussen de `<form>` tags, dit zijn hidden input fields, dat betekent de gebruiker zal deze niet zien*

*Deze zijn wel aan te passen door de gebruiker met een HTML inspector, gebruik dit dus niet voor data die eigenlijk gemanipuleerd mag worden, daarnaast check en valideer altijd alle input.

```html
    <input type="hidden" id="latitude" name="lat" value="">
    <input type="hidden" id="longitude" name="lon" value="">
```

Plaats vervolgens de locatieknop in de html! (maakt niet echt uit waar)

```html
  <button type="button" id="bierbutton" class="btn btn-default">
   <i class="fa fa-map-pin" aria-hidden="true"></i> Locatie ophalen!
  </button>
```

Plaats ook de volgende div ergens in het bestand, waar jij de kaart wil!

```html
<div id="map"></div>
```

Plaats het volgende stukje script onderaan `create.blade.php`
Wij hier nog aanpassingen voor doen in onze  `app.blade.php` no worries. (Google maps vereist tegenwoordig een API key, hier heb je 1tje voor dit college)

```html
@section('scripts')
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBL2n-x__Jgv2oaK6lFZ92gc59nHp8kzQM"></script>
<script src="/js/orders/location.js"></script>
@endsection
```

Ga nu naar het bestand `app.blade.php` en pas het volgende aan.

```html
<!-- Gooi deze ergens onder de andere stylesheets !-->
<link href="/css/custom.css" rel="stylesheet">

<!-- deze moet voor het sluiten van de <head> tag !-->
<script src="https://use.fontawesome.com/5eaca6b667.js"></script>

<!-- deze moet bij het kopje scripts !-->
@yield('scripts')
```

Maak een mapje aan in `public/js/` genaamd `orders` maak daarin vervolgens het bestand `location.js`


## Locatie functie maken
Ga naar dit bestand en plaats daar deze code

```js
$( document ).ready(function() {
  $('#bierbutton').click(function() {
      alert('hoi');
  });
});
```

Maak de volgende functie buiten de document ready

```js
function geoFindMe() {
  var icon = $('<i/>', {
      class: 'fa fa-spinner fa-pulse fa-fw'
  });

  var span = $('<span/>', {
      id: 'loader',
      class: 'sr-only',
      text: 'Loading...'
  });

  $('#bierbutton').html(icon, span);
  $('#span').html(icon);

  if (!navigator.geolocation){
    alert("Geolocation werkt niet, https? of juiste API key?");
    return;
  }
  
  navigator.geolocation.getCurrentPosition(success);
}

function success(position) {
	var lat  = position.coords.latitude;
	var lon = position.coords.longitude;
	console.log(lat, lon);
	$('#bierbutton').html('gevonden!');
}

```

Roep vervolgens deze functie aan vanuit je click dus veranderd de alert naar de functieaanroep

```js
$( document ).ready(function() {
  $('#bierbutton').click(function() {
      GeoFindMe();
  });
});
```

Klik op de knop, kijk nu in je console, als het goed is zie je daar al lat en long staan!


Maak de volgende functie aan!

```js
function initMap(lat, lon) {
  var pos = {lat: lat, lng: lon};
  var map = new google.maps.Map(document.getElementById('map'), {
    zoom: 4,
    center: pos
  });

  var infoWindow = new google.maps.InfoWindow({map: map});

  infoWindow.setPosition(pos);
  infoWindow.setContent('Bier hier!');
  map.setCenter(pos);
  map.setZoom(17);

  var marker = new google.maps.Marker({
    position: pos,
    map: map
  });

  map.panTo(marker.position);
  infoWindow.setPosition(pos);
}
```

Deze gaan we aanroepen wanneer ook daadwerkelijk een locatie hebben, dus vanuit de succes functie:

```js
initMap(lat, lon);
```

Maak een bestand aan in `public/css/` genaamd `custom.css`
En zet het volgende erin:

```css
#map {
 height: 350px;
 position: relative;
 overflow: hidden;
}
```

Voeg de volgende functie toe aan ons `location.js` bestand.

```js
function addToForm(lat, lon){
  $('#latitude').val(lat);
  $('#longitude').val(lon);
}
```
En zet de aanroep van deze functie onder de aanroep van de initMap met dezelfde parameters.

```js
addToForm(lat, lon);
```

Als het goed is, kunnen wij nu een locatie meesturen aan ons formulier!

#API Maken
De stappen om dit project uit te breiden met een API zijn in Laravel erg simpel, er is al een onderscheid gemaakt in de routes, je hebt `web.api` voor je webrequests en `api.php` voor je api requests, alle requests die daar binnenkomen worden automatisch afgevangen op de volgende url bijvoorbeeld: bierkoerier.dev/api/products

Zet dit in je `api.php`

```php
Route::get('/products', 'ApiController@listProducts');
```

Maak vervolgens een Apicontroller aan.

	php artisan make:controller ApiController

Bestand helemaal vervangen

```php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Requests;
use App\Product;

class ApiController extends Controller
{
    public function listProducts() {
        return Product::all();
    }
}
```

Het mooie van Laravel is dat wanneer je een object direct returned, automatisch een JSON response terugkomt, supersnel!

Ga naar bierkoerier.dev/api/products voor JSON!

#Database seeding

We hebben in dit college ook testdata behandeld met faker, wij gaan hiervoor een seeder aanmaken zodat we het lekker snel kunnen uitvoeren.

Ga naar `database/seeds/DatabaseSeeder.php` en zet de volgende code tussen de Run functie

```php
      App\User::create([
        'name' => 'marijn',
        'email' => 'marijn.de.vries@nhl.nl',
        'password' => bcrypt('marijn'),
        'remember_token' => str_random(10),
      ]);

      factory(App\Product::class, 5)->create();
```
Haal alle test data weg en begin met nieuwe neppe data.

	php artisan migrate:refresh --seed