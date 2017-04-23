<?php
session_start();

if (isset($_SERVER['HTTP_COOKIE']))
{
	$cookies = explode(';', $_SERVER['HTTP_COOKIE']);
	foreach($cookies as $cookie)
	{
		$mainCookies = explode('=', $cookie);
		$name = trim($mainCookies[0]);
		setcookie($name, '', time()-1000);
		setcookie($name, '', time()-1000, '/');
	}
}

// Poistetaan PHPSESSID selaimesta
if ( isset( $_COOKIE[session_name()] ) )
	setcookie( session_name(), "", time()-3600, "/" );
// Tyhjennetään sessiot globaalisti
$_SESSION = array();

// Tyhjennetään sessiot paikallisesti
session_destroy();
// Ohjataan takaisin etusivulle
header('Location: index.php');
exit;
?>