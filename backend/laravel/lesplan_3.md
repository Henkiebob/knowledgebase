#Les 3 (CRUD)
Create, Read, ~~Update, Delete~~

#Producten aanmaken

We hebben nu een producten pagina, maar vol met 'nep' producten, wij willen dit uiteindelijk ook zelf kunnen aanmaken, dus maken we een nieuwe route aan deze geven we ook een naam (maar waarom?) dat zie je zo!

Pas eerst de bestaande route aan, geeft deze een naam.

```php
Route::get('/products', 'ProductsController@index')->name('products');
```

Maar waar gaan we deze route gebruiken? Misschien wel handig om een link toe te voegen aan het huidige "menu" (naast login en logout).

Ga vervolgens naar `resources/views/app.blade.php` en voeg daar het volgende menu item aan het huidige menu. Hier staat al een hoop standaard code waaronder code die checkt of je al ingelogt bent ja of nee (mega handig).

Voeg deze regel toe, in de @else van de authenticatie check.

```html
<li><a href="{{ route('products') }}">Producten</a></li>
```

Een link naar onze producten pagina!
Pas het bestand `index.blade.php` aan in het mapje `resources/views/products`

```php

<div class="container">
    <h1>Bierkoerier Producten</h1>
    <div class="panel panel-default">
        <div class="panel-heading">Acties</div>
            <div class="panel-body">
                <a href="{{route('create-product')}}" class="btn btn-primary">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Product Toevoegen
                </a>
        </div>
    </div>
    <table class="table table-bordered" style="background-color: white">
        <tr>
            <th>#</th>
            <th>Naam</th>
            <th>Beschrijving</th>
            <th>Status</th>
        </tr>
        @foreach ($products as $product)
        <tr>
            <td>{{ $product->id }}</td>
            <td>{{ $product->name }}</td>
            <td>{{ $product->description }}</td>
            <td>
                @if($product->status == 0)
                <span>Niet beschikbaar</span>
                @else
                <span>Beschikbaar</span>
                @endif
            <td>
        </tr>
        @endforeach
    </table>
</div>
```

Pas vervolgens de route file aan om de nieuwe link af te vangen.

```php
Route::get('/products/new', 'ProductsController@create')->name('create-product');
```

Zoals je net zag staat de homepagina staat nu vol met Laravel poep, dat willen we niet meer! Ga naar `welcome.blade.php` maak deze leeg, en knal de volgende code erin.

```php
@extends('layouts.app')
@section('content')

	<div class="container">
		<h1>Welkom!</h1>
	</div>

@endsection

```

Nu zie je de voordelen van Blade, dankzij de @extends functie kunnen je erg gemakkelijk templates van elkaar laten extenden. Dit betekent dat alles wat in `app.blade.php` staat, om de section @content heen wordt geplaatst. Dus ook het menu!

Ga vervolgens naar de homepagina en check je werk!

We gaan logica maken voor het toevoegen van producten.
Zet de volgende functie in de `ProductsController`

```php
  public function create() {
    return view('products.new');
  }
```

Maak een view aan in `/resources/views/products/new.blade.php`
Zet het volgende in dit bestand:

```php

@extends('layouts.app')
@section('content')
<div class="container">
	<h1>Product admin</h1>
	<form method="post">
	    <div class="form-group">
	        <label for="name">Naam</label>
	        <input type="text" name="name" id="name" class="form-control"/>
	    </div>
	        <div class="form-group">
	        <label for="description">Beschrijving</label>
	        <textarea name="description" id="description" class="form-control"/></textarea>
	    </div>
	    <div class="form-group">
	        <label for="price">Prijs</label>
	        <input type="number" name="price" id="price" class="form-control"/>
	    </div>
	    <div class="form-group">
	        <div class="checkbox">
	            <label for="status"><input type="checkbox" value="1" name="status" checked>Actief</label>
	        </div>
	    </div>
	    {{ csrf_field() }}
	    <input type="submit" name="submit" class="btn btn-succes" value="Opslaan">
	</form>
</div>
@endsection

```

We gaan eerst een route toevoegen om onze post af te vangen en het nieuwe product op te slaan.

```php
Route::post('products/new', 'ProductsController@store');
```

Maak de volgende functie in de `ProductsController`

```php

public function store(Request $request) {

	$product = new Product;
	
	$this->validate($request,
	[
	    'name' => 'required|max:255',
	    'price' => 'required',
	    'description' => 'max:255',
	    'status' => 'required',
	]);
	
	$product->name = $request->name;
	$product->price 	= $request->price;
	$product->status = $request->status;
	$product->description = $request->description;
	$product->save();
	
	return redirect('/products');
}

```

Maar wacht we zien nog geen errors wanneer je niks invult!
Zet dit stukje code in je `new.blade.php` bestand om de errors te zien!

```php
@if (count($errors) > 0)
     <div class="alert alert-danger">
         <ul>
             @foreach ($errors->all() as $error)
                 <li>{{ $error }}</li>
             @endforeach
         </ul>
     </div>
 @endif
```

Als het goed is kunnen we nu producten toevoegen en zien wij deze verschijnen in ons tabel! Daarnaast worden ze gevalideerd!

*Opdracht:*
Maak de CRUD af! Dus zorg voor een edit actie van producten en delete actie!


