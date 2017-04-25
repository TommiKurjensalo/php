<?php
require_once "PDO.php";

class Muokkaa {
	
	// Virhekoodit
	public static $virhelista = array(
			-1 => "Virheellinen tieto",
			0 => "",
			1 => "Nimi ei voi olla tyhjä",
			2 => "Nimi on liian pitkä tai lyhyt, min 3 merkkiä ja maksimissaan 50 merkkiä",
			3 => "Nimessä voi olla vain kirjaimia, numeroita, välilyöntejä ja väliviiva",
			4 => "Sähköpostiosoite ei voi olla tyhjä",
			5 => "Sähköpostiosoite on virheellinen, hyväksytyt merkit ovat (A-Z a-z 0-9 .-) ja maatunnus 2-4 merkkiä (A-Z a-z)",
			6 => "Puhelinnumero ei voi olla tyhjä",
			7 => "Puhelinnumerossa voi olla vain numeroita, välilyönti ja väliviiva",
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
	private $muokkaaId = "";
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
			
			list($uusiVuosi,$uusiKuukausi,$uusiPaiva) = explode('-',$asennusPaivamaara);
			
			$this->paiva = $uusiPaiva;
			$this->kuukausi = $uusiKuukausi;
			$this->vuosi = $uusiVuosi;
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
	// Muuttaa/asettaa kayttoJarjestelmaId-attribuutin
	public function setKayttoJarjestelmaId($uusiKayttoJarjestelma) {
		$this->kayttoJarjestelma = $uusiKayttoJarjestelma;
	}
	
	// Palauttaa kayttoJarjestelmaId-attribuutin
	public function getKayttoJarjestelmaId() {
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
	
	/*
	 *  Hae asiakkaat
	 */
	
	public function haeAsiakaat() {
	
		// Muodostetaan SQL kyselylause
		$sql = "SELECT l.lisaaId,l.asiakkaanNimi,l.sahkopostiosoite,l.puhelinNumero,
   				k.kayttoJarjestelmaId,l.asennusPaivamaara,l.levytila,l.lisatietoa
				FROM lisaa_kayttojarjestelma lk
				INNER JOIN lisaa l on l.lisaaId=lk.lisaaId
				INNER JOIN kayttojarjestelma k on k.kayttoJarjestelmaId=lk.kayttoJarjestelmaId
				ORDER BY lk.lisaaId ASC;";
	
		// Valmistellaan lause
		$stmt = Database :: prepare($sql);
	
	
		// Jos lausetta ei ole onnistuneesti valmisteltu, annetaan virheilmoitus
		if (! $stmt = Database :: prepare($sql)) {
			$virhe = Database :: errorInfo();
	
			throw new PDOException($virhe[2], $virhe[1]);
		}
	
	
		// Jos SQL kyselylausekkeen ajo epäonnistuu, näytetään virheviesti
		if (! $stmt->execute()) {
			$virhe = $stmt->errorInfo();
	
			throw new PDOException($virhe[2], $virhe[1]);
		}
	
		// Käsitellän/siirretään saatu tulos array taulukkoon

		$tulos = array();
		while ($rivi = $stmt->fetchObject()) {
			$muokkaa = new Muokkaa();
			$muokkaa->setLisaaId($rivi->lisaaId);
			$muokkaa->setAsiakkaanNimi(utf8_encode($rivi->asiakkaanNimi));
			$muokkaa->setSahkopostiosoite(utf8_encode($rivi->sahkopostiosoite));
			$muokkaa->setPuhelinNumero(utf8_encode($rivi->puhelinNumero));
			$muokkaa->setAsennusPaivamaara(utf8_encode($rivi->asennusPaivamaara));
			$muokkaa->setErotteleAsennusPaivamaara(utf8_encode($rivi->asennusPaivamaara));
			$muokkaa->setLevytila(utf8_encode($rivi->levytila));
			$muokkaa->setKayttoJarjestelmaId(utf8_encode($rivi->kayttoJarjestelmaId));
			$muokkaa->setLisatietoa(utf8_encode($rivi->lisatietoa));
	
			$tulos[] = $muokkaa;
		}
	
		// debuggausta varten
		if (isset($_COOKIE["isDebug"])) {
			echo "var_dump: ".var_dump($tulos)."<br>";
			echo "<br>".'"SELECT l.lisaaId,l.asiakkaanNimi,l.sahkopostiosoite,l.puhelinNumero,
   				k.kayttoJarjestelmaId,l.asennusPaivamaara,l.levytila,l.lisatietoa
				FROM lisaa_kayttojarjestelma lk
				INNER JOIN lisaa l on l.lisaaId=lk.lisaaId
				INNER JOIN kayttojarjestelma k on k.kayttoJarjestelmaId=lk.kayttoJarjestelmaId
				ORDER BY lk.lisaaId ASC;';
			echo '<br>';
				
		}
		
		$this->lkm = $stmt->rowCount();
		return $tulos;
	
	} // haeAsiakaat
	
	/*
	 * Muokkaa asiakas
	 */
	
public function muokkaaAsiakas($muokkaa) {

	$tulos = array();
	$data = array();
	$table = 'lisaa';
	$where = 'lisaaId=:lisaaId';
	
	// Tarkistetaan onko tieto syötetty ja jos on, niin laitetaan arvo arraylistaan
	(!empty($muokkaa->getAsiakkaanNimi()) ? $data["asiakkaanNimi"]=":asiakkaanNimi" :'');
	
	(!empty($muokkaa->getSahkopostiosoite()) ? $data["sahkopostiosoite"]=":sahkopostiosoite" :'');
	
	(!empty($muokkaa->getPuhelinNumero()) ? $data["puhelinNumero"]=":puhelinNumero" :'');
	
	((!empty($muokkaa->getPaiva()) && !empty($muokkaa->getKuukausi()) && !empty($muokkaa->getVuosi()))
	? $data["asennusPaivamaara"]=":asennusPaivamaara" : ' ');
	
	(!empty($muokkaa->getLevytila()) ? $data["levytila"]=":levytila" :'');
	
	(!empty($muokkaa->getLisatietoa()) ? $data["lisatietoa"]=":lisatietoa" :'');
	
	// Funktio, jolla luodaan UPDATE sql lauseke saatujen syöttötietojen perusteella
		function build_sql_update($table, $data, $where)
		{
			$cols = array();
		
			foreach($data as $key=>$val) {
				$cols[] = "$key = $val";
			}
			$sql = "UPDATE $table SET " . implode(', ', $cols) . " WHERE $where;";
		
			return $sql;
		}
		// Luodaan UPDATE sql lauseke
		$sql_lisaa = build_sql_update($table,$data,$where);
		
		
		$sql_linkkaus = "UPDATE lisaa_kayttojarjestelma 
                         	SET kayttoJarjestelmaId=:kayttoJarjestelmaId WHERE lisaaId=:lisaaId;";
		
		// Valmistellaan lauseet
		$stmt_lisaa = Database :: prepare($sql_lisaa);
		$stmt_linkkaus = Database :: prepare($sql_linkkaus);
		
		// Luodaan pvm muuttuja, jossa on vuosi,kk ja päivä arvot
		$asennusPaivamaara = $muokkaa->getVuosi().'-'.$muokkaa->getKuukausi().'-'.$muokkaa->getPaiva();
		
		// Bindataan arvot sql lauseelle
		$stmt_lisaa->bindValue(":asiakkaanNimi", utf8_decode($muokkaa->getAsiakkaanNimi()), PDO::PARAM_STR);
		$stmt_lisaa->bindValue(":sahkopostiosoite", utf8_decode($muokkaa->getSahkopostiosoite()), PDO::PARAM_STR);
		$stmt_lisaa->bindValue(":puhelinNumero", utf8_decode($muokkaa->getPuhelinNumero()), PDO::PARAM_STR);
		$stmt_lisaa->bindValue(":asennusPaivamaara", utf8_decode($asennusPaivamaara), PDO::PARAM_STR);
		$stmt_lisaa->bindValue(":levytila", utf8_decode($muokkaa->getLevytila()), PDO::PARAM_INT);
		$stmt_lisaa->bindValue(":lisatietoa", utf8_decode($muokkaa->getLisatietoa()), PDO::PARAM_STR);
		$stmt_lisaa->bindValue(":lisaaId", utf8_decode($muokkaa->getLisaaId()), PDO::PARAM_INT);
		
		// debuggausta varten
		if (isset($_COOKIE["isDebug"])) {
			echo "<br>var_dump muokkaa: ";	var_dump($muokkaa);
			echo "<br>";
			echo "var_dump sql_lisaa: "; var_dump($sql_lisaa);
			echo "<br>";
			echo "var_dump sql_linkkaus: "; var_dump($sql_linkkaus);			
			echo '<br>';
		}
			
	
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
		
		// Bindataan arvot sql lauseelle
		$stmt_linkkaus->bindValue(":kayttoJarjestelmaId", utf8_decode($muokkaa->getKayttoJarjestelmaId()), PDO::PARAM_STR);
		$stmt_linkkaus->bindValue(":lisaaId", utf8_decode($muokkaa->getLisaaId()), PDO::PARAM_INT);
		
		// Jos SQL kyselylausekkeen ajo epäonnistuu, näytetään virheviesti
		if (! $stmt_linkkaus->execute()) {
			$virhe_linkkaus = $stmt_linkkaus->errorInfo();
			$tulos[] = $virhe_linkkaus;
		
		
			if ($virhe_lisaa[0] == "HY093") {
				$virhe_lisaa[2] = "Invalid parameter";
			}
			throw new PDOException($virhe_lisaa[2], $virhe_lisaa[1]);
		} else {
			$tulos[] = "lisaa ok";
		}
		
		$this->lkm = $stmt_lisaa->rowCount() + $stmt_linkkaus->rowCount();
		$tulos[] = $this->lkm;
		
		return $tulos;
	
	
	} // function muokkaaAsiakas
	
	
	
} // Muokkaa luokka
?>