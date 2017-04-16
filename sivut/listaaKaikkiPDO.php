<?php
	
class Database {

		private static $link = null ;
	
		private static function getLink ( ) {
			if ( self :: $link ) {
				return self :: $link ;
			}
	
			$ini = "pdo_settings.ini" ;
			
			$parse = parse_ini_file ( $ini , true ) ;
			if (!$parse = parse_ini_file($ini, TRUE)) throw new exception('Ei pystytty avaamaan tiedostoa ' . $ini . '.');
			
			

	
			$driver = $parse [ "db_driver" ] ;
			$dsn = "${driver}:" ;
			$user = $parse [ "db_user" ] ;
			$password = $parse [ "db_password" ] ;
			$options = $parse [ "db_options" ] ;
			$attributes = $parse [ "db_attributes" ] ;
	
			foreach ( $parse [ "dsn" ] as $k => $v ) {
				$dsn .= "${k}=${v};" ;
	}
	
	self :: $link = new PDO ( $dsn, $user, $password, $options ) ;
	
	
	foreach ( $attributes as $k => $v ) {
		self :: $link -> setAttribute ( constant ( "PDO::{$k}" )
		, constant ( "PDO::{$v}" ) ) ;
	}

	return self :: $link ;
	
	
	}
	
	public static function __callStatic ( $name, $args ) {
		$callback = array ( self :: getLink ( ), $name ) ;
		return call_user_func_array ( $callback , $args ) ;
	}
	
	public function isConnected()
	{
		try {
			return (bool) Database::query('SELECT 1+1');
		} catch (PDOException $e) {
			return false;
		}
	}
}

class listaaPDO {
	
	
	public function haeKaikkiAsiakkaat() {
	
		// Tehdään kysely
		$sql = "SELECT l.lisaaId,l.asiakkaanNimi,l.sahkopostiosoite,l.puhelinNumero,
   				k.kayttoJarjestelmaNimi,l.asennusPaivamaara,l.levytila,l.lisatietoa
				FROM lisaa_kayttojarjestelma lk
				INNER JOIN lisaa l on l.lisaaId=lk.lisaaId
				INNER JOIN kayttojarjestelma k on k.kayttoJarjestelmaId=lk.kayttoJarjestelmaId
				ORDER BY lk.lisaaId ASC";
	
	
		
		// Valmistellaan lause
		$stmt = Database :: prepare($sql);
		
	
		// Jos nimi on syötetty, käytetään hakuehtona asiakkaan nimi kentässä olevaa arvoa
		//$stmt->bindValue(":asiakkaanNimi", utf8_decode($lisaa->getAsiakkaanNimi()), PDO::PARAM_STR);
	
			if (! $stmt = Database :: prepare($sql)) {
			$virhe = Database :: errorInfo();
		
			throw new PDOException($virhe[2], $virhe[1]);
		}
	
		// Ajetaan lauseke
		if (! $stmt->execute()) {
			$virhe = $stmt->errorInfo();
	
			throw new PDOException($virhe[2], $virhe[1]);
		}
	
		$tulos = array();
		while ($rivi = $stmt->fetchObject()) {
			$lisaa = new Lisaa();
			$lisaa->setLisaaId($rivi->lisaaId);
			$lisaa->setAsiakkaanNimi(utf8_encode($rivi->asiakkaanNimi));
			$lisaa->setSahkopostiosoite(utf8_encode($rivi->sahkopostiosoite));
			$lisaa->setPuhelinNumero(utf8_encode($rivi->puhelinNumero));
			$lisaa->setKayttoJarjestelma(utf8_encode($rivi->kayttoJarjestelmaNimi));
			$lisaa->setAsennusPaivamaara(utf8_encode($rivi->asennusPaivamaara));
			$lisaa->setLevytila(utf8_encode($rivi->levytila));
			$lisaa->setLisatietoa(utf8_encode($rivi->lisatietoa));
				
			$tulos[] = $lisaa;
		}
		$this->lkm = $stmt->rowCount();
		//$stmt -> closeCursor ();
		return $tulos;
	} // haeKaikkiAsiakkaat
	
	public function haeAsiakas($asiakkaanNimi) {
		
		// Tehdään kysely
		$sql = "SELECT l.lisaaId,l.asiakkaanNimi,l.sahkopostiosoite,l.puhelinNumero,
   				k.kayttoJarjestelmaNimi,l.asennusPaivamaara,l.levytila,l.lisatietoa
				FROM lisaa_kayttojarjestelma lk
				INNER JOIN lisaa l on l.lisaaId=lk.lisaaId
				INNER JOIN kayttojarjestelma k on k.kayttoJarjestelmaId=lk.kayttoJarjestelmaId
				WHERE l.asiakkaanNimi like :asiakkaanNimi
				ORDER BY lk.lisaaId ASC";
		
		
		
		// Valmistellaan lause
		$stmt = Database :: prepare($sql);
		
		
		echo '$sql ' .$sql;
		
		
		if (! $stmt = Database :: prepare($sql)) {
			$virhe = Database :: errorInfo();
		
			throw new PDOException($virhe[2], $virhe[1]);
		}
		
		// Jos nimi on syötetty, käytetään hakuehtona asiakkaan nimi kentässä olevaa arvoa
		
		(empty($asiakkaanNimi) && ($asiakkaanNimi ==null)) ? $stmt->bindValue(":asiakkaanNimi", utf8_decode("%"), PDO::PARAM_STR)
				: $stmt->bindValue(":asiakkaanNimi", utf8_decode("%$asiakkaanNimi%"), PDO::PARAM_STR);
		
		echo ' ** asiakkaanNimi: '. '"%'.$asiakkaanNimi.'%"';
		
		// Ajetaan lauseke
		if (! $stmt->execute()) {
			$virhe = $stmt->errorInfo();
		
			throw new PDOException($virhe[2], $virhe[1]);
		}
		
		$tulos = array();
		while ($rivi = $stmt->fetchObject()) {
			$lisaa = new Lisaa();
			$lisaa->setLisaaId($rivi->lisaaId);
			$lisaa->setAsiakkaanNimi(utf8_encode($rivi->asiakkaanNimi));
			$lisaa->setSahkopostiosoite(utf8_encode($rivi->sahkopostiosoite));
			$lisaa->setPuhelinNumero(utf8_encode($rivi->puhelinNumero));
			$lisaa->setKayttoJarjestelma(utf8_encode($rivi->kayttoJarjestelmaNimi));
			$lisaa->setAsennusPaivamaara(utf8_encode($rivi->asennusPaivamaara));
			$lisaa->setLevytila(utf8_encode($rivi->levytila));
			$lisaa->setLisatietoa(utf8_encode($rivi->lisatietoa));
		
			$tulos[] = $lisaa;
		}
		$this->lkm = $stmt->rowCount();
		//$stmt -> closeCursor ();
		return $tulos;
		
	} // haeAsiakas
	
	public function lisaaAsiakas($lisaa) {
		
		// kesken puuttuu käyttöjärjestelmän lisäys !!
		// Tehdään kysely 
		$sql = "INSERT INTO LISAA (lisaaId,asiakkaanNimi,sahkopostiosoite,puhelinNumero,
   				asennusPaivamaara,levytila,lisatietoa)
				VALUE (:lisaaId,:asiakkaanNimi,:sahkopostiosoite,:puhelinNumero,
   				:asennusPaivamaara,:levytila,:lisatietoa)";
		
		// Valmistellaan lause
		$stmt = $this->PDOExt->prepare($sql);
	
		
		if (! $stmt = $this->PDOExt->prepare($sql)) {
			$virhe = $this->PDOExt->errorInfo();
		
			throw new PDOException($virhe[2], $virhe[1]);
		}
		
		
		$stmt->bindValue(":asiakkaanNimi", utf8_decode($lisaa->getAsiakkaanNimi()), PDO::PARAM_STR);
		$stmt->bindValue(":sahkopostiosoite", utf8_decode($lisaa->getSahkopostiosoite()), PDO::PARAM_STR);
		$stmt->bindValue(":puhelinNumero", $lisaa->getPuhelinNumero(), PDO::PARAM_STR);
		$stmt->bindValue(":kayttoJarjestelmaNimi", $lisaa->getKayttoJarjestelma(), PDO::PARAM_STR);
		$stmt->bindValue(":asennusPaivamaara", $lisaa->getAsennusPaivamaara(), PDO::PARAM_STR);
		$stmt->bindValue(":levytila", $lisaa->getLevytila(), PDO::PARAM_INT);
		$stmt->bindValue(":lisatietoa", utf8_decode($lisaa->getLisatietoa()), PDO::PARAM_STR);
		
		// Ajetaan lauseke
		if (! $stmt->execute()) {
			$virhe = $stmt->errorInfo();
		
			if ($virhe[0] == "HY093") {
				$virhe[2] = "Invalid parameter";
			}
			
			throw new PDOException($virhe[2], $virhe[1]);
		}
		
		$this->lkm = 1;
		return $this->db->lastInsertId();
		
	} // function lisaaAsiakas
	

} // class listaaPDO


class asdPDO implements JsonSerializable {
	public function jsonSerialize() {
		return array (
				"lisaaId" => $this->lisaaId,
				"asiakkaanNimi" => $this->asiakkaanNimi,
				"sahkopostiosoite" => $this->sahkopostiosoite,
				"puhelinNumero" => $this->puhelinNumero,
				"kayttoJarjestelmaNimi" => $this->kayttoJarjestelmaNimi,
				"asennusPaivamaara" => $this->asennusPaivamaara,
				"levytila" => $this->levytila,
				"lisatietoa" => $this->lisatietoa
		);
	}
}

?>