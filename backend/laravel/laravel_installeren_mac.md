# Laravel installeren op Mac

Laravel is beschikbaar als package binnen composer, die vervolgens PHP nodig heeft om te kunnen draaien.
Laravel heeft een ingebouwde server, dus je hebt in principe zelf geen apache, nginx nodig om te kunnen beginnen.

## Homebrew
Om gemakkelijk php en composer te kunnen installeren (of mysql en nginx) op een mac, kun je homebrew gebruiken.
Ga naar je terminal en kijk of je homebrew al geinstalleerd hebt door het commando `brew` te typen.
krijg je een enorme lijst terug met wat je allemaal kan doen? mooi dan mag je deze stap skippen.

Zo niet, installeer Homebrew.

`/usr/bin/ruby -e "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/master/install)"`

Kopieer en plak het bovenstaande commando in je terminal en SMASH op ENTER alsof het leven je kat ervan af hangt.
Voor de zekerheid moeten wij natuurlijk wel even weten of je brew nog up to date is.

`brew update` <-- even uitvoeren
`brew upgrade` <-- even doen

Ok cool, soms het voor dat je een oude versie van Homebrew hebt met allemaal fouten, je kan deze het beste oplossen met `brew doctor`
ga vervolgens alle problemen bij langs en los ze op. (Google is your friend)

## PHP
Mac heeft standaard php geinstalleerd, maar een oude versie, installeer hiermee de nieuwste versie.

`brew install php71`

Als het goed is geeft dit commando een aantal vervolgstappen, voer deze allemaal uit!
Lees je terminal goed na.

Als je alle stappen gevolgd hebt, voer dan dit commando uit `php -v` krijg je php 7.1? dan ben je binnen.

## Composer
Tijd voor composer!
`brew install composer`
`composer global require "laravel/installer"`

- Zet het volgende pad in je ZSHRC of BASHRC (gebruik je zshell of standaard bash?)
`export PATH=~/.composer/vendor/bin:$PATH`

## The final test
*Pro tip, maak een mapje aan in Sites voor al je Laravel projecten*
Probeer een nieuw project te maken! `laravel new nieuwproject`
ga vervolgens naar het mapje `cd nieuwproject`

`php artisan serve`

op naar je [Localhost](http://localhost)

Zie je een Laravel logo? dan ben je binnen, zie je helemaal niks? #huilen
