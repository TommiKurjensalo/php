<?php
# Käynnistetään sessio
session_start();

# Määritetään $page muuttujalle, että haetaan sivu palvelimelta ja käytetään nykyistä sivua
$page = $_SERVER['PHP_SELF'];

# Jos painiketta RefreshOn on painettu ja arvo on numeerinen, 
# tallennetaan session muuttujalle $sekunnit annettu arvo
if (isset($_POST["RefreshOn"]) && is_numeric($_POST['sekunnit'])) {
	$_SESSION['sekunnit'] = $_POST['sekunnit'];
	}
	# Jos painiketta RefreshOn on painettu ja arvo ei ole numeerinen,
	# tallennetaan $errorMsg muuttujalle virheilmoitus, joka esitetään näytölle
	elseif (isset($_POST["RefreshOn"]) && !is_numeric($_POST['sekunnit'])) {
		$_SESSION['sekunnit'] = "";
		$errorMsg = "Syötetty arvo ei ole numeerinen";
	}
		# Jos painiketta RefreshOff on painettu, tallennetaan session muuttujalle $sekunnit arvo ""(s)
		# ja tyhjennetään $errorMsg muuttujan virheilmoitus
		elseif (isset($_POST["RefreshOff"])) {
			$_SESSION['sekunnit'] = "";
			$errorMsg = "";
		}

?>
<!DOCTYPE html> 
 <html> 
  <head>
  	<!--  Määritetään <meta> tagiin saatu refresh arvo ja content arvoksi haluttu sivu  -->
    <meta charset="UTF-8" http-equiv="refresh" content="<?php echo $_SESSION["sekunnit"]?>;URL='<?php echo $page?>'">
    <title>Hei maailma!</title> 
	
	<!-- Tyylimäärityksiä, normaalisti nämä on erillisessä css tiedostossa -->
	<style>
		.wrapper { 
		font-size:8em;
		margin:0.1em auto;
		text-align:center;
		background:grey;
		}
		.btn {
		width: 20em;
		height: 3em;
		}
		.heighttext {
		height: 1.5em;
		font-size: 1.5em;
		}
		.errorMsg {
		color:red; 
		font-size:0.8em;
		}
	</style>
  </head> 
<body> 
	<div class="wrapper">
	<!--  Lomake lähettää tiedot helloWorld.php tiedostolle, joka käyttää lähetysmetodia post  -->
	<form action="helloWorld.php" method="post">
	<!--  Määritetään Refresh On ja Refresh off painikkeet  -->
		<p style="font-size:0.1em; padding-top:1em;"><input type="submit" class="btn" name="RefreshOn" value="Refresh On">
		Päivitys tiheys (s)? : <input type="text" name="sekunnit" size="5" class="heighttext"> 
		<input type="submit" class="btn" name="RefreshOff" value="Refresh Off"></p>
	</form>

<?php
		
		# Jos $errorMsg on määritelty, tulostetaan se näytölle
		if(isset($errorMsg)) {
			echo "<p class='errorMsg'>$errorMsg</p>";
		} 
			# Muutoin tyhjennetään $errorMsg sisältö
			else {
				$errorMsg = "";
			}
		
		# Tulostetaan Hello World! teksti
		print("<p>Hello World!</p>");

		# Määritetään timezone Europe/Helsinki
		date_default_timezone_set("Europe/Helsinki");

		# Muokataan ja esitellään aika ja haetaan sille arvo
		# H = tunnit 24h muodossa, i = minuutit ja s = sekunnit
		$aika = date("H:i:s", time());

		# Tallennetaan muuttujaan $paiva date-funtion avulla muotoiltu sekunttiaika vuodesta 1970
		# d = päivä, m = kuukaudet ja Y = vuodet
		$paiva = date("d.m.Y", time());

		# Tulostetan muuttujan $aika ja $paiva arvot näytölle
		print ("Aika: $aika <br/> Päivä: $paiva");
	?>
	</div>
</body> 
</html>