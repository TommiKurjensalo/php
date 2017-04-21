<?php

session_start();

$required = TRUE;
echo 'req: '; var_dump($required); 

// Onko painettu tallenna-painiketta
if (isset($_POST["tallenna"])) {
   // Viedään muodostimelle kenttien arvot
	$_SESSION["pvm"] = $_POST["pvm"];
	$_SESSION["kk"] = $_POST["kk"];
	$_SESSION["vuosi"] = $_POST["vuosi"];


	session_write_close();
	echo "<br>";
	echo 'ennen ($required === TRUE)';
	echo "<br>";
	
	echo '($required === TRUE) = ', ($required === TRUE) ? 'tosi':'eitosi';
	echo '<br>pvm: ', (strpos($_SESSION["pvm"], 'none') !== false) ? 'tosi' : 'eitosi';
	echo '<br>kk: ', (strpos($_SESSION["kk"], 'none') !== false) ? 'tosi' : 'eitosi';
	echo '<br>vuosi: ', (strpos($_SESSION["vuosi"], 'none') !== false) ? 'tosi' : 'eitosi';
	echo "<br>";
	if ($required === true) {
	        // Jos kentät on tyhjiä
	        echo 'ennen if strpos';
	        echo "<br>";
	        if (strpos($_SESSION["pvm"], 'none') !== FALSE || strpos($_SESSION["kk"], 'none') !== FALSE || strpos($_SESSION["vuosi"], 'none') !== FALSE) {

	       		$virhe="kentät on tyhjiä";
	       		$_SESSION["virhe"]=$virhe;
	       		echo $_SESSION["virhe"];
	       //	return $_SESSION["virhe"];
	       } else {
	       		$virhe="kentät ei ole tyhjiä";
	       		$_SESSION["virhe"]=$virhe;
	       		echo $_SESSION["virhe"];
	       //		return $_SESSION["virhe"];
	       }
	       echo '<br>jälkeen if strpos';
	}
}  elseif (isset ($_POST["tallenna"])) {
	echo 'elseif isset $_post tallenna';
	if (isset ($_SESSION["pvm"]) && isset($_SESSION["kk"]) && isset($_SESSION["vuosi"]) ) {
		$_SESSION = array();
		
		if (isset ( $_COOKIE [session_name ()] )) {
			setcookie ( session_name (), '', time () - 100, '/' );
		}
		
		session_destroy ();
		header ( "Location: strposTest.php" );
		exit();
		
	} else {
		if (isset ( $_SESSION ["tallenna"] )) {
				$_SESSION["pvm"] = $_POST["pvm"];
				$_SESSION["kk"] = $_POST["kk"];
				$_SESSION["vuosi"] = $_POST["vuosi"];
				}
	}
  }

?>

<!DOCTYPE html>
<html lang="en">
	<head>

    <meta charset="utf-8">

    <title>strposTest</title>

	</head>
	<body>
<h1>strpos testi</h1>


<form role="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
<input name="pvm" type="text" value="none"/> <input name="kk" type="text" value="none"/> <input name="vuosi" type="text" value="none"/>

<input name="tallenna" type="submit" value="Tallenna"/>
</form>

<br><br>
<p>Required: <?php var_dump($required) ?></p>
<br><br>

<p>pvm:<b> <?php echo (!empty($_SESSION["pvm"]) ? $_SESSION["pvm"] : 'e'); ?></b>
	kk:<b> <?php echo (!empty($_SESSION["kk"]) ? $_SESSION["kk"] : 'e'); ?></b>
 vuosi:<b> <?php echo (!empty($_SESSION["vuosi"]) ? $_SESSION["vuosi"] : 'e'); ?> </b></p>
<p>virhe:<b> <?php echo (!empty($virhe) ? $virhe : 'e'); ?> </b></p>

	</body>
</html>