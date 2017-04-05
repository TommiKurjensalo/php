<!DOCTYPE html> 
 <html> 
  <head> 
   <meta charset="UTF-8"> 
    <title>Hei maailma!</title> 
	<style>
		.wrapper { 
		font-size:10em;
		margin:0.1em;
		padding:0.1em;
		text-align:center;
		background:grey;
		}
	</style>
  </head> 
<body> 
	<div class="wrapper">
	<form action="helloWorld.php" method="get">
	
	<?php
	if (isset($_GET["RefreshOn"])) {

               # Päivitetään sivu 1s välein
               $url1=$_SERVER['REQUEST_URI'];
               header("Refresh: 1; URL=$url1");

	} elseif (isset($_GET["RefreshOff"])) {
		header("location: helloWorld.php");
		exit;
	} else {

		print("<p>Hello World!</p>");

		# Määritetään timezone
		date_default_timezone_set("Europe/Helsinki");

		# Muokataan ja esitellään aika ja haetaan sille arvo
		# H = tunnit 24h muodossa, m = minuutit ja s = sekunnit
		$aika = date("H:m:s");

		# Tallennetaan muuttujaan $paiva date-funtion avulla muotoiltu sekunttiaika vuodesta 1970
		# d = päivä, m = kuukaudet ja Y = vuodet
		$paiva = date("d.m.Y");

		# Tulostetan muuttujan aika ja paiva arvo näytölle
		print ("Aika: $aika <br/> Päivä: $paiva");
	?>
	</div>
	<input type="submit" name="RefreshOn" value="Refresh On">
	<input type="submit" name="RefreshOff" value="Refresh Off">
	</form>
</body> 
</html>
