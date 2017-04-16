<?php



class ListaaKaikki22 {
	
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
	private $asiakkaanNimi = "";
	private $paiva = "";
	private $kuukausi = "";
	private $vuosi = "";
	private $kayttoJarjestelma = "";
	private $lisaaId = 0;
	
	
	// Luokan konstruktori
	function __construct($uusiAsiakkaanNimi = "", 
			$uusiPaiva = "", $uusiKuukausi = "", $uusiVuosi = "",
			$uusiKayttoJarjestelma = "", $uusiId=0) {
		// trim poistaa tyhjät merkkijonon alusta ja lopusta
		$this->asiakkaanNimi = trim($uusiAsiakkaanNimi);
		$this->paiva = trim($uusiPaiva);
		$this->kuukausi = trim($uusiKuukausi);
		$this->vuosi = trim($uusiVuosi);
		$this->kayttoJarjestelma = trim($uusiKayttoJarjestelma);
		$this->lisaaId = ($uusiId);
	}
	
	
	// Muuttaa/asettaa asiakkaanNimi-attribuutin
	public function setAsiakkaanNimi($uusiAsiakkaanNimi) {
		$this->asiakkaanNimi = $uusiAsiakkaanNimi;
	}
	
	// Palauttaa asiakkaanNimi-attribuutin
	public function getAsiakkaanNimi() {
		return $this->asiakkaanNimi;
	}
	

	// $empty kertoo, saako kenttä olla tyhjä (false=>ei saa olla eli on pakollinen)
	// $min kertoo kentän minimipituuden merkkeinä
	// $max kertoo kentän maksimipituuden merkkeinä
	public function checkAsiakkaanNimi($required = false, $min=3, $max=50) {
	
		// Jos kenttä saa olla tyhjä ja se on tyhjä, ei ole virhettä
		if ($required == false && strlen($this->asiakkaanNimi) == 0) 	
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
	
	public function checkAsennusPaivamaara($required = false) {
	
		
		// Jos kentät saa olla tyhjiä ja se on tyhjä, ei ole virhettä
		if ($required == false && strlen($this->paiva) == 0 && strlen($this->kuukausi) == 0 && strlen($this->vuosi) == 0)
			return 0;
	
		
		// Jos kentät on tyhjiä
		if (strpos($this->paiva, 'none') !==false || strpos($this->kuukausi, 'none') !==false || strpos($this->vuosi, 'none') !==false)
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
	// Muuttaa/asettaa kayttoJarjestelma-attribuutin
	public function setKayttoJarjestelma($uusiKayttoJarjestelma) {
		$this->kayttoJarjestelma = $uusiKayttoJarjestelma;
	}
	
	// Palauttaa kayttoJarjestelma-attribuutin
	public function getKayttoJarjestelma() {
		return $this->kayttoJarjestelma;
	}
	
	public function checkKayttoJarjestelma($required = true) {
	
		// Jos kenttä saa olla tyhjä ja se on tyhjä, ei ole virhettä
		if ($required == false && strlen($this->kayttoJarjestelma) == 0)
			return 0;
	
		// Jos käyttöjärjestelmää ei ole valittu
		if (strpos($this->kayttoJarjestelma, 'none') !==false) 
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
	
	
}
?>