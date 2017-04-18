<?php

class Lisaa {
	
	// Virhekoodit
	public static $virhelista = array(
			-1 => "Virheellinen tieto",
			0 => "",
			1 => "Nimi ei voi olla tyhjä",
			2 => "Nimi on liian pitkä tai lyhyt, min 3 merkkiä ja maksimissaan 50 merkkiä",
			3 => "Nimessä voi olla vain kirjaimia, välilyöntejä ja '-'",
			4 => "Sähköpostiosoite ei voi olla tyhjä",
			5 => "Sähköpostiosoite on virheellinen, hyväksytyt merkit ovat (A-Z a-z 0-9 .-) ja maatunnus 2-4 merkkiä (A-Z a-z)",
			6 => "Puhelinnumero ei voi olla tyhjä",
			7 => "Puhelinnumerossa voi olla vain numeroita ja '-' (väliviiva)",
			8 => "Asennuspäivämäärä ei voi olla tyhjä",
			9 => "Asennuspäivämäärä ei voi olla tulevaisuudessa",
			10 => "Levytilan määritys ei voi olla tyhjä",
			11 => "Levytilan kentässä voi olla vain numeroita",
			12 => "Käyttöjärjestelmää ei ole valittu",
			13 => "Lisatietoa ei voi olla tyhjä",
			14 => "Lisatietoa on liian lyhyt (min 10 merkkiä) tai liia pitkä (max 500 merkkiä)",
			20 => "Puhelinnumero on liian lyhyt (min 8 merkkiä) tai liian pitkä (max 20 merkkiä)",
			21 => "Levytila ei voi olla 0 tai negatiivinen kokonaisluku",
	);
	
	// Metodi palauttaa virhekoodia vastaavan tekstin
	public static function getVirhe($virhekoodi) {
		if (isset(self::$virhelista[$virhekoodi]))
			return self::$virhelista[$virhekoodi];
	
		return self::$virhelista[-1];
	}
		
	
	
	// luokan attribuutit
	private $lisaaId = "";
	private $asiakkaanNimi = "";
	private $sahkopostiosoite = "";
	private $puhelinNumero = "";
	private $asennusPaivamaara = "";
	private $paiva = "";
	private $kuukausi = "";
	private $vuosi = "";
	private $levytila = "";
	private $kayttoJarjestelma = "";
	private $lisatietoa = "";
	private $NykyHetki = "";
	
	// Etsitään sopiva konstruktori
	function __construct() {
		$get_arguments       = func_get_args();
		$number_of_arguments = func_num_args();
	
		if (method_exists($this, $method_name = '__construct'.$number_of_arguments)) {
			call_user_func_array(array($this, $method_name), $get_arguments);
		}
	}
	
	
	// Luokan konstruktori
	public function __construct10($uusiId="", $uusiAsiakkaanNimi = "", $uusiSahkopostiosoite = "", $uusiPuhelinNumero = "", 
			$uusiPaiva = "", $uusiKuukausi = "", $uusiVuosi = "",
			$uusiLevytila = "", $uusiKayttoJarjestelma = "", $uusiLisatietoa = "") 
		{

		// trim poistaa tyhjät merkkijonon alusta ja lopusta
		$this->lisaaId = ($uusiId);
		$this->asiakkaanNimi = trim($uusiAsiakkaanNimi);
		$this->sahkopostiosoite = trim($uusiSahkopostiosoite);
		$this->puhelinNumero = trim($uusiPuhelinNumero);
		$this->paiva = trim($uusiPaiva);
		$this->kuukausi = trim($uusiKuukausi);
		$this->vuosi = trim($uusiVuosi);
		$this->levytila = trim($uusiLevytila);
		$this->kayttoJarjestelma = trim($uusiKayttoJarjestelma);
		$this->lisatietoa = trim($uusiLisatietoa);		
	}
	
	// Luokan konstruktori listaaKaikki toimintoa varten
	public function __construct6($uusiId="", $uusiAsiakkaanNimi = "",
			$uusiPaiva = "", $uusiKuukausi = "", $uusiVuosi = "",
			$uusiKayttoJarjestelma = "")
	{

		// trim poistaa tyhjät merkkijonon alusta ja lopusta
		$this->lisaaId = ($uusiId);
		$this->asiakkaanNimi = trim($uusiAsiakkaanNimi);
		$this->paiva = trim($uusiPaiva);
		$this->kuukausi = trim($uusiKuukausi);
		$this->vuosi = trim($uusiVuosi);
		$this->kayttoJarjestelma = trim($uusiKayttoJarjestelma);
	}
	
	// Muuttaa/asettaa lisaaId-attribuutin
	public function setLisaaId($uusiId) {
		$this->lisaaId = $uusiId;
	}
	
	// Palauttaa lisaaId-attribuutin
	public function getLisaaId() {
		return $this->lisaaId;
	}
	
	// Muuttaa/asettaa asiakkaanNimi-attribuutin
	public function setAsiakkaanNimi($uusiAsiakkaanNimi) {
		$this->asiakkaanNimi = $uusiAsiakkaanNimi;
	}
	
	// Palauttaa asiakkaanNimi-attribuutin
	public function getAsiakkaanNimi() {
		return $this->asiakkaanNimi;
	}
	

	// $empty kertoo, saako kenttä olla tyhjä (FALSE=>ei saa olla eli on pakollinen)
	// $min kertoo kentän minimipituuden merkkeinä
	// $max kertoo kentän maksimipituuden merkkeinä
	public function checkAsiakkaanNimi($required, $min, $max) {
	
		// Jos kenttä saa olla tyhjä ja se on tyhjä, ei ole virhettä
		if ($required == FALSE && strlen($this->asiakkaanNimi) == 0) 	
			return 0;
		
		// Jos kenttä on tyhjä
		if (strlen($this->asiakkaanNimi) == 0)
			return 1;
		
		// Jos kentässä on liian vähän tai liikaa merkkejä
		if (strlen($this->asiakkaanNimi) < $min || strlen($this->asiakkaanNimi) > $max)
			return 2;
		
		// Jos kentässä on sinne kuulumattomia merkkejä
		if (preg_match("/[^a-zåäöA-ZÅÄÖ \-]/", $this->asiakkaanNimi))
			return 3;
		
		// Ei ollut virheitä
		return 0;
		
	}
	
	// *******************************************************
	// Muuttaa/asettaa sahkopostiosoite-attribuutin
	public function setSahkopostiosoite($uusiSahkopostiosoite) {
		$this->sahkopostiosoite = $uusiSahkopostiosoite;
	}
	
	// Palauttaa sahkopostiosoite-attribuutin
	public function getSahkopostiosoite() {
		return $this->sahkopostiosoite;
	}
	
	public function checkSahkopostiosoite($required) {
	
		// Jos kenttä saa olla tyhjä ja se on tyhjä, ei ole virhettä
		if ($required == FALSE && strlen($this->sahkopostiosoite) == 0) 
			return 0;
		
		// Jos kenttä on tyhjä
		if (strlen($this->sahkopostiosoite) == 0) 
			return 4;
		
		// Jos kentässä on sinne kuulumattomia merkkejä		
		// Hyväksytyt merkit ovat A-Z a-z 0-9 . - ja maatunnus 2-4 merkkiä (A-Z a-z)
		if (!preg_match('/^[A-Öa-ö0-9._-]+@[A-Öa-ö0-9.-]+\.[A-Za-z]{2,4}$/', $this->sahkopostiosoite))
			return 5;
		
			
		return 0;
	}
	
	// *******************************************************
	// Muuttaa/asettaa puhelinNumero-attribuutin
	public function setPuhelinNumero($uusiPuhelinNumero) {
		$this->puhelinNumero = $uusiPuhelinNumero;
	}
	
	// Palauttaa puhelinNumero-attribuutin
	public function getPuhelinNumero() {
		return $this->puhelinNumero;
	}
	
	public function checkPuhelinNumero($required, $min = 8, $max = 20) {
	
		// Jos kenttä saa olla tyhjä ja se on tyhjä, ei ole virhettä
		if ($required == FALSE && strlen($this->puhelinNumero) == 0)
			return 0;
	
		// Jos kenttä on tyhjä
		if (strlen($this->puhelinNumero) == 0)	
			return 6;
	
		// Jos kentässä on liian vähän merkkejä/numeroita
		if (strlen($this->puhelinNumero) < $min || strlen($this->puhelinNumero) > $max) {
			return 20;
		}
		// Jos kentässä on sinne kuulumattomia merkkejä
		// Sallittu vain numerot 0-9 ja välimerkki '-'
		elseif (!preg_match('/^(\d){0,4}[-]{1}(\d){0,17}$/D', $this->puhelinNumero)) {
			return 7;
		}
		
		// Ei ollut virheitä
		return 0;
	}
	
	// *******************************************************
	// Muuttaa/asettaa asennusPaivamaara-attribuutin
	public function setAsennusPaivamaara($uusiAsennusPaivamaara) {
		$this->asennusPaivamaara = $uusiAsennusPaivamaara;
	}
	
	// Palauttaa asennusPaivamaara-attribuutin
	public function getAsennusPaivamaara() {
		return $this->asennusPaivamaara;
	}
	
	// *******************************************************
	// Muuttaa/asettaa paiva-attribuutin
	public function setPaiva($uusiPaiva) {
		$this->paiva = $uusiPaiva;
	}
	
	// Palauttaa paiva-attribuutin
	public function getPaiva() {
		return $this->paiva;
	}
	
	// *******************************************************
	// Muuttaa/asettaa kuukausi-attribuutin
	public function setKuukausi($uusiKuukausi) {
		$this->kuukausi = $uusiKuukausi;
	}
	
	// Palauttaa kuukausi-attribuutin
	public function getKuukausi() {
		return $this->kuukausi;
	}
	
	// *******************************************************
	// Muuttaa/asettaa vuosi-attribuutin
	public function setVuosi($uusiVuosi) {
		$this->vuosi = $uusiVuosi;
	}
	
	// Palauttaa vuosi-attribuutin
	public function getVuosi() {
		return $this->vuosi;
	}
	
	// Palauttaa nykyhetki-attribuutin
	// Käytetään testaukseen
	public function getNykyHetki() {
		return $this->NykyHetki;
	}
	
	public function checkAsennusPaivamaara($required) {
	
		
		// Jos kentät saa olla tyhjiä ja se on tyhjä, ei ole virhettä
		if ($required == FALSE && strpos($this->paiva, 'none') !==FALSE || strpos($this->kuukausi, 'none') !==FALSE || strpos($this->vuosi, 'none') !==FALSE)
			return 0;
	
		
		// Jos kentät on tyhjiä
		if (strpos($this->paiva, 'none') !==FALSE || strpos($this->kuukausi, 'none') !==FALSE || strpos($this->vuosi, 'none') !==FALSE)
			return 8;
		
		// Määritellään muuttujia päivämäärän tulevaisuuden tarkistamista varten
		$paivaFormaatti='j.n.Y';
		$nykyHetki = new DateTime('now', new DateTimeZone('Europe/Helsinki'));
		// Muutetaan tuodut päivä,kuukausi ja vuositiedot DateTime muotoon, jotta sitä voidaan helpommin vertailla
		// ja viedä yhdellä muuttujalle tiedot sivulle
		$DateAsennusPaivamaara = DateTime::createFromFormat($paivaFormaatti,"$this->paiva.$this->kuukausi.$this->vuosi");
		$this->asennusPaivamaara = $DateAsennusPaivamaara;
		$this->NykyHetki = $nykyHetki;
		
		// Jos asetettu päivämääärä on tulevaisuudessa
		if($DateAsennusPaivamaara > $nykyHetki) 
			return 9;
			
		// Muuten palautetaan 0, aka kaikki hyvin
		return 0;
	}
	
	// *******************************************************
	// Muuttaa/asettaa levytila-attribuutin
	public function setLevytila($uusiLevytila) {
		$this->levytila = $uusiLevytila;
	}
	
	// Palauttaa levytila-attribuutin
	public function getLevytila() {
		return $this->levytila;
	}
	
	public function checkLevytila($required) {
	
		// Jos kenttä saa olla tyhjä ja se on tyhjä, ei ole virhettä
		if ($required == FALSE && strlen($this->levytila) == 0)
			return 0;
	
		// Jos kenttä on tyhjä
		if (strlen($this->levytila) == 0)
			return 10;
	
		// Jos kentässä on sinne kuulumattomia merkkejä
		if (preg_match("[\d{1-5}]", $this->levytila))
			return 11;
		
		// Jos levytila on 0 tai negatiivinen kokonaisluku
		if ($this->levytila <= 0)
			return 21;
	
		return 0;
	}
	
	// *******************************************************
	// Muuttaa/asettaa kayttoJarjestelma-attribuutin
	public function setKayttoJarjestelma($uusiKayttoJarjestelma) {
		$this->kayttoJarjestelma = $uusiKayttoJarjestelma;
	}
	
	// Palauttaa kayttoJarjestelma-attribuutin
	public function getKayttoJarjestelma() {
		return $this->kayttoJarjestelma;
	}
	
	public function checkKayttoJarjestelma($required) {
	
		// Jos kenttä saa olla tyhjä ja se on tyhjä, ei ole virhettä
		if ($required == FALSE && strlen($this->kayttoJarjestelma) == 0)
			return 0;
	
		// Jos käyttöjärjestelmää ei ole valittu
		if ($required == TRUE && strpos($this->kayttoJarjestelma, 'none') !==FALSE) 
			return 12;
		
		// Ei ollut virheitä
		return 0;
	}
	
	// *******************************************************
	// Muuttaa/asettaa kayttoJarjestelma-attribuutin
	public function setLisatietoa($uusiLisatietoa) {
		$this->lisatietoa = $uusiLisatietoa;
	}
	
	// Palauttaa kayttoJarjestelma-attribuutin
	public function getLisatietoa() {
		return $this->lisatietoa;
	}
	
	public function checkLisatietoa ($required, $min = 10, $max = 500) {
	
		// Jos kenttä saa olla tyhjä ja se on tyhjä, ei ole virhettä
		if ($required == FALSE && strlen($this->lisatietoa) == 0)
			return 0;
	
		// Jos kenttä on tyhjä
		if (strlen($this->lisatietoa) == 0)
			return 13;
	
		// Jos kentässä on liian vähän tekstiä
		if (strlen($this->lisatietoa) < $min || strlen($this->lisatietoa) > $max)
			return 14;
	
		// Ei ollut virheitä
		return 0;
	}
	
}
?>