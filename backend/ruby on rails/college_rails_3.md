### Verder met ons portfolio project!

Mocht je het project nog niet hebben gemaakt, doe dit door de vorige sheets te volgen!

### Carrierwave installeren
Ga naar het volgende bestand ```` gemfile.rb ```` en voeg de onderstaande regel toe.
Maakt niet uit waar, zolang het maar niet in group:development staat.

```` 
gem 'carrierwave' 
gem 'mini_magick'

Voor meer informatie: https://github.com/carrierwaveuploader/carrierwave
Let op! : Carrierwave heeft een aantal afhankelijkheden die wij ook nodig hebben, het maakt bijvoorbeeld gebruik van minimagick deze is weer afhankelijk van imagemagick.

minimagick installeer je op gem niveau in je rails project, die spreekt met imagemagick dat moet je op de server of in dit geval op je computer hebben staan.

Voor Mac gebruikers kan dit met homebrew heb je dat nog niet, installeren dan!

http://brew.sh/
brew install imagemagick
````

### Uploader aanmaken
Ga vervolgens in de terminal naar je project bijvoorbeeld ```` cd sites/rails/portfolio/ ````

en voer het commando ```` bundle install ```` uit.
Vervolgens krijg je een hele lijst te zien, waaronder onze nieuwe gem carrierwave!
Voer vervolgens het commando ```` rails generate uploader PortfolioImage ```` uit. Dit maakt een uploader class, die je kan gebruiken om alle attributen van je afbeelding te defineren.

Dit bestandje staat hier: ```` uploaders/portfolio_image_uploader.rb ````

We gaan de volgende methoden defineren binnen deze class.
We verwachten een bestand, deze gaan we opslaan in een mapje, we maken een aparte thumb versie van ons bestand en we laten alleen jpg, jpeg, gif of png) toe.
Handig niet?

````
  include CarrierWave::MiniMagick
  
  storage :file
	
  def store_dir
    "uploads/#{model.class.to_s.underscore}/#{mounted_as}/#{model.id}"
  end

  version :thumb do
    process :resize_to_fit => [250, 250]
  end

  def extension_white_list
    %w(jpg jpeg gif png)
  end
 ````
 
 Weet je nog het `Item` model dat we gemaakt hebben? We moeten even een veld toevoegen, zodat de afbeeldingen die we uploaden gekoppeld kunnen worden aan een portfolio item. Daarvoor moeten we zelf een migration maken.  
 
 ````
 rails g migration add_portfolio_image_to_items portfolio_image:string
 
 #direct maar even uitvoeren
 rake db:migrate
 ````
 Hij gaat nu het veld portfolio_image (string) toevoegen aan ons items tabel, waar ons Item model gebruik van maakt!
 
Ga vervolgens naar je `Item` model en zet het volgende er neer.
 
 ````
class Item < ActiveRecord::Base
	mount_uploader :portfolio_image, PortfolioImageUploader
end

````

Nu weet het `Item` model dat bij dit veld een uploader is ingesteld, zodat hij de instelde methodes kan uitvoeren!

Dikke prima, nu moeten we onze view aanpassen van de new action, om daar een extra veld toe te voegen, namelijk een file input, zodat we een afbeelding kunnen uploaden! Dus open het bestand `views/items/new.html.erb` en voeg het volgende toe aan het formulier, binnen de form_for block.

````
	<%= label_tag(:title, "Afbeelding:") %>
	<%= f.file_field :portfolio_image %>
````

Daarnaast moet er een aanpassing gedaan worden aan het formulier, het moet nu ook het versturen van bestanden gaan ondersteunen. Dit doe je door het volgende toe te voegen. Vervang de eerste tag maar met deze onderstaande, het gaat om het ` multipart: true` gedeelte.

````
<%= form_for @item, url: {action:"create"}, multipart: true do |f| %>
````
 
 Zullen we kijken wat ie nou doet? Tja, eigenlijk niet zoveel, want we verwachten in onze controller nog helemaal geen image en we doen er er helemaal niks mee. Ja dat moeten wij allemaal nog doen!
 
 Ga naar de itemscontroller, en verander onze `item_params`, want wij willen nu ook een afbeelding toelaten.
 
````
  private
  def item_params
  	params.require(:item).permit(:title, :description, :portfolio_image)
  end
````
Probeer het nog eens en als alles goed is, heb je net een afbeelding geupload, nu moeten wij hem alleen nog zien. Je kan natuurlijk even het `/uploads` mapje checken of daar nu allemaal dingen zijn aangemaakt, dat hebben wij tenslotte ingesteld.

Dus we gaan naar `views/items/index.html.erb`
En we voegen het volgende toe `<%= image_tag(item.portfolio_image_url(:thumb)) if item.portfolio_image? %>`

Dit maakt een image tag voor onze portfolio_image en we willen de :thumb versie want om voor elk item een joekel van een afbeelding te plaatsen is niet echt chill.

###Categorie toevoegen (relaties)
Laten we ons portfolio uitbreiden met enkele categorieen, zo kunnen we aan elk item meerdere categorieen gaan toevoegen! Super toll klasse.

Dit noemen we een relatie, je wil namelijk dat een Item meerdere categorieen kan hebben en een categorie hoort bij een Item.

Laten we beginnen met het aanmaken van een category model.

`rails g model category title:string item_id:integer`


Ga naar ons nieuwe category model en defineer het volgende.

`belongs_to :item`

Ga vervolgens naar ons item model en defineer het volgende.
Je mag het zelf in de meervoudsvorm opschrijven, Rails is slim genoeg om te weten wat jij wil.

`has_many :categories`

De relatie is gemaakt, maar we moeten dit nog doorvoeren in de database!
Laten we even migreren!

`rake db:migrate`

Laten we nu onze relatie checken!

````
Rails console openen en even spieken of je relatie er staat.
rails c
Item.reflect_on_all_associations
[#<ActiveRecord::Reflection::HasManyReflection:0x007fc669ef0970 @name=:categories
````
Laten we alvast wat categorieen toevoegen, hetzelfde als de vorige keer, blijf je in rails console en doe het volgende, voeg er maar een paar toe!

````
c = Category.new
c.title = 'Website'
c.save
````
Dus, misschien is het een idee om deze in te kunnen stellen bij het aanmaken van een Item, zodat we kunnen opgeven bij welke categorieen onze items bijhoren!
Rails 4 heeft dit een stuk makkelijker gemaakt.

Voeg het volgende toe aan `app/views/items/new.html.erb`

`<%= f.collection_check_boxes :category_ids, Category.all, :id, :title %>`

Doe maar ergens onderaan, binnen het form block natuurlijk.
Wat we hier doen, is een collectie van checkboxes tonen, aan de hand van de title met als waarde de ID van onze category.

Onze items controller moet hier natuurlijk mee om kunnen gaan, laten we onze parameters aanpassen, zodat we dit toelaten.
	`params.require(:item).permit(:title, :description, :portfolio_image, :category_ids => [])`

We laten hier een array van category_ids toe, ik zou zeggen, ram er een nieuwe portfolio item in en selecteer een aantal categorieen!

We kunnen dit weer controleren in onze geliefde rails console omgeving.

````
rails c
i = Item.last
i.categories
````
We pakken voor het gemak het laatste item en kijken of er relaties tussenstaan!

````
<ActiveRecord::Associations::CollectionProxy [#<Category id: 1, title: "Website", item_id: 9, created_at: "2016-04-10 19:34:56", updated_at: "2016-04-10 19:45:52">, #<Category id: 2, title: "Kunstwerk", item_id: 9, created_at: "2016-04-10 19:35:12", updated_at: "2016-04-10 19:45:52">]>
````

Nu willen we dit ook in onze overzichtspagina tonen, ga snel naar `app/views/items/index.html.erb`

````
<% item.categories.each do |category| %>
	<%= category.title %>
<% end %>
````

En zie daar, prachtige blinkende categorieen.