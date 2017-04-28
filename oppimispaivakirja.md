# 27.4.2017

Saatu vihdoin ja viimein korjattua bugit, jotka vain kumuloitu toisiinsa aivan liian pitkälle.

Nyt toimii, ainakin käytännön mukaan logout jokaiselta sivulta, cookiet ja virheilmoituksia ei tule.
Oikeastaan kaikki mitkä vähän jumitteli, on nyt korjattuna.

Lisätty kello yläkulmaan ja tieto, koska sessio vanhenee.

Aikaa meni 6 tuntia.

# 26.4.2017

Kun aloin korjaamaan bugeja, alkoi vikoja löytymään vähän sieltä sun täältä. Sessiot ja cookiet ei toiminut oikein, eikä muokkaa sivu.
Ei meinaa tajuta kuinka sessiot ja cookiet oikeesti toimivat ja kuinka niitä voi poistaa.

Sql update käskyn luominen dynaamisesti meinaisi aiheuttaa harmaita hiuksia. Ei tahtonut toimia sitten millään, 
vaan aina herjasi, että  Invalid parameter number: parameter was not defined.

Tapellessani meni 10 tuntia. 

# 25.4.2017

SE ON TÄMÄ TÄSSÄ ! SIVU ON TARPEEKSI VALMIS JA VOIMAT ON LOPPU !

* Muokkaa sivu valmis

Pirun vaikeeta oli tajuta kuinka php käsittelee sivuja ja kuinka luoda järkevä dynaaminen sql lauseke.

Ne ihanat heittomerkit, niin yksöis ja kaksois on aiheuttanut kokoajan ongelmia.

Ongelmia on vielä jonkunverran (ehkä) session aikojen kanssa.

Toki salasanat pitäisi salata kantaan ja käsittelyssä, mutta taitaa olla toinen projekti se.

Aikaa meni 8tuntia.

# 24.4.2017

* Muokkaa sivua aloitettu.

Tajusin pitkän testailun jälkeen, että php sivu latautuu oikeasti ylhäältä alaspäin ja että funktioita tai arvoja ei voi käyttää
ellei ne ole vielä latautuneet, ts. pyyntö on ennen arvoa/metodia.

Ongelmia saada muuttujia, arraylistoja, olioita siirtymään php sivun sisässä toisiin php lohkoihin.

Aikaa meni 8tuntia.

# 23.4.2017

* Tehty login sivu valmiiksi, hyödyntäen sessio ja cookie ominaisuuksia

* Lisätty logoff toiminto jokaiselle sivulle

* Korjattu login/logout ongelma (jälkikäteen)

Siinä se aika sitten menikin kun ihmetteli funktioita, syntakseja ja useamman yritys/erehdyksen kautta
tajusi kuinka homma voisi toimia.

Enää puuttuu muokkaus sivun tekeminen ja homma on valmis.

Aikaa meni 8tuntia.

# 22.4.2017

* Lisätty asiakkaan poisto toiminto Hae / Poista valikkoon

* Lisätty "luo 10 testi asiakasta" Asetukset valikkoon

Tänään kaikki meni suhteellisen kivasti, pientä säätöä on aina, mutta ei tullut lukkoja.

Toisin kuin eilen, en ole enää 100% varma, että teenko hae / poista sivulle myös muokkaus ominaisuuden vai en.
Ajatuksissa oli luoda oma nappula, jota painamalla asiakkaan tiedot siirrettäisiin Muokkaa sivulle.

Aikaa meni 4 tuntia.

# 21.4.2017

* Tehty asetukset sivu, lisätty "debug tila on/off"

* Muokattu Listaa kaikki menuvalinta -> Hae / Poista

Tämä siksi, koska ajattelin hyödyntää nykyistä hakusivua siihen, että siitä voi valita asiakkaan muokattavaksi
tai sitten poistaa asiakastieto.

* Lisätty cookie / sessio toimintoja lisää ja asetukset sivuille

Aikaa meni 7 tuntia.

# 20.4.2017

* Korjattu asennuspäivämäärä kentässä oleva virheentarkistus ongelma

* Nyt painike "tallenna" vie tiedon kantaan asti (ei vielä 100% valmis toiminto)

Ongelmaksi muodostui tietokannan luontilausekkeen ja bindvalue ominaisuuksien käyttö, koska
joudun lisäämään kahteen eri otteeseen tietoa.

Asennuspäivämääräkentän validointi korjaantui if lausekkeiden paikkoja vaihtamalla, sitä ennen olin
jo testannut vaikka mitä. Muunmuassa tein testi php sivun jossa testailin strpos tarkistusta if lauseen sisällä.
Löytyy muuten test/strposTest.php.

Tehty myös kaikkea pientä viilausta, kaikkea ei voi edes muistaa.

Aikaa meni taas 5-6 tuntia.

# 19.4.2017

* Koululla yritetty opetella sessioita ja cookien merkityksiä

* Yritetty lisätä kantaan lisäys toimintoa, mutta en ehtinyt tehdä kuin vain osan metodista

* Siirretty PDO omaan luokkaansa

* Lisätty Lisää sivulle sessiot, ja tämän aikana hajosi asennuspäivämääräkentän validointi.
Ihmetelty mitä kävi, ei selvinnyt.

Aikaa meni se 3tuntia.

# 18.4.2017

* Muokattu käyttöjärjestelmä valikkojen value numeroksi, jotta tietojen lisäys olisi tulevaisuudessa helpompaa

* Vaihdettu listaaKaikki.php->listaaKAikkiPDO.php tietojen vienti yksittäisistä muuttujista olioksi

* Tehty __functio constructori, joka sallii useamman kuin yhden konstruktorin käytön

* Korjattu class Database, nyt toimii myös attribuutin PDO::ATTR_EMULATE_PREPARES='false' lisäys

Samaa toistoa, syntaksien käyttö on haastavaa laittaa oikein.

Haasteita oli myös erittäin runsaasti olio pohjaisen tiedon siirto sivun ja luokan välillä, varsinkin kun eclipse luna EI näyttänyt 
mitään metodeja ko. luokasta vaikka laittoi $obj-> käskyn.

Syyksi paljastui lopulta mm. juurikin tuo, että eclipse ei vain näytä niitä. Myöskin require_once käsky uupui luokasta.

Ongelmana oli myös se, että kun listaaKaikki sivulta ei tuoda kaikkia tietoja, niin oletus konstruktorihan laittoi tiedot vääriin kohtiin.
Kun sain tämän osan toimimaan, niin alkoi myös muutkin hommat menemään eteenpäin.

Pitäisi melkein olla joku debug on/off nappula sivulla, niin saisi tietoja esille kun ongelmia ilmenee.

Aikaa meni 5 tuntia.

# 17.4.2017

* Tapeltu varmaankin 4 tuntia olio pohjaisen tietojen siirrossa.

* Tehty haeAsiakas metodiin kaikkien parametrien tarkastukset ja tietojen validoinnit.

Perkeleen oliot, ei tajua heitä...

Aikaa meni 8 tuntia.

# 16.4.2017

* Tehty haeAsiakas (yksittäistä) metodia

* Muokattu päivämäärää näkymään pp.kk.vvvv muotoon

Aikaa meni 2tuntia

# 15.4.2017

* Lisätty "listaa kaikki" sivu, joka hakee tiedot tietokannasta

* Luotu tietokannat

Oli kyllä paljon ihmetystä, että kuinka tuo tietokanta homma toimii kun ohjeet oli hiukan epäselvät.

Epäselvillä tarkoitan sitä, että vaihtoehtoja oli useampi. JSON tapaa en ole vielä edes tutkinut sen tarkemmin, tosin olen lisännyt sivulle jo tarpeelliset script rivit.

PDO käsittelyssäkin oli hämmennystä aiheuttavia asioita, koska halusin, että tietokanta tiedot ovat eri tiedostossa, eikä luokan sisällä.

Aikaa meni 7tuntia.

# 14.4.2017

* Korjattu ongelma vuosien "valuminen" alaspäin ja kuukausien palautuminen "none" arvoon.

* Korjattu logiikkoja ja syntakseja.

* Muutettu tapaa kuinka sähköpostiosoitetta tarkistetaan, palattu takaisin pereg_match metodiin.

Käytetty sivu läpi w3 validaattorista, korjattu ongelmat joita on syytä korjata.

Jäljelle jäävät ongelmat olivat:

    Error: A document must not include both a meta element with an http-equiv attribute whose value is 
    content-type, and a meta element with a charset attribute.

    From line 8, column 5; to line 8, column 70

    f-8">↩    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">↩ <

    Warning: The navigation role is unnecessary for element nav.

    From line 64, column 9; to line 64, column 78

    >↩        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">↩

    Warning: The form role is unnecessary for element form.

    From line 116, column 25; to line 116, column 119

    <form class="inline-form" role="form" action="/tommi_kurjensalo/sivut/lisaa.php" method="post">↩↩

Ensimmäiseen ei tarvitse [stackoverflow](http://stackoverflow.com/questions/18007771/how-do-i-fix-error-a-charset-attribute-on-a-meta-element-found-after-the-first "stackoverflow - how-do-i-fix-error-a-charset-attribute-on-a-meta-element-found-after-the-first") mukaan korjata, koska ongelma piilee validator sivussa.

Kaksi viimeistä taas on ns. turhia, koska nämä roolien merkitykset on hyvä säilyttää muita selaimia ja laitteita varten.

Lopputulos on silti hyvä, aluksi minulla oli noin 20 virhettä.

Aikaa meni 4tuntia.

# 13.4.2017

* Korjattu asennuspäivämääräkentissä oleva arvon palautus ja tarkitus ongelmat. Syynä oli jälleen syntaxit ja logiikka ongelmat.

* Tosin nyt tapahtuu sitä, että kun tallenna painikettaa painaa 2x, alkaa vuosi "valumaan" 1vuosi alaspäin per kerta ja kuukausi valinta palautuu "none" valitaan.

Aikaa meni 7tuntia.

# 12.4.2017

Oppitunnilla saatu selvitettyä ongelmia liittyen päivämääräkenttiin.

Nyt toimii "tieto ei syötetty" ja "pvm tulevaisuudessa" tarkistukset.

Syntaxien kanssa on aina ongelmia ja pähkäilyä, että missä järjestyksessä tulee mitäkin.

Aikaa meni 3 tuntia.

# 11.4.2017

* Muutettu sähköpostiosoitteen tarkastustapaa.

* Lisätty bootstrap-select ja input painonappien overlay ominaisuus (ikoneita varten)

* Lisätty syöttökenttiin virhetekstit ja punaiset värit.

* Palautetaan kaikkiin muihin paitsi päivämääräkenttiin arvot, jos syötetyt tiedot olivat väärin.

* Lisätty ikonit kenttien eteen.

* Tuunattu ulkoasua.

Vaikeaa oli löytää joku tapa käsitellä sähköpostin kenttää, pereg_match on aikasta tuskasta. Käytän nyt "if (!filter_var($email, FILTER_VALIDATE_EMAIL)" tapaa, en tiedä onko hyvä mutta.. katsotaan.

Virhetekstit jo oli olemassa ja ne tulostukin sivun oikealle puolelle, mutta niiden siirto kenttien alle samalla muokaten kentän ulkoreunoja punaisiksi ei ollut jälleen kerran helppoa.

Tietojen palautus kenttiin oli <option> kentän osalta vaikeaa, siksi en vielä tiedä teeenkö sitä päivämäärä kenttään, koska pp,kk ja vvvv tiedot on omissa kentissään. Kyseinen lohko sisältää php:ta tarpeeksi, niin ehkä myöhemmin leikin sen kanssa lisää.

Kaikean kaikkeaan, mikään ei ollut helppoa, mutta uutta on opittu. 

Aikaa meni 9tuntia.

# 10.4.2017

Tuli sekoiltua githubin pull & push kanssa ja alkuperäinen oppimispäiväkirja hävisi, noh onneksi siinä ei paljoa vielä ollut kirjoitusta.

* Muutettu asennuspäivämäärän syöttötapa tekstikentästä alasvetovalikoksi, jotta ei tarvitse tarkastella mm, onko tietoa syötetty ja onko se oikein.

* Kommentoitu koodia php:n osalta.

Mikään ei ollut taaskaan helppoa, aikaa meni 8tuntia.

# 9.4.2017

Tehty sivua ja yritetty opetella PHP:ta. Päiväkirja kun hävisi, niin en enää edes muista mitä tein tarkalleen. Muistain vain, että tein ja pitkään.

Aikaa meni 6untia.

# 8.4.2017

Luotu sivut valmiiksi html ja css osalta, ei vielä php-koodia.

Aikaa meni 6tuntia.

# 6.4.2017

* Asennettu xampp ja nysvätty eclipseen php tuki.

* Lysätty helloWorld.php sivuun refresh on/off valinnat ja laitettu tekstikenttä, johon voi syöttää halutun päivitystahdin sekunneissa.

Aikaa meni 7tuntia.

# 5.4.2017

Tehty helloWorld.php koulussa ja perustettu tämä github repository.
