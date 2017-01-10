#Authentication met Rails

Voor een applicatie is vaak een afgesloten omgeving nodig, je hebt een plek nodig waar gebruikers kunnen inloggen en registeren, sommige gebruikers hebben toegang tot alles, sommige alleen tot een bepaald gedeelte van je applicatie.

Rails heeft meerdere gems voor het bouwen van een authentication systeem, zoals devise omniauth.

 - https://github.com/plataformatec/devise
 - https://github.com/intridea/omniauth

Deze kant-en-klaar oplossingen zijn handig wanneer je geen tijd hebt om zelf een systeem te bouwen, maar dat willen we wel!

## Zelf bouwen!

Maar omdat we Rails willen leren gaan we ons authenticatie systeem zelf bouwen, we gaan een `User` model maken en een `Session` controller. Laten we gewoon maar beginnen, lijkt me het beste.

Voordat we los kunnen, moeten we bcrypt aanzetten, die hebben wij nodig voor het encrypten van het wachtwoord. (deze staat in commen in je gemfile)

`gem 'bcrypt', '~> 3.1.7'`

Daarna natuurlijk even `bundle install` runnen.

## User model aanmaken

Laten beginnen met het `User` model.

`rails generate model user name email password_digest`

Laten we dit maar direct uitvoeren.

`rake db:migrate`

Ga naar het `User` model en voeg het volgende toe:

````
class User < ActiveRecord::Base
	has_secure_password
end
````

Ook maar even een User controller maken (de laatste twee parameters zijn methoden)

`rails g controller Users new create`

Ga naar je controller toe en zorg dat de new methode in elk geval dit bevat.

````
  def new
  	@user = User.new()
  end
````

En je create method het volgende.

````
  def create
  	@user = User.new(user_params)
    if @user.save
      session[:user_id] = @user.id
      redirect_to '/'
    else
      render 'new'
    end
  end
  
private
def user_params
	params.require(:user).permit(:name, :email, :password, :password_confirmation)
end
  
````
Laten we een formulier maken waar mensen zich kunnen registeren.

````
<%= form_for(@user) do |f| %>
   <%= label_tag(:name, "Naam:") %>
  <%= f.text_field :name %>
  <%= label_tag(:email, "Email:") %>
  <%= f.text_field :email %>
  <%= label_tag(:password, "Wachtwoord:") %>
  <%= f.password_field :password %>
  <%= label_tag(:password_confirmation, "Wachtwoord controle:") %>
  <%= f.password_field :password_confirmation %>
  <%= f.submit "Registeren" %>
<% end %>
````

Nu nog even onze routes file aanpassen, zodat we onze post afvangen. En laten we onze hoofdpagina maar een showcase van al onze items zijn.

````
  get 'items/new'
  get 'items/show'
  get 'items' => 'items#index'

  get 'registreren' => 'users#new'
  get 'login' => 'sessions#new'
  get 'logout' => 'sessions#destroy'

  post 'items' => 'items#create'
  post 'login' => 'sessions#create'
  post 'users' => 'users#create'

  root 'items#index'

````

Laten we ook een sessions controller maken, om alle login logica te behandelen.

`rails g controller sessions`

Zet de volgende logica erin:

````
  def create
    user = User.find_by_email(params[:email])

    if user && user.authenticate(params[:password])
      session[:user_id] = user.id
      redirect_to '/'
    else
      redirect_to '/login'
    end
  end
 ````

Laten we ook een inloggformulier maken, deze gaat de inloggegevens posten naar de sessions controller, waar we alles gaan controleren.

`app/views/sessions/new.html.erb`

````
<%= form_tag '/login' do %>
  <%= label_tag(:email, "Email:") %>
  <%= text_field_tag :email %>
  <%= label_tag(:password, "Wachtwoord:") %>
  <%= password_field_tag :password %>
  <%= submit_tag "Inloggen" %>
<% end %>
````

Nu gebruikers kunnen inloggen, willen we dit ter aller tijde in onze applicatie kunnen controleren, dit gaan we doen met een helper method, deze kunnen we vervolgens in elke controller aanroepen.

Ga naar de `application_controller.rb`, voeg daar het volgende toe:

````
  def current_user
    @current_user ||= User.find(session[:user_id]) if session[:user_id]
  end
  helper_method :current_user

  def authorize
    redirect_to '/login' unless current_user
  end
````

Er bestaat ook een `application_view`, dit stukje HTML wordt altijd geladen, dus kan je prima gebruik van maken.

````
<% if current_user %>
  Ingelogd als: <%= current_user.name %> | <%= link_to "Uitloggen", '/logout' %>
<% else %>
  <%= link_to 'Login', '/login' %> | <%= link_to 'Registren', '/register' %>
<% end %>
````

Vervolgens kunnen we in onze `Items Controller` aangeven dat voor elke methode inloggen is verplicht.

`before_filter :authorize`

Ga nu maar een naar `http://localhost/items/`
Ja hier mag je nu niet bij.. lijkt met niet zo handig voor portfolio items.
Dus we gaan onze filter aanpassen.

`before_action :authorize, except: [:index, :show]`

Op deze manier geldt je filter alleen voor de overige methodes, niet voor index en show.

##Validations
We hebben nog een probleempje, er kunnen nog lege accounts geregisteerd worden, we controleren de input helemaal niet, maar dat moet wel natuurlijk.

Ga naar de `User` model.
We willen dat een naam, wachtwoord en email verplicht is! En dat onze wachtwoorden gelijk zijn..

````
	validates :name, :password, :email, presence: true
	validates :password, confirmation: true
	validates :email, uniqueness: true, on: :create
	validates_format_of :email, :with => /@/
	validates :password, length: { minimum: 8 }
````
Maar we willen ook dat de wachtwoorden overeenkomen, en dat er teminste een @ in het emailadres zit, dat het wachtwoord minimaal 8 tekens heeft, de rest boeit ons niet, als iemand een wachtwoord van 10000 tekens wil, prima (security!)

Voeg vervolgens dit stukje code aan je `app/views/users/new.html.erb` toe!

````
  <% if @user.errors.any? %>
    <div id="error_explanation">
      <ul>
      <% @user.errors.full_messages.each do |message| %>
        <li><%= message %></li>
      <% end %>
      </ul>
    </div>
  <% end %>
````

##Vertalen van deze meldingen

Ga naar `application.rb` en pas deze regel aan `config.i18n.default_locale = :nl`
Download vervolgens een vertaling en zet deze neer in `config/locals/nl.yml`

 - https://github.com/svenfuchs/rails-i18n/blob/master/rails/locale/nl.yml


## Flash messages
Voeg het volgende toe aan je `sessions controller`.

`flash[:notice] = "Je bent ingelogged, yay!";`

En stop dit in je `application.html.erb.`

````
<% flash.each do |name, msg| -%>
      <%= content_tag :div, msg, class: name %>
<% end -%>
````


## Stijl toevoegen

- http://www.mattboldt.com/organizing-css-and-sass-rails/

Er zijn de verschillende bestanden die altijd worden ingeladen, zoals `application.html.erb` deze zijn over het gehele project beschikbaar, daarvoor hebben we ook onze flash messages hierin gezet.

Er is ook een `application.css ` hier kan je alle stijl neerzetten die over je gehele project geldig is. Soms is het beter om per controller een aparte stylesheet te hebben, maar hoe voeg je dat toe?

voeg deze regel toe aan je `application.css` 
````
*= require main
````
Maak het volgende bestand aan `vendor/stylesheets/main.scss`
En zet daar het volgende in:

`@import "items.scss";`

Maak vervolgens dat bestand aan:  `vendor/stylesheets/items.scss`
Knal daar vervolgens wat stlying in om te kijken of het werkt:

````
body{
	background:red;
}
````

Heb je een rode achtergrond? mooi dan werkt alles naar behoren.
Daarnaast zijn de volgende tags nog aanwezig.

````
stylesheet_link_tag "style"
javascript_include_tag "henk.js"
````


