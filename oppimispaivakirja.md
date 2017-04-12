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
