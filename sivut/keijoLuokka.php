<?php
require_once "PDO.php";

class Keijo {
	
	// luokan attribuutit
	private $keijoNimi = "";
	private $keijoKovaKasi = "";
	private $keijoTulos = array();
	
	
	// Luokan konstruktori keijoLuokka toimintoa varten
	public function __construct($uusiKeijoNimi="", $uusiKeijoKovaKasi = "")
	{
		// trim poistaa tyhjät merkkijonon alusta ja lopusta
		$this->keijoNimi = trim($uusiKeijoNimi);
		$this->keijoKovaKasi = trim($uusiKeijoKovaKasi);
	}
	
	// Muuttaa/asettaa keijoNimi-attribuutin
	public function setKeijoNimi($uusiKeijoNimi) {
		$this->keijoNimi = $uusiKeijoNimi;
	}
	
	// Palauttaa keijoNimi-attribuutin
	public function getKeijoNimi() {
		return $this->keijoNimi;
	}
	
	// Muuttaa/asettaa keijoKovaKasi-attribuutin
	public function setKeijoKovaKasi($uusiKeijoKovaKasi) {
		$this->keijoKovaKasi = $uusiKeijoKovaKasi;
	}
	
	// Palauttaa keijoKovaKasi-attribuutin
	public function getKeijoKovaKasi() {
		return $this->keijoKovaKasi;
	}
	
	
	// Kovakäsi metodi
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
//	if (isset($_COOKIE["isDebug"])) {
		echo "<div style='padding-left:300px;'> nimi: ".$keijoNimi. " pw: " .$keijoKovaKasi. "<br>";
		echo "SELECT keijoNimi, keijoKovaKasi
			FROM keijo
			WHERE (keijoNimi = \"".$keijoNimi."\"
			AND keijoKovaKasi = \"".$keijoKovaKasi."\");</div>";
			
		echo '<br>';
//	}
	
	// Käsitellän/siirretään saatu tulos $keijo olioon
	while ($rivi = $stmt->fetchObject()) {
		$keijo = new Keijo();
		$keijo->setKeijoNimi(utf8_encode($rivi->keijoNimi));
		$keijo->setKeijoKovaKasi(utf8_encode($rivi->keijoKovaKasi));
	
		if (strtolower($keijoNimi) == strtolower($rivi->keijoNimi) && strtolower($keijoKovaKasi) == strtolower($rivi->keijoKovaKasi)) {
		$keijoTulos[0] = $stmt->rowCount();
		$keijoTulos[1] = true;
		
	} else {
		$keijoTulos[0] = $stmt->rowCount();
		$keijoTulos[1] = false;
	
	}
	}
	return $keijoTulos;
	/*
	if (strtolower($keijoNimi) == strtolower($this->getKeijoNimi()) && strtolower($keijoKovaKasi) == strtolower($this->getKeijoKovaKasi())) {
		$keijoTulos[0] = $stmt->rowCount();
		$keijoTulos[1] = "yes";
		return $keijoTulos;
	} else {
		$keijoTulos[0] = $stmt->rowCount();
		$keijoTulos[1] = "no";
		return $keijoTulos;
	}

	*/


	} // function keijollaOnKovaKasi
} // Luokka Keijo
?>
