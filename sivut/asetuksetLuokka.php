<?php
require_once "PDO.php";

class Asetukset {
public function lisaaTestiAsiakkaita() {

// *** lisaa ja lisaa_kayttojarjestelma taulun lisäys
$y=0; // muuttuja käyttöjärjestelmä id:tä varten
	
for ($i=1;$i<=10;$i++) {
	// Luodaan SQL kysely tietojen lisäystä varten
	$sql_lisaa = "INSERT INTO lisaa (asiakkaanNimi,sahkopostiosoite,puhelinNumero,
                        		asennusPaivamaara,levytila,lisatietoa)
                               	VALUE (:asiakkaanNimi,:sahkopostiosoite,:puhelinNumero,
                                :asennusPaivamaara,:levytila,:lisatietoa);";

	// Valmistellaan lause
	$stmt_lisaa = Database :: prepare($sql_lisaa);

	// Jos lausetta ei ole onnistuneesti valmisteltu, annetaan virheilmoitus
	if (! $stmt_lisaa = Database :: prepare($sql_lisaa)) {
		$virhe_lisaa = Database :: errorInfo();

		throw new PDOException($virhe_lisaa[2], $virhe_lisaa[1]);
	}
	
	// Asetetaan asiakkaan nimi Asiakas?
	$stmt_lisaa->bindValue(":asiakkaanNimi", utf8_decode("Asiakas".$i), PDO::PARAM_STR);

	// Asetetaan sähköposti
	$stmt_lisaa->bindValue(":sahkopostiosoite", utf8_decode("asiakas".$i."@asiakas.org"), PDO::PARAM_STR);

	// Asetetaan puhelinnumero
	$stmt_lisaa->bindValue(":puhelinNumero", utf8_decode("040-123 45".$i), PDO::PARAM_STR);

	// Asetetaan asennuspäivämäärä
	$stmt_lisaa->bindValue(":asennusPaivamaara", utf8_decode("2016-05-" .$i), PDO::PARAM_STR);

	// Asetetaan levytila 20x Gt
	$stmt_lisaa->bindValue(":levytila", utf8_decode("20".$i), PDO::PARAM_INT);
	

	// Asetetaan lisatietoa
	$stmt_lisaa->bindValue(":lisatietoa", utf8_decode("Lisätietoja koskien asiakasta".$i), PDO::PARAM_STR);
	
	$tulos = array();

	// Jos SQL kyselylausekkeen ajo epäonnistuu, näytetään virheviesti
	if (! $stmt_lisaa->execute()) {
		$virhe_lisaa = $stmt_lisaa->errorInfo();
		$tulos[] = $virhe_lisaa;

		if ($virhe_lisaa[0] == "HY093") {
			$virhe_lisaa[2] = "Invalid parameter";
		}
		throw new PDOException($virhe_lisaa[2], $virhe_lisaa[1]);
	} else {
		$tulos[] = "lisaa ok";
	}

	// debuggausta varten
	if (isset($_COOKIE["isDebug"])) {
		echo "<br>var_dump: ".	var_dump($lisaa). "<br>";
		echo "INSERT INTO lisaa (lisaaId,asiakkaanNimi,sahkopostiosoite,puhelinNumero,
				asennusPaivamaara,levytila,lisatietoa)
				VALUE (:lisaaId,\"".$lisaa->getAsiakkaanNimi()."\",\"" .$lisaa->getSahkopostiosoite(). "\",\"" .$lisaa->getPuhelinNumero()."\",
				\"".$asennusPaivamaara."\",\"".$lisaa->getLevytila()."\",\"".$lisaa->getLisatietoa()."\");";
			
		echo '<br>';
	}
	
	// Määritellään kayttojarjestelmaId välille 1-4
	// Loopataan numeroiden 1-4 välillä
	if ($y >=4) { $y=1; } else { $y++; }
	
	// SQL lauseke
	$sql_linkkaus = "INSERT INTO lisaa_kayttojarjestelma (kayttoJarjestelmaId,lisaaId)
                     VALUE (:kayttoJarjestelmaId,:lisaaId);";
	
	// Valmistellaan lause
	$stmt_linkkaus = Database :: prepare($sql_linkkaus);
	
	// Jos lausetta ei ole onnistuneesti valmisteltu, annetaan virheilmoitus
	if (! $stmt_linkkaus = Database :: prepare($sql_linkkaus)) {
		$virhe_linkkaus = Database :: errorInfo();
	
		throw new PDOException($virhe_linkkaus[2], $virhe_linkkaus[1]);
	}
	
	// Asetetaan käyttöjärjestelmä id
	$stmt_linkkaus->bindValue(":kayttoJarjestelmaId", utf8_decode($y), PDO::PARAM_STR);
	
	// Asetetaan lisaa id
	$stmt_linkkaus->bindValue(":lisaaId", utf8_decode(Database::lastInsertId()), PDO::PARAM_INT);

	// Jos SQL kyselylausekkeen ajo epäonnistuu, näytetään virheviesti
	if (! $stmt_linkkaus->execute()) {
		$virhe_linkkaus = $stmt_linkkaus->errorInfo();
		$tulos[] = $virhe_linkkaus;
		if ($virhe_linkkaus[0] == "HY093") {
			$virhe_linkkaus[2] = "Invalid parameter";
		}

		throw new PDOException($virhe_linkkaus[2], $virhe_linkkaus[1]);
	} else {
		$tulos[] = "lisaa_kayttojarjestelma ok";
	}
	
	if (isset($_COOKIE["isDebug"])) {
		echo "INSERT INTO lisaa_kayttojarjestelma (kayttoJarjestelmaId,lisaaId)
              VALUE (\"".$y."\",\"".Database::lastInsertId()."\");";
	}

} // .for loop 


	$this->lkm = $stmt_lisaa->rowCount();
	$tulos[] = $this->lkm;
	return $tulos;

} // function lisaaTestiAsiakkaita
}
?>