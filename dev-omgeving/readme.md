# **Development omgeving**
Iedereen kent wel de applicaties [XAMPP](https://www.apachefriends.org), [MAMP](https://www.mamp.info/en/) en 24 varianten hiervan.

Maar er is een alternatief, namelijk [Vagrant](https://www.vagrantup.com/).
Vagrant is een virtual server die gedraaid wordt op jouw computer.
Hier heb je alle mogelijkheden van een echte server maar dan lokaal.

Een aantal voordelen zijn:
- In een team werkt iedereen met dezelfde omgeving.
- Als je een fout maakt in je omgeving heeft dat geen invloed op jouw computersysteem.
- Geen veiligheid risico omdat je PHP/RoR per ongeluk blijft draaien in de achtergrond.


## **Installeren**

Voor het installeren van _Vagrant_ heb je _VirtualBox_ nodig, dit is gratis en voor zowel Windows als Mac.
Download beide installaties voor jou systeem:
- https://www.virtualbox.org/wiki/Downloads
- https://www.vagrantup.com/downloads.html

**Installeer eerst VirtualBox daarna pas Vagrant!**

Als beiden zijn geïnstalleerd maak een map aan waar je jouw project wilt gaan hebben. Bijvoorbeeld voor Windows: `C:\Users\GEBRUIKER\Documents\laravel` en Mac:`~/Documents/laravel`  **Geen hoofdletters of Vagrant zal niet goed koppelen met deze map!**

Na dat deze map is aangemaakt volg de instructie voor:
- [Installatie PHP laravel](#installatie-php-laravel)


### **Installatie PHP Laravel**
specs: `git php-7.0 nginx sqlite` maar nog zonder database!

Voor het veder installeren van Laravel heb je de 2 bestanden nodig in de _laravel_ map [Vagrantfile](laravel/Vagrantfile) en [laravel.sh](laravel/laravel.sh)

Beiden moet je over kopiëren in je mapje die je hebt aan gemaakt. Voor deze instructie noemen we deze `laravel`

Open een terminal en ga naar waar jij je map hebt staan.

_Voorbeeld Windows_
```
cd C:\Users\GEBRUIKER\Documents\laravel
```

_Voorbeeld Mac_
```
cd ~/Documents/laravel
```

Type nu in de terminal:
```
vagrant up --provider virtualbox
```
Je Vagrant Installatie zal zich nu installeren.

Als hij klaar is met alles installeren moeten we nog 1 actie uitvoeren zodat je _vagrant_ opnieuw kan starten.

1. Ga naar VM VirtualBox en dubbelclick op `vagrant_default_...`.

2. Log hierin met `ubuntu` en er zal een password reset worden uitgevoerd. Vul hier ook 2x `ubuntu` in.

3. type nu `exit`.

Laat het venster open anders sluit je Vagrant en dat willen we niet.

**project aanmaken**

Er zijn 2 opties:
- het kan zijn dat je al een project hebt, importeer deze met `git` in de map op jouw computer.
- kopieer deze van GitHub https://github.com/laravel/laravel.

Open een browser en ga naar: `localhost:8080` of `127.0.0.1:8080`.

## **standaard commando's**
Alle commando's worden uitgevoerd in je terminal in de map waar je de server hebt geïnstalleerd
- `vagrant up`: hier start je de Vagrant server mee op.
- `vagrant up --provision`: mocht er een fout zijn tijdens het opstarten en is er een installatie niet goed gegaan, kan je hier mee het opnieuw uitlaten voeren.
- `vagrant reload`: het herstarten van de server.
- `vagrant halt`: Het stoppen van de server.

**SSH-toegang tot de server**
- Mac: `vagrant ssh` username: _ubuntu_ password: _ubuntu_.
- Windows: [Putty.exe](http://www.chiark.greenend.org.uk/~sgtatham/putty/latest.html) ip: _127.0.0.1_ port: _2222_ username: _ubuntu_ password: _ubuntu_.


# **Troubleshooting**

stuur mij voornu een slack bericht: _maxvanderschee_


**undefinde developer:** dit kan voorkomen bij mac, ga naar `settings .`
