<?php
// Liitetään lomakekenttien käsittelyyn tarkoitettu luokka
require_once "PDO.php";
require_once "muokkaaLuokkaa.php";

// Alustetaan muuttuja $syottoVirhe
$syottoVirhe = FALSE;

// Käynnistetään sessio
session_start ();

// Onko painettu tallenna-painiketta
if (isset($_POST["tallenna"])) {
   // Viedään muodostimelle kenttien arvot
	if (!isset($_POST["lisaaId"]) ||
			!isset($_POST["asiakkaanNimi"]) ||
			!isset($_POST["sahkopostiosoite"]) ||
			!isset($_POST["puhelinNumero"]) ||
			!isset($_POST["paiva"]) ||
			!isset($_POST["kuukausi"]) ||
			!isset($_POST["vuosi"]) ||
			!isset($_POST["levytila"]) ||
			!isset($_POST["kayttoJarjestelma"]) ||
			!isset($_POST["lisatietoa"])) {
				die('LÄHETYS ESTETTY! Kaavake jota yritit lähettää näyttäisi olevan kenttiä, jotaka eivät ole alkuperäisessä kaavakkeessa.');
	} else {
																	
   $muokkaa = new Muokkaa($_POST["lisaaId"],
   		$_POST["asiakkaanNimi"],
   		$_POST["sahkopostiosoite"],
   		$_POST["puhelinNumero"],
   		$_POST["paiva"],
   		$_POST["kuukausi"],
   		$_POST["vuosi"],
   		$_POST["levytila"],
   		$_POST["kayttoJarjestelma"],
   		$_POST["lisatietoa"]
   		);
	
   // Kirjoitetaan session tiedot talteen
   $_SESSION ["muokkaa"] = $muokkaa;
   session_write_close ();
   
   try {
   
   	$kantakasittely = new Muokkaa();
   	$rivit = $kantakasittely->muokkaaAsiakas($muokkaa);
   
   } catch (Exception $error) {
   
   	print($error->getMessage());
   	echo "<br>";
   }
   
	} // if (isset($_POST["tallenna"]))

  
   // Haetaan mahdolliset virhekoodit
   $asiakkaanNimiVirhe = $muokkaa->checkAsiakkaanNimi(TRUE,3,50);
   $sahkopostiosoiteVirhe = $muokkaa->checkSahkopostiosoite(TRUE);
   $puhelinNumeroVirhe = $muokkaa->checkPuhelinNumero(TRUE,8,20);
   $asennusPaivamaaraVirhe = $muokkaa->checkAsennusPaivamaara(FALSE);
   $levytilaVirhe = $muokkaa->checkLevytila(TRUE);
   $kayttoJarjestelmaVirhe = $muokkaa->checkKayttoJarjestelma(TRUE);
   $lisatietoaVirhe = $muokkaa->checkLisatietoa(FALSE,10,500);
   

   // Haetaan mahdolliset syöttövirheet ja annetaan boolean tyyppinen true tai false arvo
   
   if ($asiakkaanNimiVirhe > 0) $syottoVirhe = TRUE;
   if ($sahkopostiosoiteVirhe > 0) $syottoVirhe = TRUE;
   if ($puhelinNumeroVirhe > 0) $syottoVirhe = TRUE;
   if ($asennusPaivamaaraVirhe > 0) $syottoVirhe = TRUE;
   if ($levytilaVirhe > 0) $syottoVirhe = TRUE;
   if ($kayttoJarjestelmaVirhe > 0) $syottoVirhe = TRUE;
   if ($lisatietoaVirhe > 0) $syottoVirhe = TRUE;
   
}
// Onko painettu peruuta painiketta
elseif (isset($POST["peruuta"])) {
	
	$syottoVirhe = FALSE;
	
	// Siirretään SESSION tiedot arraylistaan
	$_SESSION = array ();
		// Jos COOKIE on asetettu, määritetään sille miinus arvoinen säilytysaika
		if (isset ( $_COOKIE [session_name ()] )) {
			setcookie ( session_name (), "", time () - 100, "/" );
		}

	// Tuhotaan sessio
	session_destroy ();

	header("location: muokkaa.php");
	exit;
} // elseif (isset($POST["peruuta"])

elseif (isset ( $_POST ["tallenna"] )) {
	if (isset ( $_SESSION ["muokkaa"] )) {
		$_SESSION = array ();

		if (isset ( $_COOKIE [session_name ()] )) {
			setcookie ( session_name (), '', time () - 100, '/' );
		}

		session_destroy ();

		header ( "Location: muokkaa.php" );
		exit ();
	} else {
		
		header ( "location: muokkaa.php?" );
		exit ();
	}
} // elseif (isset ( $_POST ["tallenna"] ))

elseif (isset($_POST["haeAsiakkaat"]) && !empty($_POST["haeAsiakkaat"])) {

	// Erottelee stringin arrayksi, erottimena |
	$asParse = explode('|',$_POST['asiakasNimi']);
	
	// Loopataan $asTiedot arraylista saatujen $_POST[asiakasnimi] perusteella
	for ($i=0; $i<count($asParse); $i++) {
		$asTiedot[]=$asParse[$i];
	}

	//$asTiedot = array($asParse[0],$asParse[1],$asParse[2],
	//		$asParse[3],$asParse[4],$asParse[5],$asParse[6],$asParse[7]);
	
	// Otetaan päivämäärä kenttä stringiin
	//$pvmParse = array_slice($asTiedot,4,1);
	
	// Erotellaan pp kk ja vvvv
	//$pvmTemp = implode('|',$pvmParse);
	
	// Otetaan pvm,kk ja pv arvot omiin muuttujiin
	//list($uusiVuosi,$uusiKuukausi,$uusiPaiva) = explode('-',$pvmTemp);
	
	// Otetaan etunolla pois kuukaudesta, jotta alasvetovalikon selected ehto toimisi
	$uusiKuukausi = substr($asParse[5],1);
	
	//Korvataan nykyinen timedate() päivällä ja lisätään kk ja vuosi tiedot arraylistan väliin
	//array_splice($asTiedot,4,1,$uusiPaiva);
	array_splice($asTiedot,5,1,$uusiKuukausi);
	//array_splice($asTiedot,6,0,$uusiVuosi);
	
	//echo '<div style="padding-left:300px;">';
	//ECHO '<br>array_splice: '; var_dump($asTiedot);
	//echo 'uusikk: ' .$uusiKuukausi;
	//echo '</div>';
	
	
	 if (isset($_COOKIE["isDebug"])) {
	 	echo '<div style="padding-left:300px;">';
	 	ECHO '$_POST[asiakasNimi]: '.$_POST['asiakasNimi'];
		ECHO '<br>vvvv|kk|pp: ' .$uusiVuosi.'|'.$uusiKuukausi.'|'.$uusiPaiva;
		
		ECHO '<br>array_splice: '; var_dump($asTiedot);
		echo '<br>SyöttöVirheet: '. (($syottoVirhe === TRUE) ? 'true' : 'false'); 
		echo '<br>(!isset($_POST["haeAsiakkaat"])): '. (!isset($_POST["haeAsiakkaat"]) ? 'ei ole asetetu':' on asetettu');
		echo '</div>';
	 }
} 
else {

	if (isset ( $_SESSION ["muokkaa"] )) {
		$muokkaa = $_SESSION ["muokkaa"];

		// Haetaan mahdolliset virhekoodit
		$asiakkaanNimiVirhe = $muokkaa->checkAsiakkaanNimi(TRUE,3,50);
		$sahkopostiosoiteVirhe = $muokkaa->checkSahkopostiosoite(TRUE);
		$puhelinNumeroVirhe = $muokkaa->checkPuhelinNumero(TRUE,8,20);
		$asennusPaivamaaraVirhe = $muokkaa->checkAsennusPaivamaara(TRUE);
		$levytilaVirhe = $muokkaa->checkLevytila(TRUE);
		$kayttoJarjestelmaVirhe = $muokkaa->checkKayttoJarjestelma(TRUE);
		$lisatietoaVirhe = $muokkaa->checkLisatietoa(FALSE,10,500);


		// Haetaan mahdolliset syöttövirheet ja annetaan boolean tyyppinen true tai false arvo
		if ($asiakkaanNimiVirhe > 0) $syottoVirhe = TRUE;
		if ($sahkopostiosoiteVirhe > 0) $syottoVirhe = TRUE;
		if ($puhelinNumeroVirhe > 0) $syottoVirhe = TRUE;
		if ($asennusPaivamaaraVirhe > 0) $syottoVirhe = TRUE;
		if ($levytilaVirhe > 0) $syottoVirhe = TRUE;
		if ($kayttoJarjestelmaVirhe > 0) $syottoVirhe = TRUE;
		if ($lisatietoaVirhe > 0) $syottoVirhe = TRUE;
	} // if (isset ( $_SESSION ["muokkaa"] ))

	// Sivulle tultiin ensimmäistä kertaa
	else {
		

		
		$now = time(); // Laitetaan nykyhetki muuttujaan
			// Tarkistetaan, että on sisäänkirjauduttu ja sessioaika ei ole vielä mennyt umpeen
			if (isset($_SESSION['onKirjauduttu']) && $_SESSION['onKirjauduttu'] === true && $now <= $_SESSION['expire']) {
			
				// Tehdään tyhjä olio
				$muokkaa = new Muokkaa();
				// Nollataan virhekoodit
				$asiakkaanNimiVirhe = 0;
				$sahkopostiosoiteVirhe = 0;
				$puhelinNumeroVirhe = 0;
				$asennusPaivamaaraVirhe = 0;
				$levytilaVirhe = 0;
				$kayttoJarjestelmaVirhe = 0;
				$lisatietoaVirhe = 0;
				$syottoVirhe = FALSE;
				
			} else {
			
				header('Location: index.php');
				exit;
					
			}
	
	} // elseif else
} // eka else

$syottoVirhe = FALSE;
// Jos käyttäjä valitsi kirjaudu ulos
if (isset($_GET["kirjauduUlos"])) {


	$syottoVirhe = FALSE;
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
}
	
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Notes</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Select CSS -->
    <link href="css/bootstrap-select.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/sb-admin.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->



<style type="text/css">
    .bs-example{
    	margin: 20px;
    }
    .icon-input-btn{
        display: inline-block;
        position: relative;
    }
    .icon-input-btn input[type="submit"]{
        padding-left: 2em;
    }
    .icon-input-btn .glyphicon{
        display: inline-block;
        position: absolute;
        left: 0.65em;
        top: 30%;
    }
</style>


    
</head>

<body>

    <div id="wrapper"> <!-- koko sivun "käärre" -->

        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                 <a class="navbar-brand" href="index.php">Notes for business</a>
                
            </div> <!-- ./ navbar-header -->
            
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                <?php 
               $now = time(); // Laitetaan nykyhetki muuttujaan
                // Tarkistetaan, että on sisäänkirjauduttu ja sessioaika ei ole vielä mennyt umpeen
                   if (isset($_SESSION['onKirjauduttu']) && $_SESSION['onKirjauduttu'] === true && $now <= $_SESSION['expire']) {
                	
                    print '<li>
                        <a href="lisaa.php"> <i class="fa fa-fw fa-edit"></i> Lisää</a>
                    </li>
                    <li>
                        <a href="muokkaa.php"><i class="fa fa-fw fa-edit"></i> Muokkaa</a>
                    </li>
                    <li>
                        <a href="listaaKaikki.php"><i class="fa fa-fw fa-edit"></i> Hae / Poista</a>
                    </li>
                    <li>
                        <a href="asetukset.php"><i class="fa fa-fw fa-wrench"></i> Asetukset</a>
                    </li>
					<li>
                		<a href="?kirjauduUlos"><i class="fa fa-fw fa-power-off"></i> KIRJAUDU ULOS</a>
                	</li>
					';
                } ?>
                                     
                </ul>
            </div> <!-- /.navbar-collapse -->
        </nav> <!-- /.navbar header -->

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Muokkaa asiakastietoja
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i>  <a href="index.php">Etusivu</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-edit"></i> Muokkaa
                            </li>
                            
                            <!--  Näytetään tietokantayhteyden tila  -->                 
                           <?php
                           	echo '<div class="pull-right input-group" style="background:yellow;">';
                           		try {
                         			require_once "PDO.php";
                              		 $Database = new Database();
                                  		echo ' DB Yhteys: ' .($Database->isConnected() ? 'ON' : 'OFF');
                                     } catch (Exception $error) {
                                  	 	print($error->getMessage());

                                    }
                             echo '</div>';
                            ?>
                            
                            
                            
                        </ol>
                    </div> <!-- /. heading col-lg-12 -->
                </div> <!-- /. heading row -->
                

                <div class="row">
                    <div class="col-lg-6"> <!-- vasen col-lg-6 -->

                        <form class="inline-form" role="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
			
							<input name="lisaaId" value="<?php echo (isset($_POST["haeAsiakkaat"]) ? $asTiedot[0] : '' ); ?>" type="hidden"/>
                            <!-- ** ASIAKKAAN NIMI ** -->
                            <div class="form-group">
                                <label>Asiakkaan nimi</label>
							
							<!-- Tarkistetaan onko syöttökentässä virhe, jos on korostetaan kehys punaisella -->
                             <?php echo (($syottoVirhe === FALSE) 
                             		? '<div class="input-group">' : '<div class="input-group has-error">' );?>
                               
                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                            
                            <!-- Haetaan haetun asiakkaan nimi -->
                            <?php echo '<input name="asiakkaanNimi" class="form-control" type="text" value='.
                              (isset($_POST["haeAsiakkaat"]) ? '"'.$asTiedot[1].'"' 
                            		: '""');?> placeholder="Neste Oy"/>
							
				// echo '<br>SyöttöVirheet: '. (($syottoVirhe === TRUE) ? 'true' : 'false');
                            	 echo '</div> <!-- ./input-group -->' ?>
							</div> <!-- ./form-group -->
							
							
                            <div class="form-group">
                                <label>Sähköpostiosoite</label>
                            
                            <!-- Tarkistetaan onko syöttökentässä virhe, jos on korostetaan kehys punaisella -->
                              <?php echo (($syottoVirhe === FALSE) 
                             	? '<div class="input-group">' : '<div class="input-group has-error">' );?>
                            
                                	<span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                                
                                 <!-- Haetaan haetun asiakkaan sähköpostiosoite -->
                                
                                <input name="sahkopostiosoite" class="form-control" type="text" value= 
                                <?php echo (isset($_POST["haeAsiakkaat"]) ? '"'.$asTiedot[2].'"' : '""');?> placeholder="nimi@esimerkki.fi"/>
                           
                            	<?php echo '</div> <!-- ./input-group -->' ?>
							</div> <!-- ./form-group -->
                            
                              <!-- ** PUHELINNUMERO ** -->
                            <div class="form-group">
                                <label>Puhelinnumero</label>
                              
                              <!-- Tarkistetaan onko syöttökentässä virhe, jos on korostetaan kehys punaisella -->  
                              <?php echo (($syottoVirhe === FALSE) 
                             	? '<div class="input-group">' : '<div class="input-group has-error">' );?>
                            
                                	<span class="input-group-addon"><i class="glyphicon glyphicon-phone"></i></span>
                                
                                <!-- Jos syöttökentässä on ollut virhe, palautetaan annettu arvo -->
                                <input name="puhelinNumero" class="form-control" type="tel" value=
                            	<?php echo (isset($_POST["haeAsiakkaat"]) ? '"'.$asTiedot[3].'"' : '""');?> placeholder="040-3493384"/>
                            	<?php echo '</div> <!-- ./input-group -->' ?>
							</div> <!-- ./form-group -->

							  <!-- ** ASENNUSPÄIVÄMÄÄRÄ ** -->
							<div class="form-group">
                            
                            	<span class="glyphicon glyphicon-calendar"></span>
                            	<label>Asennuspäivämäärä</label>
                           	
                            	<!-- Tarkistetaan onko syöttökentässä virhe, jos on korostetaan kehys punaisella -->  
                             <?php echo (($syottoVirhe === FALSE) 
                             	? '<div class="input-group">' : '<div class="input-group has-error">' );?>
							

                            <!--  Asennuspäivämäärien PHP lomakkeet  -->
                            <!-- OLI AIVAN KAUHEA HOMMA SAADA NÄMÄ TOIMIMAAN ! -->
                            	<?php
                            	// Määritetään oletus aikavyöhyke ja maa-asetukset
                            	date_default_timezone_set('Europe/Helsinki');
                            	setlocale(LC_ALL, array('fi_FI.UTF-8','fi_FI@euro','fi_FI','finnish'));
                            	
                            	// Määritetään formaatiksi %e, kun kyseessä on muu kuin windows
                            	$format = '%e';
                            	
                            	// Muutetaan formaatti %e->%d, mikäli käyttöjärjestelmänä on windows
                            	if (strtoupper(substr(PHP_OS, 0, 3)) == 'WIN') {
                            		$format = preg_replace('(%e)', '%d', $format);
                            	}    	
                            	
                            	// Päivä alasvetovalikko, loopataan päivät 1-31 ilman etunollia.
                            	// Jos syöttökentässä on ollut virhe, palautetaan annettu arvo
                            	echo '<label style="padding-top:15%;">Päivä:' . '&nbsp;</label>';
                            	echo '<select class="selectpicker" data-width="auto" name="paiva">' ."\n";
								echo '<option value="none"', (empty($asTiedot[4])) 
								? ' selected':'' ,'>Päivä</option>';
								echo "\n";
                            	for($pvmNro=1;$pvmNro<=31;$pvmNro++){
									$pv=strftime($format, mktime(0,0,0,0,$pvmNro));
									
									 echo '<option value="'.(($syottoVirhe === FALSE && (isset($asTiedot[4]) != $pv)) ? $pv .'">' .$pvmNro 
									 	: (($asTiedot[4] == $pv) ? $pv .'" selected>' .$pv : $pv .'">' .$pvmNro ));
									 echo "</option>" ."\n";
                            	}
                            	echo "</select>" ."\n";
                            	
                            	// Kuukausi alasvetovalikko, loopataan kuukaudet 1-12 ilman etunollia
                            	// Jos syöttökentässä on ollut virhe, palautetaan annettu arvo
                            	echo '<label>'.'&nbsp;&nbsp;'.'Kuukausi:' . '&nbsp;' . '</label>' ."\n";
								echo '<select class="selectpicker" data-width="auto" name="kuukausi">';
								echo '<option value="none"', (empty($asTiedot[5]))  
								? ' selected':'' ,'>Kuukausi</option>';
								echo "\n";
								for($kkNro=1;$kkNro<=12;$kkNro++){
									$kk=strftime('%B', mktime(0,0,0,$kkNro));

									 echo '<option value="'.(($syottoVirhe === FALSE && (isset($asTiedot[5]) != $kkNro)) ? $kkNro .'">' .$kk
									 	: (($asTiedot[5] == $kkNro) ? $kkNro .'" selected>' .$kk : $kkNro .'">' .$kk ));
									 echo "</option>" ."\n";
								}
								echo "</select>\n";
								
								// Vuosi alasvetovalikko, loopataan vuodet 1990-2030
								// Mutta ei laiteta vuosilistaan uudempaa vuotta kuin nykyvuosi
								// Nykyinen systeemi lisää automaattisesti vuoteen 2030 asti
                            	// Jos syöttökentässä on ollut virhe, palautetaan annettu arvo
								echo '<label>'.'&nbsp;&nbsp;'.'Vuosi:'.'&nbsp;'.'</label>' ."\n";
								echo '<select class="selectpicker" data-width="auto" name="vuosi">';
								echo '<option value="none"', (empty($asTiedot[6])) 
								? ' selected':'' ,'>Vuosi</option>';
								echo "\n";
									$nykyVuosi = (new DateTime)->format("Y");
									
										for($vuosNro=1991;$vuosNro<=2031;$vuosNro++){
											$vuos=strftime('%Y', mktime(0,0,0,0,0,$vuosNro));
											if ($vuos<=$nykyVuosi) {
												
									 echo '<option value="'.(($syottoVirhe === FALSE && (isset($asTiedot[6]) != $vuos)) ? $vuos .'">' .$vuos
									 	: (($asTiedot[6] == $vuos) ? $vuos .'" selected>' .$vuos : $vuos .'">' .$vuos ));
									 echo "</option>" ."\n";
											}
										
									}
								echo "</select>\n";
								echo "</div> <!-- ./input-group -->\n"
								?>
                                
                           </div> <!-- ./form-group -->
                            
                              <!-- ** LEVYTILA ** -->
                            <div class="form-group">
                                <label>Levytila (Gt)</label>
                              
	                              	<!-- Tarkistetaan onko syöttökentässä virhe, jos on korostetaan kehys punaisella --> 
	                             	<?php echo (($syottoVirhe === FALSE) 
	                             	? '<div class="input-group">' : '<div class="input-group has-error">' );?>
	                                
	                                <span class="input-group-addon"><i class="glyphicon glyphicon-hdd"></i></span>
	                                
	                                <input name="levytila" class="form-control" type="number" min="1" value=<?php 
	                             		echo (!empty($asTiedot[7])  ? $asTiedot[7] : '""')?> placeholder="100"/>
                            	<?php echo '</div> <!-- ./input-group -->' ?>
							</div> <!-- ./form-group -->

							  <!-- ** KÄYTTÖJÄRJESTELMÄ ** -->
							  <!-- valinnat tehty n00b tyylillä, eikä ole käytetty mitään muuuttujia, listoja saatikka luokkia -->
                            <div class="form-group">
                                <label>Käyttöjärjestelmä</label>

                             <!-- Tarkistetaan onko syöttökentässä virhe, jos on korostetaan kehys punaisella --> 
                             <?php echo (($syottoVirhe === FALSE) 
                             	? '<div class="input-group">' : '<div class="input-group has-error">' );?>
                                

                                <span class="input-group-addon"><i class="glyphicon glyphicon-cog"></i></span>
                             
                             
											
                             <!-- Jos syöttökentässä on ollut virhe, palautetaan annettu arvo -->   
                                <select name="kayttoJarjestelma" class="form-control">
							<?php 
							
							echo '<option value="none"', (empty($asTiedot[8]))  
								? ' selected':'' ,'>Valitse käyttöjärjestelmä</option>';
							echo "\n"; 
							
							echo '<option value="'.(($syottoVirhe == FALSE && (isset($asTiedot[8]) != 1)) ? '1">Windows Server 2008'
								: (($asTiedot[8] == 1) 
								? '1" selected>Windows Server 2008' : '1">Windows Server 2008' ));
							echo "</option>\n";
							
							echo '<option value="'.(($syottoVirhe == FALSE && (isset($asTiedot[8]) != 2)) ? '2">Windows Server 2008 R2'
									: (($asTiedot[8] == 2)
									? '2" selected>Windows Server 2008 R2' : '2">Windows Server 2008 R2' ));
							echo "</option>\n";
							
							echo '<option value="'.(($syottoVirhe == FALSE && (isset($asTiedot[8]) != 3)) ? '3">Windows Server 2012'
									: (($asTiedot[8] == 3)
									? '3" selected>Windows Server 2012' : '3">Windows Server 2012' ));
							echo "</option>\n";
							
							echo '<option value="'.(($syottoVirhe == FALSE && (isset($asTiedot[8]) != 4)) ? '4">Windows Server 2016'
									: (($asTiedot[8] == 4)
									? '4" selected>Windows Server 2016' : '4">Windows Server 2016' ));
							echo "</option>\n";
							
							
 							?>
                                	</select>
                            	<?php echo '</div> <!-- ./input-group -->' ?>
							</div> <!-- ./form-group -->

							  <!-- ** LISÄTIETOA ** -->
                            <div class="form-group">
                                <label>Lisätietoa</label>
                             
                             <!-- Tarkistetaan onko syöttökentässä virhe, jos on korostetaan kehys punaisella -->    
                             <?php echo (($syottoVirhe == FALSE)
                             	? '<div class="input-group">' : '<div class="input-group has-error">' );?>

                                	<span class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></span>  
                                                            
                               <!-- Jos syöttökentässä on ollut virhe, palautetaan annettu arvo -->                
                                <textarea name="lisatietoa" class="form-control" rows="3"><?php 
    
                          
                             echo (!empty($asTiedot[9]) ? $asTiedot[9] : ''); ?></textarea>
                            
                            <?php echo "</div> <!-- ./input-group -->\n" ?>
							</div> <!-- ./form-group -->
                          
                            <!-- ** TALLENNA JA PERUUTA PAINIKKEET ** -->
                          	<div class="form-group">
                          		<div class="pull-left">
		                          	<span class="icon-input-btn"><span class="glyphicon glyphicon-ok"></span>
		                            <input name="tallenna" type="submit" class="btn btn-primary px-2" value="Tallenna"></span>                                                   
                 				</div> <!-- ./pull-left -->
                 			
                 				<div class="pull-right">
		                 			<span class="icon-input-btn"><span class="glyphicon glyphicon-remove"></span>
		                            <input name="peruuta" type="submit" class="btn btn-danger" value="Peruuta"></span>
                            	</div> <!-- ./pull-right -->
                            </div><!-- ./form-group -->
                           
                         
                        </form> <!-- ./ lomakkeet -->
                        
                    </div> <!-- /.vasen col-lg-6 -->
                        
					<div class="col-lg-6"> <!-- oikea col-lg-6 -->
                           
                           <!-- ** ASIAKAS DROPDOWN MENU ** -->
                      <form class="inline-form" role="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
					    <div class="form-group">
							<label>Järjestelmässä olevat asiakkaat</label>
							<div class="input-group mb-2 mr-sm-2 mb-sm-0">
							
								<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
									<select class="selectpicker" data-width="auto" name="asiakasNimi">
									
										<?php 
										
										// Luodaan olio, jolla käsitellä Muokkaa luokkaa
										// haetaan asiakkaat tietokannasta
										$kantakasittely = new Muokkaa();
										$asiakkaat = $kantakasittely->haeAsiakaat();
										
										
										// Loopataan asiakasnimet alasvetovalikkoon
										// Liitetään value kenttään muut arvot, jotta ne on helpompi poimia sieltä omiin kenttiinsä
										foreach ($asiakkaat as $asiakas) {
											echo '<option value="'.utf8_encode($asiakas->getLisaaId()."|".$asiakas->getAsiakkaanNimi()."|".$asiakas->getSahkopostiosoite())."|".
											$asiakas->getPuhelinNumero()."|".$asiakas->getPaiva()."|".$asiakas->getKuukausi()."|".$asiakas->getVuosi()."|".
											$asiakas->getLevytila()."|".$asiakas->getKayttoJarjestelmaId()."|".
											$asiakas->getLisatietoa().'">'.utf8_encode($asiakas->getAsiakkaanNimi());
											echo "</option>\n";
							
										}
										
										
										?>
									
									 </select>
									 
										 <div style="padding-left:5%;">
										 	<span class="icon-input-btn"><span class="glyphicon glyphicon-ok"></span>
			                             	<input name="haeAsiakkaat" type="submit" class="btn btn-primary px-2" value="Hae"></span> 
										</div> <!-- ./input button -->
							 </div> <!-- ./ input-group mb-2 mr-sm-2 mb-sm-0 -->
								
						  </div> <!-- ./ form-group -->
						</form> <!-- ./ lomakkeet -->
							<!--  Virheviestit  -->
							<!-- Asiakkaan nimi virheet -->  
							<div class="form-group" style="padding-top:4%;">
								<div class="input-group">
									<p>
		                            <?php 
		                            if (isset($_POST["tallenna"])) {
		                            try {
		                            	 global $rivit;
		                            	 //echo 'dump '; var_dump($rivit);
		                            	  	echo ((stripos($rivit[0], 'lisaa ok') !== FALSE)
								   			? '<h3 style="color:green"><i class="glyphicon glyphicon-ok">
											   </i>Asiakastiedot on päivitetty onnistuneesti</h3>'
								   			: '<h3 style="color:red"><i class="glyphicon glyphicon-remove">
								   			   </i>Päivitys epäonnistui</h3>');
		                            } 	catch (Exception $error) {

											print($error->getMessage());
											echo "<br>";
										}
		                            }

		                            echo (($syottoVirhe === TRUE) 
		                            ? '<span style="color:red";>' .$muokkaa->getVirhe($asiakkaanNimiVirhe). '</span>'
									: '&nbsp;');?>
		                            </p>
	                            </div>
                            </div>
                            
                            <!-- Sähköpostiosoite virheet -->
							<div class="form-group" style="padding-top:4%;">
								<div class="input-group">
									<p>
									<?php echo (($syottoVirhe === TRUE) 
		                            ? '<span style="color:red";>' .$muokkaa->getVirhe($sahkopostiosoiteVirhe). '</span>'
									: '&nbsp;');?>
		                            </p>
	                            </div>
                            </div>
                            
                            <!-- Puhelinnumero virheet -->
							<div class="form-group" style="padding-top:4%;">
								<div class="input-group">
									<p>
									<?php echo (($syottoVirhe === TRUE) 
		                            ? '<span style="color:red";>' .$muokkaa->getVirhe($puhelinNumeroVirhe). '</span>'
									: '&nbsp;');?>
		                          	</p>
	                            </div>
                            </div>
                          	
                          	<!-- Asennuspäivämäärä virheet -->
							<div class="form-group" style="padding-top:4%;">
								<div class="input-group">
									<p>
									<?php echo (($syottoVirhe === TRUE) 
		                            ? '<span style="color:red";>' .$muokkaa->getVirhe($asennusPaivamaaraVirhe). '</span>'
									: '<BR>&nbsp;');
									 if (isset($_COOKIE["isDebug"])) {
										echo ' paiva: '. $muokkaa->getPaiva().
										' kk: '.$muokkaa->getKuukausi().
										' vuosi: '.$muokkaa->getVuosi();
									 }	
									
									?>
		                            </p>
	                            </div>
                            </div>
                            
                            <!-- Levytila virheet -->
                            <div class="form-group" style="padding-top:3.5%;">
								<div class="input-group">
									<p>
									<?php echo (($syottoVirhe === TRUE) 
		                            ? '<span style="color:red";>' .$muokkaa->getVirhe($levytilaVirhe). '</span>'
									: '&nbsp;');?>
		                            </p>
	                            </div>
                            </div>
                            
                            <!-- Käyttöjärjestelmä virheet -->
                            <div class="form-group" style="padding-top:3.5%;">
								<div class="input-group">
									<p>
									<?php echo (($syottoVirhe === TRUE)
		                            ? '<span style="color:red";>' .$muokkaa->getVirhe($kayttoJarjestelmaVirhe). '</span>'
									: '&nbsp;');?>
		                            </p>
	                            </div>
                            </div>
                            
                            <!-- Lisätietoa virheet -->
                            <div class="form-group" style="padding-top:7%;">
								<div class="input-group">
									<p>
									<?php echo (($syottoVirhe === TRUE) 
		                            ? '<span style="color:red";>' .$muokkaa->getVirhe($lisatietoaVirhe). '</span>'
									: '&nbsp;');?>
		                        	</p>
	                            </div>
                            </div>
                               
                            </div> <!-- ./ oikea col-lg-6 -->
							
			
                <!-- /.row -->    
                </div> 

            <!-- /.container-fluid -->
            </div>

        <!-- /#page-wrapper -->
        </div>
        
	<!-- /#wrapper -->
    </div>
    

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
    
    <!-- Bootstrap select picker JavaScript -->
    <script type="text/javascript" src="js/bootstrap-select.min.js"></script>
        
<!-- Bootstrap selectpicker & glyphicons to input buttons -->
<script type="text/javascript">
$(document).ready(function( {
    $('.selectpicker').selectpicker();
    style: 'btn-default',
    size: false
  });
  
$(document).ready(function(){
	$(".icon-input-btn").each(function(){
        var btnFont = $(this).find(".btn").css("font-size");
        var btnColor = $(this).find(".btn").css("color");
		$(this).find(".glyphicon").css("font-size", btnFont);
        $(this).find(".glyphicon").css("color", btnColor);
        if($(this).find(".btn-xs").length){
            $(this).find(".glyphicon").css("top", "24%");
        }
	}); 
}); 
</script>

</body>

</html>
