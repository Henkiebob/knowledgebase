#Les 2

We gaan eerst wat basis commando's langs! Elk commando heeft een handleiding ingebouwd, super handig vooral als je nieuwe commando's gaat gebruiken. Wil je weten wat een commando kan?

	man cd <- man staat voor manual
	cd <- change directory
	cd ../ <-- een enkel mapje terug
	
Pro tip: Gebruik tab tijdens het gebruik van cd, dan hoef je niet de volledige mapnaam te kennen ;)

	ls <- list
	ls -lah <- met schrijfrechten en andere foefjes
	mkdir <-- maak een mapje
	touch hoi.txt <-- maak een bestand
	rm hoi.txt <-- verwijder bestand
	rm -rf mapje <-- haal een mapje weg (rf staat voor recursief en force)
	rm -rf / <-- de bekende linux grap, doe dit nooit.
	

Ga naar je project 
	
	cd ~/sites/bierkoerier

![ERD](ERD.png)

- Forgein Keys
- Primary Key
- Waarom dit veld type?
- Waarom deze relaties?

We gaan een route maken, in het volgende bestand:
`routes/web.php`

	Route::get('/products', 'ProductController@index');

Ga naar 
	
	bierkoerier.dev/products of localhost:8000/products
	
We gaan controller maken. Voer dit uit in je command line.

ProductController

	php artisan make:controller ProductsController

Ga naar het volgende bestand:
`App/Http/Controllers/ProductsController.php`

Maak vervolgens een index actie in de Controller:

```php
public function index() {
  		return view('products.index');
  }
```

En nu zie je al wat?
	
	bierkoerier.dev/products of localhost:8000/products
 
 View maken
 Maak een mapje aan genaamd "products" in de volgende folder:

 `resources/views`
 
 Maak een index.blade.php bestand in de volgende folder:
 
 `resources/views/products/index.blade.php`

Zet hier het volgende in:

```html
<h1>Bierkoerier Producten</h1>

Hier moeten uiteindelijk producten komen..
```
Ga nu naar <http://localhost/products>, wat zie je?

We gaan nu een model maken voor onze producten,
We willen dat onze producten het volgende bevatten:
Pas de .env file aan

	touch storage/database.sqlite

```ini
	DB_CONNECTION=sqlite
	DB_DATABASE=/Users/{username}/Projecten/bierkoerier_new/storage/database.sqlite
```

`php artisan make:model Product --migration`

Dit maakt een model en een bijpassende migration aan in de folder
`database/migrations`

Voeg daar het volgende aan toe:

```php
$table->increments('id');
$table->string('name');
$table->text('description')->nullable();
$table->integer('status');
$table->float('price')->nullable();
$table->float('vat')->nullable();
$table->timestamps();
```

	php artisan migrate

uitvoeren!!!!

We hebben nu een structuur gemaakt voor onze database, maar nog geen data!
Daarvoor hebben we Tinker en Faker!

	php artisan tinker

Je bent nu via de console direct in contact met jou specifieke laravel project, en daar kan je echt coole dingen doen.`

Dit commando haalt bijvoorbeeld alle producten op, zie al wat?

	App\Product::all();

Ah lap zeg, geen producten, laten we wat nepproducten maken!

We gaan een faker classe gebruiken.

`database/factories/ModelFactories.php`

Voeg hier het volgende aan toe:
Voor meer mogelijkheden zie:

[Faker Documentatie](https://github.com/fzaninotto/Faker)

```php
$factory->define(App\Product::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'price' => $faker->randomNumber(5),
        'description' => $faker->text,
        'status' => 0
    ];
});
```

We maken nu een nep product aan, Faker is echt cool want je kan allemaal shit faken! (Fake it 'til you make it)

Voer nu het volgende uit in je artisan tinker omgeving:

	php artisan tinker
	factory(App\Product::class, 10)->create();
	App\Product::all();

Producten?!

De productsController moet er nu als volgt uitzien.

```php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Product;

class ProductsController extends Controller
{

    public function index() {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

}
```


Zet nu het volgende in je view: oftewel `index.blade.php`

```php
@foreach ($products as $product)
<li>{{$product->name}}</li>
<li>{{$product->price}}</li>
<li>{{$product->description}}</li>
<li>{{$product->status}}</li>
@endforeach
```

Zie je producten?!
Zo niet, alle stappen even bij langs en anders bij ons langs :)

Opdracht les 2:
Maak ook neppe gebruikers aan aan de hand van een faker en denk na over hoe deze gebruikers producten kunnen gaan bestellen, wat hebben we dan nodig?

