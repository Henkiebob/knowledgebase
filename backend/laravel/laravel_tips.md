#Laravel Notes

## Typehinting
Haalt automatisch aan de hand van de modelnaam het object op.
Minder code, zelfde resultaat

```
// routes
Route::get('/notes/{note}', 'NoteController@show');

//NoteController
public function show(Note $note){
	return $note;
}
```

## Eager loading
Haalt de bijbehorende user object alvast op, zodat er niet overbodig veel queries worden gedaan bij het laden van de pagina.

```
public function show(Note $note){
	$note->load('user');
	return $note;
}
```

## Method binding (form)
Zo kan je een methode meegeven aan je form, de meeste browsers ondersteunen PATCH, DELETE en PUT niet, met deze manier kan je routes RESTFUL houden.

````
<form method="POST">
    {{ method_field('DELETE') }}
    {{csrf_field}}
</form>
```

## JSON RETURN
Wanneer je in een controller het object direct teruggeeft, krijg je automatisch JSON, no formatting needed.

```
public function show(Note $note){
	return $note;
}
```

## DD (die and dump)
Handige ingebouwde functie voor debuggen, stop met alles en dump je data.

```
dd($data);
```

## Old()
Laat de oude post data zien, handig voor edit velden. met error meldingen

```
{{old('data')}}
```
