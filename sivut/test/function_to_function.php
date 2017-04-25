<?php

$m = new Muokkaa("Asiakas 987","asiakas@jee.org","040-988474","02","03","2017","332","3","Lisätietoa");

$m->muokkaaAsiakas($m);

class Muokkaa {
	
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
	public function __construct9($uusiAsiakkaanNimi = "", $uusiSahkopostiosoite = "", $uusiPuhelinNumero = "",
			$uusiPaiva = "", $uusiKuukausi = "", $uusiVuosi = "",
			$uusiLevytila = "", $uusiKayttoJarjestelma = "", $uusiLisatietoa = "")
	{
	
		// trim poistaa tyhjät merkkijonon alusta ja lopusta
		//$this->lisaaId = ($uusiId);
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
	
	// Luokan konstruktori haeAsiakas toimintoa varten
	public function __construct2($uusiId="", $uusiAsiakkaanNimi = "")
	
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
		if ($required === FALSE && strlen($this->asiakkaanNimi) == 0)
			return 0;
	
		if ($required === TRUE) {
			// Jos kenttä on tyhjä
			if (strlen($this->asiakkaanNimi) == 0)
				return 1;
				
			// Jos kentässä on liian vähän tai liikaa merkkejä
			if (strlen($this->asiakkaanNimi) < $min || strlen($this->asiakkaanNimi) > $max)
				return 2;
				
			// Jos kentässä on sinne kuulumattomia merkkejä
			if (preg_match("/[^a-zåäöA-ZÅÄÖ0-9 \-]/", $this->asiakkaanNimi))
				return 3;
	
		}
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
		if ($required === FALSE && strlen($this->sahkopostiosoite) == 0)
			return 0;
	
		if ($required == TRUE) {
			// Jos kenttä on tyhjä
			if (strlen($this->sahkopostiosoite) == 0)
				return 4;
	
			// Jos kentässä on sinne kuulumattomia merkkejä
			// Hyväksytyt merkit ovat A-Z a-z 0-9 . - ja maatunnus 2-4 merkkiä (A-Z a-z)
			if (!preg_match('/^[A-Öa-ö0-9._-]+@[A-Öa-ö0-9.-]+\.[A-Za-z]{2,4}$/', $this->sahkopostiosoite))
				return 5;
	
		}
			
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
	
	public function checkPuhelinNumero($required, $min, $max) {
	
		// Jos kenttä saa olla tyhjä ja se on tyhjä, ei ole virhettä
		if ($required === FALSE && strlen($this->puhelinNumero) == 0)
			return 0;
	
		if ($required === TRUE) {
			// Jos kenttä on tyhjä
			if (strlen($this->puhelinNumero) == 0)
				return 6;
	
			// Jos kentässä on liian vähän merkkejä/numeroita
			if (strlen($this->puhelinNumero) < $min || strlen($this->puhelinNumero) > $max) {
				return 20;
			}
			// Jos kentässä on sinne kuulumattomia merkkejä
			// Sallittu vain numerot 0-9, välilyönti ja välimerkki '-'
			elseif (!preg_match('/^(\d){0,4}[-]{1}[(\d\s)]{0,17}$/D', $this->puhelinNumero)) {
				return 7;
			}
	
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
	
	
		if ($required === TRUE) {
			// Jos kentät on tyhjiä
	
			if (strpos($this->paiva, 'none') !==FALSE || strpos($this->kuukausi, 'none') !==FALSE
					|| strpos($this->vuosi, 'none') !==FALSE) {
						return 8;
					}
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
		}
		// Muuten palautetaan 0, aka kaikki hyvin
		return 0;
	}
	
	public function setErotteleAsennusPaivamaara($asennusPaivamaara) {
	
		if (!empty($asennusPaivamaara)) {
			list($uusiVuosi,$uusiKuukausi,$UusiPaiva) = explode(".",$asennusPaivamaara);
				
			$this->setPaiva($UusiPaiva);
			$this->setKuukausi($uusiKuukausi);
			$this->setVuosi($uusiVuosi);
		}
	
	
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
		if ($required === FALSE && strlen($this->levytila) == 0)
			return 0;
	
		if ($required === TRUE) {
			// Jos kenttä on tyhjä
			if (strlen($this->levytila) == 0)
				return 10;
	
			// Jos kentässä on sinne kuulumattomia merkkejä
			if (preg_match("[\d{1-5}]", $this->levytila))
				return 11;
				
			// Jos levytila on 0 tai negatiivinen kokonaisluku
			if ($this->levytila <= 0)
				return 21;
		}
	
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
		if ($required === FALSE && strlen($this->kayttoJarjestelma) == 0)
			return 0;
	
		if ($required === TRUE) {
			// Jos käyttöjärjestelmää ei ole valittu
			if (strpos($this->kayttoJarjestelma, 'none') !==FALSE)
				return 12;
		}
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
	
	public function checkLisatietoa ($required, $min, $max) {
	
		// Jos kenttä saa olla tyhjä ja se on tyhjä, ei ole virhettä
		if ($required === FALSE && strlen($this->lisatietoa) == 0)
			return 0;
	
	
		if ($required === TRUE) {
			// Jos kenttä on tyhjä
			if (strlen($this->lisatietoa) == 0)
				return 13;
	
			// Jos kentässä on liian vähän tekstiä
			if (strlen($this->lisatietoa) < $min || strlen($this->lisatietoa) > $max)
				return 14;
	
		}
		// Ei ollut virheitä
		return 0;
	}

public function muokkaaAsiakas($muokkaa) {

	$tulos = array();
	$data = array();
	$table = 'lisaa';
	$where = 'lisaaId=:lisaaId';

	echo "<br>";
	var_dump($muokkaa);
	
	echo "<br><br>";

	echo (!empty($muokkaa->getAsiakkaanNimi()) ? 'asnimi asetettu '.$data["asiakkaanNimi"]=":asiakkaanNimi" :'asnimi ei asetettu');
	echo "<br>";
	echo (!empty($muokkaa->getSahkopostiosoite()) ? 'email asetettu '.$data["sahkopostiosoite"]=":sahkopostiosoite" :'email ei asetettu');
	echo "<br>";
	echo (!empty($muokkaa->getPuhelinNumero()) ? 'puh asetettu '.$data["puhelinNumero"]=":puhelinNumero" :'puh ei asetettu');
	echo "<br>";
	echo ((!empty($muokkaa->getPaiva()) && !empty($muokkaa->getKuukausi()) && !empty($muokkaa->getVuosi()))
	? 'pvm asetettu ' .$data["asennusPaivamaara"]=":asennusPaivamaara" : ' aspvm syöttäminen epäonnistui');
	echo "<br>";
	echo (!empty($muokkaa->getLevytila()) ? 'hdd asetettu '.$data["levytila"]=":levytila" :'hdd ei asetettu');
	echo "<br>";
	echo (!empty($muokkaa->getLisatietoa()) ? 'info asetettu '.$data["lisatietoa"]=":lisatietoa" :'info ei asetettu');
	
	echo "<br><br>";
	var_dump($data);
	echo "<br><br>";
	
	
	$data2 = ["lisaaId" => ":lisaaId","asiakkaanNimi" => ":asiakkaanNimi","sahkopostiosoite"=>":sahkopostiosoite","puhelinNumero"=>":puhelinNumero",
			"asennusPaivamaara"=>":asennusPaivamaara","levytila"=>":levytila","lisatietoa"=>":lisatietoa"];

	function build_sql_update($table, $data, $where)
	{
		$cols = array();
	
		foreach($data as $key=>$val) {
			$cols[] = "$key = '$val'";
		}
		$sql = "UPDATE $table SET " . implode(', ', $cols) . " WHERE $where";
	
		return $sql;
	}

	$sql_lisaa = build_sql_update($table,$data,$where);
	//$sql_lisaa = Muokkaa::build_sql_update($table, $data, $where);
	echo "<br><br>";
	var_dump($sql_lisaa);
}	
}
?>