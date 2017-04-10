<?php
// Liitetään lomakekenttien käsittelyyn tarkoitettu luokka
require_once "lisaaLuokka.php";

// Onko painettu tallenna-painiketta
if (isset($_POST["tallenna"])) {
   // Viedään muodostimelle kenttien arvot
   $lisaa = new Lisaa($_POST["asiakkaanNimi"],
   		$_POST["sahkopostiosoite"],
   		$_POST["puhelinNumero"],
   		$_POST["paiva"],
   		$_POST["kuukausi"],
   		$_POST["vuosi"],
   		$_POST["levytila"],
   		$_POST["kayttoJarjestelma"],
   		$_POST["lisatietoa"]
   		);
   
   // Haetaan mahdolliset virhekoodit
   $asiakkaanNimiVirhe = $lisaa->checkAsiakkaanNimi();
   $sahkopostiosoiteVirhe = $lisaa->checkSahkopostiosoite();
   $puhelinNumeroVirhe = $lisaa->checkPuhelinNumero();
   $asennusPaivamaaraVirhe = $lisaa->checkAsennusPaivamaara();
   $levytilaVirhe = $lisaa->checkLevytila();
   $kayttoJarjestelmaVirhe = $lisaa->checkKayttoJarjestelma();
   $lisatietoaVirhe = $lisaa->checkLisatietoa();
}


// Onko painettu peruuta painiketta
elseif (isset($POST["peruuta"])) {
	header("location: lisaa.php");
	exit;
}
// Sivulle tultiin ensimmäistä kertaa
else {
   // Tehdään tyhjä olio
   $lisaa = new Lisaa();
   // Nollataan virhekoodit
   $asiakkaanNimiVirhe = 0;
   $sahkopostiosoiteVirhe = 0;
   $puhelinNumeroVirhe = 0;
   $asennusPaivamaaraVirhe = 0;
   $levytilaVirhe = 0;
   $kayttoJarjestelmaVirhe = 0;
   $lisatietoaVirhe = 0;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Notes</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

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

</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                 <a class="navbar-brand" href="index.php">Notes for business</a>
                
            </div>
            
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                    <li>
                        <a href="lisaa.php" class="active"> <i class="fa fa-fw fa-edit"></i> Lisää</a>
                    </li>
                    <li>
                        <a href="muokkaa.php"><i class="fa fa-fw fa-edit"></i> Muokkaa</a>
                    </li>
                    <li>
                        <a href="listaaKaikki.php"><i class="fa fa-fw fa-edit"></i> Listaa kaikki</a>
                    </li>
                    <li>
                        <a href="asetukset.php"><i class="fa fa-fw fa-wrench"></i> Asetukset</a>
                    </li>
                                     
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Lisää asiakas
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i>  <a href="index.php">Hallintapaneli</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-edit"></i> Lisää
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->

                <div class="row">
                    <div class="col-lg-6">

                        <form class="inline-form" role="form" action="" method="post">

                            <div class="form-group">
                                <label>Asiakkaan nimi</label>
                                <input name="asiakkaanNimi" class="form-control" type="text" placeholder="Neste Oy">
                            </div>

                            <div class="form-group">
                                <label>Sähköpostiosoite</label>
                                <input name="sahkopostiosoite" class="form-control" type="email" placeholder="nimi@esimerkki.fi"></input>
                            </div>
                            
                            <div class="form-group">
                                <label>Puhelinnumero</label>
                                <input name="puhelinNumero" class="form-control" type="tel" placeholder="040-3493384"></input>
                            </div>

                            <div class="form-inline">
                            
                            <label>Asennuspäivämäärä PP.KK.VVVV</label>
                            <br>
                            <!--  Asennuspäivämäärien PHP lomakkeet  -->
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
                            	echo "<div class='form-group'>";
                            	echo "<p>Päivä: ";
                            	echo "<select name=paiva>";
                            	for($i=1;$i<=31;$i++){
									$pv=strftime($format, mktime(0,0,0,0,$i));
									echo "<option value='". $i."'>".$pv."</option>";
                            	}
                            	echo "</select></p>";
                            	echo "</div>";
                            	
                            	// Kuukausi alasvetovalikko, loopataan kuukaudet 1-12 ilman etunollia
                            	echo "<div class='form-group' style='margin-left:5%;'>";
                            	echo "<p>Kuukausi: ";
								echo "<select name=kuukausi>";
								for($i=1;$i<=12;$i++){
									$kk=strftime('%B', mktime(0,0,0,$i));
									echo "<option value='". $i."'>".$kk."</option>";
								}
								echo "</select></p>";
								echo "</div>";
								
								// Vuosi alasvetovalikko, loopataan vuodet 1990-2030
								// Mutta ei laiteta vuosilistaan uudempaa vuotta kuin nykyvuosi
								// Nykyinen systeemi lisää automaattisesti vuoteen 2030 asti
								echo "<div class='form-group' style='margin-left:5%;'>";
								echo "<p>Vuosi: ";
								echo "<select name=vuosi>";
									$nykyVuosi = (new DateTime)->format("Y");
									
										for($i=1991;$i<=2031;$i++){
											$vuos=strftime('%Y', mktime(0,0,0,0,0,$i));
											if ($vuos<=$nykyVuosi) {
												echo "<option value='".$vuos."'>".$vuos."</option>";
											}
										
									}
								echo "</select></p>";
								echo "</div>";
								?>
                                
                            </div>
                            
                            <div class="form-group">
                                <label>Levytila (Gt)</label>
                                <input name="levytila" class="form-control" type="number" placeholder="100"></input>
                            </div>

                            <div class="form-group">
                                <label>Käyttöjärjestelmä</label>
                                <select name="kayttoJarjestelma" class="form-control">
                                	<option>Valitse käyttöjärjestelmä</option>
                                    <option>Windows Server 2008</option>
                                    <option>Windows Server 2008 R2</option>
                                    <option>Windows Server 2012 R2</option>
                                    <option>Windows Server 2016</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Lisätietoa</label>
                                <textarea name="lisatietoa" class="form-control" rows="3"></textarea>
                            </div>
                          
                          
                          	<div class="form-group">
                          	<div class="pull-left">
                            <input name="tallenna" type="submit" class="btn btn-primary px-2" value="Tallenna"></input>                        
                 			</div>
                 			<div class="pull-right">
                            <input name="peruuta" type="submit" class="btn btn-danger" value="Peruuta"></input>
                             </div>
                            </div>
                           
                         
                        </form>
                        
                        </div> <!-- /.vasen col-lg-6 -->
                        
                           <div class="col-lg-6">
                           
                            <h1>Syötetyt tiedot</h1>
							
							<!--  Syötetyt tiedot PHP osuus alkaa  -->
							<!-- Haetaan lisaaLuokka.php:sta asiakkaan nimi, hyödyntän htmlentities omianisuutta -->
							<!-- Tulostaa yksittäiset heittomerkit ja tulpaheittomerkit, käyttäen UTF-8 merkistöä  -->
                            <p>Asiakkan nimi: <?php print(htmlentities($lisaa->getAsiakkaanNimi(), ENT_QUOTES, "UTF-8"));?>
                            <?php print ("<span style='color:red';>" . $lisaa->getVirhe($asiakkaanNimiVirhe) . "</span>");?></p>
                            
                            <p>Sähköpostiosoite: <?php print(htmlentities($lisaa->getSahkopostiosoite(), ENT_QUOTES, "UTF-8")) ?>
                            <?php print ("<span style='color:red';>" . $lisaa->getVirhe($sahkopostiosoiteVirhe) . "</span>");?></p>
                            
                            <p>Puhelinnumero: <?php print(htmlentities($lisaa->getPuhelinNumero(), ENT_QUOTES, "UTF-8")) ?>
                            <?php print ("<span style='color:red';>" . $lisaa->getVirhe($puhelinNumeroVirhe) . "</span>");?></p>
                          
                          	<!-- Tarkistetaan ennen tulostamista onko asennuspäivämäärä syötetty, jotta ei tule php herjaa -->
                          	<p>Asennuspäivämäärä: <?php if ($lisaa->getAsennusPaivamaara()) {
                          	 print(htmlentities($lisaa->getAsennusPaivamaara()->format('j.n.Y'), ENT_NOQUOTES, "UTF-8")) 
                          	 ; } ?>
                            <?php print ("<span style='color:red';>" . $lisaa->getVirhe($asennusPaivamaaraVirhe) . "</span>");?></p>
                            
                            <p>Levytila (Gt): <?php print(htmlentities($lisaa->getLevytila(), ENT_QUOTES, "UTF-8")) ?>
                            <?php print ("<span style='color:red';>" . $lisaa->getVirhe($levytilaVirhe) . "</span>");?></p>
                            
                            <p>Käyttöjärjestelmä: <?php print(htmlentities($lisaa->getKayttoJarjestelma(), ENT_QUOTES, "UTF-8")) ?>
                            <?php print ("<span style='color:red';>" . $lisaa->getVirhe($kayttoJarjestelmaVirhe) . "</span>");?></p>
                            
                            <p>Lisatietoa: <textarea class="form-control" rows="3"><?php print(htmlentities($lisaa->getLisatietoa(), ENT_QUOTES, "UTF-8")) ?></textarea>
                            <?php print ("<span style='color:red';>" . $lisaa->getVirhe($lisatietoaVirhe) . "</span>");?></p>
                        
                            </div> <!-- ./ oikea col-lg-6 -->
	
			
                    
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

</body>

</html>