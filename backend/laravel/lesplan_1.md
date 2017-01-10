#Lesplan Laravel

## Les 1

Wat is een framework?
Wat is MVC?

![GET DIAGRAM](get.png)

Wat zijn de alternatieven (Rails, Django)?

Laravel installeren!
<https://github.com/NHLHogeschool/knowledgebase/blob/master/backend/laravel_installatie.md>


Alternatieven:
Homestead
VM
Docker

`laravel new bierkoerier`

Na installatie bezig met eerste artisan commando

`php artisan serve` of `bierkoerier.dev`

Wow een pagina!

`cd bierkoerier` - ga naar het mapje
`php artisan make:auth`
`atom .` of `sublime .` of `subl .`

Wat doet dit commando?
- Wat is een route
- Wat is een class
- Was is een model

###Opdracht les 1
We gaan een bierkoerier app maken, met deze app is het mogelijk om vanuit een mobiele applicatie op "ik wil bier" te klikken, vervolgens stuurt hij je locatie en bestelling naar onze laravel applicatie, vervolgens is het mogelijk om orders in te zien en te beheren"

Elke applicatie begint op papier, met een schets.

Dit hebben we nodig:

- Een gebruiker kan meerdere orders plaatsen
- Een gebruiker moet dus meerdere producten kunnen bestellen (maar ga eerst uit van het voorbeeld, een enkel biertje bestellen)
- Een Order kan uit meerdere producten bestaan
- Een Order is gekoppeld aan een enkele betaling
- Er moet uiteindelijk een totaal bedrag naar de Gebruiker die een order plaatst.
- Gebruiker moet kunnen inloggen
- Bij een order moet de locatie worden opgeslagen

[Voorbeeld diagram, alle veldtypes uitleggen]

- Maak een Database diagram voor onze bierkoerier opdracht.

- Denk goed na over de structuur en de relaties van je database schema, welke relaties hebben we nodig? teken deze uit.
- Hiervoor zal je primary keys en foreign keys moeten gebruiken, zoek deze termen op, wat betekenen deze?

Gebruik een de volgende tools:
`https://www.draw.io/`
`https://github.com/ondras/wwwsqldesigner`
`http://www.mysql.com/products/workbench/`
`http://staruml.io/`

Mail het diagram naar tjerk.dijkstra@nhl.nl



