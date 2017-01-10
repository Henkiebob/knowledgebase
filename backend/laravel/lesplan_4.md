#Les 4
We hebben nu een lijstje van producten, maar stel iemand wil een product kopen, wat hebben we nodig?

"Stel je hebt een winkel, hoe ga je bijhouden wie jou producten koopt?"

Maak eerst een migration aan voor de Orders en de Orderlines

	php artisan make:model Order --migration
	php artisan make:model OrderLine --migration

Zet de volgende code in de de Order migration

```php
$table->increments('id');
$table->integer('user_id')->unsigned();
$table->integer('payment_id')->unsigned();
$table->text('description')->nullable();
$table->integer('status');
$table->float('amount')->nullable();
$table->decimal('lon', 10, 7);
$table->decimal('lat', 10, 7);
$table->timestamps();
```

En de volgende code in de OrderLine migration

```php
$table->increments('id');
$table->integer('order_id')->unsigned();
$table->integer('product_id')->unsigned();
$table->integer('quantity');
$table->float('amount');
$table->timestamps();
```

	php artisan migrate

Dikke migration, celebrate the nation.

Voeg dit toe aan de Order model

```php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
class Order extends Model
{
	use Notifiable;
	
	protected $fillable = [
	    'amount', 'status', 'description', 'lat', 'lon', 'user_id', 'payment_id'
	];
	
	public function orderlines()
	{
	    return $this->hasMany('App\Orderline');
	}
}
```

En voeg dit toe aan de Orderline Model

```php

  protected $fillable = [
  	'product_id', 'order_id', 'quantity', 'amount',
  ];

  public function order() {
      return $this->belongsTo('App\Order');
  }
```


Maak eerst de routes

``` php
Route::get('/orders/new', 'OrdersController@create');
Route::post('/orders/new', 'OrdersController@store');
```

Maak daarna een nieuwe controller een `OrdersController`

	php artisan make:controller OrdersController

Ga nu naar het bestand toe.
Maak daar een nieuwe methode aan genaamd create.

```php
use App\Product;
use App\Order;
use App\OrderLine;

public function create() {
  $products = Product::all();
  return view('orders.create', compact('products'));
}
```

Maak vervolgens een mapje aan in `resources/views/` genaamd `orders` met daarin het bestand `create.blade.php`

Zet daar de volgende HTML in:

```html
@extends('layouts.app')
@section('content')
<div class="container">
<h1>Bestelling plaatsen</h1>
<form method="POST" name="bestelling">
    {{ csrf_field() }}
    <div class="form-group">
        <label for="product">Product</label>
		<select name="product" class="form-control">
			@foreach($products as $product)
				<option value="{{$product->id}}">{{$product->name}}</option>
			@endforeach
		</select>
    </div>
    <input type="submit" name="submit" class="btn btn-succes" value="Geef mij bier!">
</form>
</div>
@endsection
```

Ga nu naar `/order/create` dik formulier!

Maak de nu de store functie in de OrdersController, deze doen we even anders dan de productscontroller om te laten zien, dat het anders kan!

public function store(Request $request)
{

    $order = Order::create([
        'user_id' => 1,
        'payment_id' => 1,
        'amount' => 1,
        'status' => 0,
        'lat' => 53.201233,
        'lon' => 5.799913,
    ]);

    $orderline = New OrderLine([
        'product_id' => $request->product,
        'quantity' => 1,
        'amount' => 10.00,
    ]);

    $order->orderlines()->save($orderline);

    $user = User::first();
    $user->notify(New OrderCreated($order));
    return "success";

}

Maak vervolgens een notificatie aan!
	php artisan make:notification OrderCreated
	

```php
namespace App\Notifications;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
class OrderCreated extends Notification
{
use Queueable;
protected $order;

/**
 * Create a new notification instance.
 *
 * @return void
 */
public function __construct()
{
    //
}

/**
 * Get the notification's delivery channels.
 *
 * @param  mixed  $notifiable
 * @return array
 */
public function via($notifiable)
{
    return ['mail'];
}

/**
 * Get the mail representation of the notification.
 *
 * @param  mixed  $notifiable
 * @return \Illuminate\Notifications\Messages\MailMessage
 */
public function toMail($notifiable)
{
    return (new MailMessage)
                ->subject('Een nieuwe order is aangemaakt')
                ->line('Dikke bestelling!')
                ->success();
}

/**
 * Get the array representation of the notification.
 *
 * @param  mixed  $notifiable
 * @return array
 */
public function toArray($notifiable)
{
    return [
        //
    ];
}
}
```

Ga naar mailtrap.io (login met github)
En maak een inbox, neem de volgende settings over deze in je .env file.

	MAIL_USERNAME=jeusername (zie mailtrap settings)
	MAIL_PASSWORD=jekey
	
Nu krijg je mail in je mailbox!