<?php

class ExtPDO extends PDO
{
	public function __construct($file = 'pdo_setting.ini')
	{
		if (!$settings = parse_ini_file($file, TRUE)) throw new exception('Ei pystytty avaamaan tiedostoa ' . $file . '.');
		 
		$dns = $settings['database']['driver'] .
		':host=' . $settings['database']['host'] .
		((!empty($settings['database']['port'])) ? (';port=' . $settings['database']['port']) : '') .
		';dbname=' . $settings['database']['schema'];
		 
		parent::__construct($dns, $settings['database']['username'], $settings['database']['password']);
	}
}

?>