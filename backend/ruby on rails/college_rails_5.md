## Stijl toevoegen aan Rails project

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

## Cronjobs maken

We gaan gebruik maken van de gem whenever.
Cronjobs zitten standaard in Mac OSX of andere linux based omgevingen, je kan nu ook al cronjobs aanmaken, maar deze gem maakt het makkelijk voor ons.
`https://github.com/javan/whenever`

Lees meer over cronjobs hier:
`http://en.wikipedia.org/wiki/Cron`

Voeg de volgende gems toe aan je gems file, we voegen letter opener toe, want we willen een mailtje ontvangen wanneer de cronjob gelopen heeft.

`gem 'whenever', :require => false`
`gem "letter_opener", :group => :development`

`bundle install`
`bundle exec wheneverize .`

Dit maakt een bestand voor ons aan `config/schedule.rb`
Zet in dit bestand het volgende:

````
every 1.minutes do
  runner "Item.delete_old_records", :output => 'cron.log' 
end
````

We gaan elke minuut alle oude items verwijderen, een beetje extreem misschien misschien kan dit beter elke dag. Maar voor het testen en leren van cronjobs maken wel handig. (elke keer een dag wachten is ook wat)

De syntax is vrij simpel, `every 1.days `of zelfs een bepaald tijdstip kan opgegeven worden, mocht zie hiervoor de documentatie van whenever.

Ga nu naar het Item model, we gaan alle items die een week geleden zijn aangemaakt, verwijderen, daarna sturen we een mailtje naar onszelf, zodat we weten dat het gedaan is.

````
	def self.delete_old_records
		items = Item.where('created_at < ?', 1.week.ago)
	
		items.each do |item|
			item.destroy
		end
	end
````

Je zou deze method in je console kunnen testen, wel handig om te weten dat je functie werkt.

`rails c`
`i = Item.new`
`i.delete_old_records`

Om je cronjob vervolgens te tesen kan je het volgende commando gebruiken.

`bundle exec whenever --update-crontab --set environment='development'`

Deze voegt je cronjob toe aan de crontab rij.
Je kan met `crontab -l` kijken of hij er bij is gekomen.

Met `crontab -r ` kan je de hele cronjob lijst reloaden
met `whenever -c` kan je lijst leegmaken

We hebben een log file toegevoegd, dus als het goed is kunnen wij deze in de gaten houden.

`tail -f cron.log `

Met dit commando kan je de logfile in de gaten houden.
Maar een e-mail bericht op het moment dat hij klaar is kan ook handig zijn, rails heeft hier ingebouwde functionaliteiten voor!

`rails generate mailer UserMailer`

Dit maakt een nieuwe mailer voor ons aan, vervolgens kunnen wij wat instellingen toevoegen.

Pas dit aan je application mailer `mailers/application_mailer.rb`

````
class ApplicationMailer < ActionMailer::Base
  default from: "tjerkjippe@tjerkjippe.nl"
  layout 'mailer'
end
````

`mailers/user_mailer.rb`

````
class UserMailer < ApplicationMailer

	 def cron_mail
	 	email = "hallo@email.com"
    	mail(to: email, subject: 'Cronjob heeft gelopen')
  	end

end
````

in views/user_mailer maak het volgende bestand aan
cron_mail.html.erb

````
<!DOCTYPE html>
<html>
  <head>
    <meta content='text/html; charset=UTF-8' http-equiv='Content-Type' />
  </head>
  <body>
    <h1>Cronjob heeft gelopen</h1>
  </body>
</html>
````
En zet de volgende instelling je `config/enviroments/development.rb`

`config.action_mailer.delivery_method = :letter_opener`

Voeg dan het volgende stukje code toe aan je cronjob. (Item model)

`UserMailer.cron_mail.deliver_now`

Deze gaat direct een email versturen, omdat we letteropener gebruiken hoeven we geen mailinstellingen te doen, we krijgen het mailtje direct te lokaal te zien.

