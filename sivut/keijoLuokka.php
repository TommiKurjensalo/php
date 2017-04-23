<?php
require_once "PDO.php";

class Keijo {
	public function keijollaOnKovaKasi($keijoNimi,$keijoKovaKasi) {

	// Luodaan SQL kysely tietojen lisäystä varten
	$sql = "SELECT keijoNimi, keijoKovaKasi 
			FROM keijo
			WHERE (keijoNimi = :keijoNimi
			AND keijoKovaKasi = :keijoKovaKasi)";

	// Valmistellaan lause
	$stmt = Database :: prepare($sql);

	// Jos lausetta ei ole onnistuneesti valmisteltu, annetaan virheilmoitus
	if (! $stmt = Database :: prepare($sql)) {
		$virhe = Database :: errorInfo();

		throw new PDOException($virhe[2], $virhe[1]);
	}
	
	// Asetetaan keijoNimi
	$stmt->bindValue(":keijoNimi", utf8_decode($keijoNimi), PDO::PARAM_STR);

	// Asetetaan keijoKovaKasi
	$stmt->bindValue(":keijoKovaKasi", utf8_decode($keijoKovaKasi), PDO::PARAM_STR);
	
	$tulos = array();

	// Jos SQL kyselylausekkeen ajo epäonnistuu, näytetään virheviesti
	if (! $stmt->execute()) {
		$virhe = $stmt->errorInfo();
		$tulos[] = $virhe;

		if ($virhe[0] == "HY093") {
			$virhe[2] = "Invalid parameter";
		}
		throw new PDOException($virhe[2], $virhe[1]);
	} 
	
	// debuggausta varten
	if (isset($_COOKIE["isDebug"])) {
		echo "<div style='padding-left:300px;'> nimi: ".	$keijoNimi. " pw: " .$keijoKovaKasi. "<br>";
		echo "SELECT keijoNimi, keijoKovaKasi 
			FROM keijo
			WHERE (keijoNimi = \"".$keijoNimi."\"
			AND keijoKovaKasi = \"".$keijoKovaKasi."\");</div>";
			
		echo '<br>';
	}
	
	$lkm = $stmt->rowCount();

	return $lkm;

	} // function keijollaOnKovaKasi
} // Luokka Keijo
?>