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
