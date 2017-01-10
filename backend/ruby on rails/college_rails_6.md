## Git en Gitflow

Let op, voor de kenners, ik ga niet de volledige officiele git flow methode uitleggen, maar een enigsinds verkapte versie die meer gericht is op praktisch gebruik binnen de minor. (geen hotfix branches of release branches)

Git is een er handig tooltje, je kan er samen mee code schrijven! En je kan tegelijk aan hetzelfde bestand werken en later alles weer samenvoegen (mergen)(yay!). Voor de mensen die GIT nog niet zo goed kennen en een merge conflict krijgen is het echter best wel schrikken, maar het is juist niet erg! GIT heeft zelf een workflow ontworpen die je leven een stuk makkelijker maakt, hij werkt als volgt:

<img src="https://raw.githubusercontent.com/Voronenko/gitflow-release/master/images/git-workflow-release-cycle-4maintenance.png" alt="gitflow">

Je verdeelt je project in meerdere branches, daarvan de belangrijkste:

````
- MASTER
- DEVELOP
- Feature branches
````

Op de MASTER branch mag alleen volledige werkend code staan, dat is een handige regel om te hebben. Wanneer je code uitcheckt en draait, moet alles 100% werken. Dit is ook vaak wat je live op je server hebt staan. Alles wat op MASTER staat is getest werkt en mag niet mee geprutst worden. Alles wat in MASTER staat was ooit een FEATURE en zat eerst in DEVELOP.

De Develop branch is afgesplitst van MASTER, op deze branch mag code die in ontwikkeling is nog getest worden, het kan ook gezien worden als een test omgeving. Alle code wordt ook vaak tegen een database met dummydata uitgevoerd, hier mag nog wel het 1 en ander stuk gaan, maar moet wel weer opgelost worden.

Een FEATURE branch is een los stukje code wat je afsplitst van de develop branch.
Zie dit als bijvoorbeeld een taak dat je van SCRUM hebt gekregen. Het inbouwen van een login formulier, een mooi taakje.

Wat je dan doet, je maakt een feature vanaf develop.

````
git checkout develop
git branch feature/login-formulier-maken
````

Nu zit je op je eigen branch, ga lekker bezig en wanneer je echt kaar bent merge je de feature weer in develop

````
git checkout develop
git merge feature/login	-formulier-maken
````

BAM, je code zit in develop, daarna ga je in overleg met je medeprogrammeurs een release maken. Stel alles wat in develop staat is goedgekeurd en getest, dan mag develop met MASTER gemerged worden. (release afsplitsen)

````
git checkout master
git merge develop --no-ff (geen fast forwards)
````

en hoppa, alles wat in de develop branch staat is staat nu op master!


## Git instellen op de server

Voor het deployen van onze applicatie gaan we gebruik maken van digitalocean.
Digital ocean heeft namelijk 1 click images, ze doen al erg veel werk voor je.
Wel handig voor een snelle deploy van je project.

https://www.digitalocean.com/community/tutorials/how-to-use-the-ruby-on-rails-one-click-application-on-digitalocean


Om ons project vanaf git te halen moeten we eerst onze public key toevoegen aan de server, genereer een public key als volgt:

`ssh-keygen -t rsa -b 4096 -C "tjerk.dijkstra@gmail.com"`

Druk dan op enter, bij passphrase verzin een makkelijk wachtwoord (langer dan 4 tekens)

en voila, bekijk vervolgens deze ssh key met

`cat ~/.ssh/id_rsa.pub`

En kopieer deze en voeg deze toe aan deze pagina.

`https://github.com/settings/ssh`

Op deze manier weet github dat deze server toegang heeft tot je GIT projecten.



