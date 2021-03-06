<?php

require_once "../lisaaLuokka.php";
// Onko painettu tallenna-painiketta
if (isset($_POST["tallenna"])) {

	$nykyHetki = date("j.n.Y");
	$testNykyHetki = new DateTime(date("j.n.Y"));
	
	$paivaFormaatti='j.n.Y';
	$testAsennusPaivamaara = date($paivaFormaatti,strtotime($_POST["paiva"].".".$_POST["kk"].".".$_POST["vuosi"]));
	$asennusPaivamaara = DateTime::createFromFormat($paivaFormaatti,$_POST["paiva"].".".$_POST["kk"].".".$_POST["vuosi"]);
	//echo "testDate: " . $testDate;
	echo "<br>";
	echo "asennusPaivamaara: " . $asennusPaivamaara->format($paivaFormaatti) . " > " . $nykyHetki;
	echo "<br>";
	   $lisaa = new Lisaa(
   		$_POST["paiva"],
   		$_POST["kk"],
   		$_POST["vuosi"]
   		);
	//echo "testi pvm: " . date($paivaFormaatti);
	echo "this->paiva: " . $lisaa->getPaiva();
	//$tilapainenPvm = DateTime::createFromFormat('d.m.Y', $asennusPaivamaara);
 	//$tilapainenPvm = $tilapainenPvm->format('d.m.Y');
 	

		
		$paiva=$_POST['paiva'];
		$kk=$_POST['kk'];
		$vuosi=$_POST['vuosi'];
		$erotus = date_diff($asennusPaivamaara,$testNykyHetki);
		
		if($asennusPaivamaara > $testNykyHetki) {
			echo "meni tulevaisuuteen";
			echo "<br><br>";
			
			echo "erotus: " . $erotus->format('%R%a days');
		}
		
		else {
			echo "else" . "<br>";
			echo $testAsennusPaivamaara . " > " . $nykyHetki;
			echo "<br><br>";

			echo "erotus: " . $erotus->format('%R%a days');
		}
		
		
 
	
} 

// Määritellään muuttujalle pohja-arvot
//$asennusPaivamaara = "";
//phpinfo();
?>


<!DOCTYPE html>
<html lang="en">

<head>


    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Pvm test</title>
    

</head>
<body>

<form action="" method="post">
 <label>Asennuspäivämäärä</label>
<input name="asennusPaivamaara" class="form-control" type="date" value="27.03.2017"></input>
<br><br>



<?php 
date_default_timezone_set('Europe/Helsinki');
setlocale(LC_ALL, array('fi_FI.UTF-8','fi_FI@euro','fi_FI','finnish'));


// Määritetään formaatiksi %e, kun kyseessä on muu kuin windows
$format = '%e';

// Muutetaan formaatti %e->%d, mikäli käyttöjärjestelmänä on windows
if (strtoupper(substr(PHP_OS, 0, 3)) == 'WIN') {
	echo "preg_replace format: " . preg_replace('(%e)', '%d', $format);
	$format = preg_replace('(%e)', '%d', $format);
	echo "<br>";
	print("käyttöjärjestelmä on windows");
	echo "<br><br>";
} else {
	echo "käyttöjärjestelmä ei ole windows";
	echo "<br>";
	echo "<br>";
}

echo "<label>päivä</label>";
echo "<select name='paiva'>";
echo strftime($format);
for($i=1;$i<=31;$i++){
	$pv=strftime($format, mktime(0,0,0,0,$i));
	echo "<option value='". $i."'>".$pv."</option>";

	
}
echo "</select>";
                            
				
?>

<?php 
date_default_timezone_set('Europe/Helsinki');
setlocale(LC_ALL, array('fi_FI.UTF-8','fi_FI@euro','fi_FI','finnish'));

echo "<label>kuukausi</label>";

echo "<select name='kk'>";
for($i=1;$i<=12;$i++){
	$kuukausi=strftime('%B', mktime(0,0,0,$i));
	echo "<option value='". $i."'>".$kuukausi."</option>";
}
echo "</select>";

?>

<?php 
date_default_timezone_set('Europe/Helsinki');
setlocale(LC_ALL, array('fi_FI.UTF-8','fi_FI@euro','fi_FI','finnish'));

echo "<label>vuosi</label>";

echo "<select name='vuosi'>";
$nykyVuosi = (new DateTime)->format("Y");

for($i=1991;$i<=2031;$i++){
	$vuos=strftime('%Y', mktime(0,0,0,0,0,$i));
	if ($vuos<=$nykyVuosi) {
		echo "<option value='".$vuos."'>".$vuos."</option>";
	}
	
}
echo "</select>";

?>


<br><br>
<input name="tallenna" type="submit" class="btn btn-primary px-2" value="Tallenna"></input>   
</form>
<br>
<!-- <?php print("tilap pvm: $tilapainenPvm"); ?> -->
<br>
<?php print("syötetty asennus pvm: $testAsennusPaivamaara"); ?>
<br>
<?php 
print("syötetty päivä: $paiva");
echo "<br>";
print("syötetty kk: $kk");
echo "<br>";
print("syötetty vuosi: $vuosi");
echo "<br>";
$nykyVuosi = (new DateTime)->format("Y");
echo "nykyvuosi: " .$nykyVuosi;
echo "<br>";
echo "PHP Os: " . "'" . (strtoupper(substr(PHP_OS, 0, 3))) . "'";
echo "<br>";
print("muutoksen jälkeen format: $format");
echo "<br>";
echo "vuos testi: " . strftime('%Y', mktime(0,0,0,0,0,-1))
?>


</body>
</html>