###Een project starten

````
rails new portfolio_project
````

We hebben nu een leeg project en we willen een portfolio website bouwen. Denk na over de structuur van de applicatie, wat bevat een portfolio website?

Laten we beginnen met portfolio items, stel je maakt websites en produceert video's toch zou je beide op je portfolio willen zetten. Maak je dan een controller video's en een controller websites?

Wanneer je overal een aparte controller voor gaat maken, kan het snel een ongestructueerde boel worden, dus laten we websites en video's verzamelen onder het woord item.

Wat voor attributen zou een item hebben?

- title
- description
- url

voor later:
- image
- category_id

### Model genereren

Laten we kijken wat dit voor ons gemaakt heeft, ga naar je project toe met het volgende commando, cd staat voor change directory, je kant met pwd zien waar je nu bent.

````
cd portfolio_project
````
Maak vervolgens een rails model met de attributen die je wilt gebruiken.
````
rails g model item title:string description:text url:string
````

### Migrations
Vervolgens kan je op linux/mac de bestanden tonen met het commando ````open .```` (. staat voor de huidige directory) wanneer je sublime gebruikt kun je de huidige map open met het commando ```` subl . of sublime . ```` sleep het mapje naar je IDE of texteditor om de structuur te bekijken, we zijn op zoek naar het mapje ```` db/migrate ```` vervolgens staat er een bestandje met veel cijfers (timestamp) en bestand ```` 20160328173033_create_items.rb```` 

Dit bestand heet een migration, deze maakt de benodige velden aan in de database voor het item object wat wij willen gaan maken. Deze migration kan op elke soort database (mysql, psql, sqlite) worden uitgevoerd en je kunt database veranderingen makkelijk bijhouden.

Laten we de migration uitvoeren, dan worden de velden daadwerkelijk toegevoegd aan de database!

````
rake db:migrate
````

Vervolgens krijg je deze melding

````
== 20160328173033 CreateItems: migrating ======================================
-- create_table(:items)
   -> 0.0014s
== 20160328173033 CreateItems: migrated (0.0014s) =============================
````

Great succes!

### Andere db commando's
Haal deze maar even door google of duckduckgo om te zien wat ze doen!
````
rake db:reset
rake db:seed
rake db:drop
````

### Controller genereren, methods maken

Allemaal leuk en aardig, maar bij ons Model hoort een Controller, we willen uiteindelijk een pagina hebben waar we zelf nieuwe portfolio items kunnen toevoegen. Het stukje index, new, show zijn methodes voor je controller, oftewel commando's die wij straks gaan maken.

````
rails g controller items index new show
````

ga naar ```` app/controllers/items_controller.rb ```` om te zien wat je gemaakt hebt! Als het goed is staan er drie lege methods voor je klaar. Een method begint met ```` def ```` en eindigt met ```` end ````.

Zo zou je ook je eigen methode kunnen maken. Of zelfs met parameters. Deze methodes zou je kunnen aanroepen in de controller of zelfs vanuit de view.

````
def henk
	return "Henk"
end

def say_hello(name)
   return “Hello, ” + name
end

say_hello("Henk")
>> "Hello, Henk"

````

### Webserver 
Leuk al dat command-line werk, maar laten we dingen gaan bekijken.
Start de ingebouwde rails webserver.

````
rails s
````
Er start nu een webserver in het terminal tabje, in dit tabje kun je ook geen commando's meer uitvoeren. Je kan de server weer stoppen met ```` ctrl + c ````
Maar we laten hem eerst maar draaien. Open je browser en ga naar ```` http://localhost:3000 ````

Als het goed is zie je een prachtig welkom! scherm.
Stel wij willen alle portfolio items bekijken door naar ```` http://localhost:3000/items ```` te gaan, wanneer je nu naar die pagina gaat, zie je dat deze geen route heeft, wat betekent dat?

### Routes
Alle routes staan beschreven in het bestandje ````config/routes.rb````

*Deze routes zijn volgende RESTFUL methode opgebouwd, om daar meer te weten over te komen, zie de sheets van het vorige college.*

Defineer daar een nieuwe route, bijvoorbeeld:

````
 get 'items' => 'items#index'
````
Wanneer je pagina ververst zul je de volgende foutmelding zien:

````
The action 'showall' could not be found for ItemsController
````
Dat klopt want deze method hebben wij nog niet gemaakt in deze controller.
Laten we deze aanmaken! Deze method haalt van het Item model alle items op. Er zijn er veel manieren om in Rails je model aan te spreken. Zie hier enkele voorbeelden.

````
http://guides.rubyonrails.org/active_model_basics.html
````

````
  def index
  	@items = Item.all()
  end
````
Als we de pagina nogmaals verversen krijgen we een leeg template, laten we deze aanpassen, dat brengt ons bij de views!

### Views

De method index haalt alle items voor ons op en zet deze in @index, daar kunnen we wel wat mee in onze view.

Typ het volgende in het bestand ````views/items/index.html.erb ````

````
<% @items.each do |item| %>
	<%= item.title %>
<% end %>

````
Dit zou alle items moeten tonen... maar wacht.. we hebben nog niks aangemaakt..
Je kunt zo alle attributen van een item ophalen. Zoals URL of description, weet je nog?

### Rails console
Laten we handmatig een item aanmaken, dit kan met de rails console. Hiermee kan je live commando's uitvoeren op je Rails applicatie, super handig!

````
rails c

i = Item.new
i.title = "Portfolio item"
i.save
````
Dit maakt een nieuw item aan, Item.new is daar de aanroep voor, we vullen dit item met een title en slaan deze vervolgens op.

Zullen we kijken of het item er tussen staat? Ik denk het wel ;)
````
http://localhost:3000/items/
````

### Controller uitbreiden

Dus laten we ons items controller uitbreiden met een new method
Als het goed is, staat deze eral, we hoeven deze alleen maar uit te breiden.
Zie je de overeenkomst tussen ons console stukje hiervoor? met Item.new kan je een nieuwe leeg object maken, maar nu gaan we deze laten vullen met een formulier, niet met de console.

````
  def new
  	@item = Item.new()
  end
 ````
 
 Laten we de view aanpassen zodat deze een formulier toont, Rails heeft hiervoor een ingebouwde FormHelper. Pas het volgende bestand aan ````views/items/new.html.erb ````

````
	  	<%= form_for @item, url: {action: "create"} do |f| %>
		  <%= label_tag(:title, "Titel:") %>
		  <%= f.text_field :title %>
		  <%= label_tag(:description, "Beschrijving:") %>
		  <%= f.text_area :description, size: "60x12" %>
		  <%= f.submit "Aanmaken" %>
		<% end %>	
````
Hiermee bouw je een formulier op, de actie gaat naar onze create methode in de controller en elk veld kan nu worden ingevuld in het formulier.

Laten we kijken
````
http://localhost:3000/items/new
````
De volgende fout...
*No route matches {:action=>"create", :controller=>"items"}*

Het formulier kan geen route vinden waar het de POST heen kan sturen.
Dus we gaan ons routes (```` config/routes.rb ````) file aanpassen.

````
post 'items' => 'items#create'
````

Nog een keer kijken!
Het formulier ziet er niet echt bepaald mooi uit en de create method doet nog niks, vul maar wat in!

*The action 'create' could not be found for ItemsController*

Yup, dit moeten wij nog afvangen, goed om te weten dat er een POST wordt gedaan naar items/new, dat staat ook in onze routes.

Zet het volgende in je items controller

````
  def create 
  	@item = Item.new(item_parameters)

	if @item.save
	  redirect_to items_path
	end
  end
````

redirect_to zorgt ervoor dat na het aanmaken van het item, de gebruiker wordt terugestuurd naar de overzicht pagina.

Deze item new functie verwacht dus item_parameters, Rails wil graag dat je precies aangeeft welke parameters je verwacht mee te sturen, dit is een extra laag van beveiliging.

Dus defineer deze methode onderaan de controller, laten we het nog een keer proberen.

````
	private
	def item_parameters
      params.require(:item).permit(:title, :description)
    end
````

Als het goed is verschijnt er een item bij het overzicht, succes!


####Volgende keer:
- Afbeeldingen toevoegen aan portfolio items
- gem installeren imagemagick,
- gem installeren bootstrap
- categorieen toevoegen aan onze items met relaties!!

