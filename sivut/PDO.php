<?php

class Database {

	// Määritellään $link muuttujalle arvo null
	private static $link = null ;

	// Luodaan funktio getLink, joka palauttaa $link arvon, jos se on true
	private static function getLink ( ) {
		if ( self :: $link ) {
			return self :: $link ;
		}

		// Määritellään asetustiedosto
		$ini = "pdo_settings.ini" ;
			
		// Määritetään, muuttujalle asetustiedoston sisältö, jos tiedostoa ei löydy annettaan virheilmoitus
		//$parse = parse_ini_file ( $ini , TRUE ) ;
		if (!$parse = parse_ini_file($ini, TRUE,INI_SCANNER_TYPED)) throw new exception('Ei pystytty avaamaan tiedostoa ' . $ini . '.');
			
		// Annetaan muuttujille arvot asetustiedostosta
		$driver = $parse [ "db_driver" ] ;
		$dsn = "${driver}:" ;
		$user = $parse [ "db_user" ] ;
		$password = $parse [ "db_password" ] ;
		$options = $parse [ "db_options" ] ;
		$attributes = $parse [ "db_attributes" ] ;

		// Luodaan [dsn] lohkon avulla $dsn muuttujan parametrit
		foreach ( $parse [ "dsn" ] as $k => $v ) {
			$dsn .= "${k}=${v};" ;
		}

		// Avataan uusi PDO yhteys annetuilla arvoilla
		self :: $link = new PDO ( $dsn, $user, $password, $options ) ;
		
		
		// Käydään attribuutit läpi ja ajetaan ne
		foreach ( $attributes as $k => $v ) {
		
			self :: $link -> setAttribute ( constant ( "{$k}" )
			, constant ( "{$v}" ) );
			//echo ( "link -> setAttribute (" .$k.", ".$v. ")" );
		}
		
		
		// Palautetaan $link (yhteys)
		return self :: $link ;

} // getLink

	// Pyytää linkin tiedon array listaan
	public static function __callStatic ( $name, $args ) {
		$callback = array ( self :: getLink ( ), $name ) ;
		return call_user_func_array ( $callback , $args ) ;
	}

	// Yksinkertainen funtio, joka testaa onko yhteys päällä
	public function isConnected()
	{
		try {
			return (bool) Database::query('SELECT 1+1');
		} catch (PDOException $e) {
			return FALSE;
		}
	} // isConnected
} // Database

?>