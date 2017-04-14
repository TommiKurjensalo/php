<?php
// Liitetään lomakekenttien käsittelyyn tarkoitettu luokka
require_once "lisaaLuokka.php";

// Alustetaan muuttuja $syottoVirhe
$syottoVirhe = FALSE;

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
   

   // Haetaan mahdolliset syöttövirheet ja annetaan boolean tyyppinen true tai false arvo
   if (($asiakkaanNimiVirhe) > 0) $syottoVirhe = "TRUE";
   if (($sahkopostiosoiteVirhe) > 0) $syottoVirhe = "TRUE";
   if (($puhelinNumeroVirhe) > 0) $syottoVirhe = "TRUE";
   if (($asennusPaivamaaraVirhe) > 0) $syottoVirhe = "TRUE";
   if (($levytilaVirhe) > 0) $syottoVirhe = "TRUE";
   if (($kayttoJarjestelmaVirhe) > 0) $syottoVirhe = "TRUE";
   if (($lisatietoaVirhe) > 0) $syottoVirhe = "TRUE";
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
                                <i class="fa fa-dashboard"></i>  <a href="index.php">Etusivu</a>
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

                        <form class="inline-form" role="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">

                            <!-- ** ASIAKKAAN NIMI ** -->
                            <div class="form-group">
                                <label>Asiakkaan nimi</label>
							
							<!-- Tarkistetaan onko syöttökentässä virhe, jos on korostetaan kehys punaisella -->
                             <?php echo ($lisaa->getVirhe($asiakkaanNimiVirhe) == null 
                             		? '<div class="input-group">' : '<div class="input-group has-error">' );?>
                               
                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                            
                            <!-- Jos syöttökentässä on ollut virhe, palautetaan annettu arvo -->                       
                            <input name="asiakkaanNimi" class="form-control" type="text" value=
                            <?php echo (($syottoVirhe == FALSE)) ? '""' : '"'.$lisaa->getAsiakkaanNimi().'"';?> placeholder="Neste Oy"/>
							
								<!-- <?php  echo 'Syöttövirheet: ' . (($syottoVirhe == TRUE) ? 'true' : 'false'); ?>  -->
                            	</div> <!-- ./input-group -->
							</div> <!-- ./form-group -->
							
							
                            <div class="form-group">
                                <label>Sähköpostiosoite</label>
                            
                            <!-- Tarkistetaan onko syöttökentässä virhe, jos on korostetaan kehys punaisella -->
                              <?php echo (($lisaa->getVirhe($sahkopostiosoiteVirhe)) == null
                             	? '<div class="input-group">' : '<div class="input-group has-error">' );?>
                            
                                	<span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                                
                                 <!-- Jos syöttökentässä on ollut virhe, palautetaan annettu arvo -->
                                <input name="sahkopostiosoite" class="form-control" type="text" value= 
                                <?php echo (($syottoVirhe == FALSE)) ? '""' : '"'.$lisaa->getSahkopostiosoite().'"';?> placeholder="nimi@esimerkki.fi"/>
                           
                            	</div> <!-- ./input-group -->
							</div> <!-- ./form-group -->
                            
                              <!-- ** PUHELINNUMERO ** -->
                            <div class="form-group">
                                <label>Puhelinnumero</label>
                              
                              <!-- Tarkistetaan onko syöttökentässä virhe, jos on korostetaan kehys punaisella -->  
                              <?php echo (($lisaa->getVirhe($puhelinNumeroVirhe)) == null
                             	? '<div class="input-group">' : '<div class="input-group has-error">' );?>
                            
                                	<span class="input-group-addon"><i class="glyphicon glyphicon-phone"></i></span>
                                
                                <!-- Jos syöttökentässä on ollut virhe, palautetaan annettu arvo -->
                                <input name="puhelinNumero" class="form-control" type="tel" value=
                            	<?php echo (($syottoVirhe == FALSE) ? '""' : '"'.$lisaa->getPuhelinNumero().'"');?> placeholder="040-3493384"/>
                            	</div> <!-- ./input-group -->
							</div> <!-- ./form-group -->

							  <!-- ** ASENNUSPÄIVÄMÄÄRÄ ** -->
							<div class="form-group">
                            
                            	<span class="glyphicon glyphicon-calendar"></span>
                            	<label>Asennuspäivämäärä</label>
                           	
                            	<!-- Tarkistetaan onko syöttökentässä virhe, jos on korostetaan kehys punaisella -->  
                             <?php echo (($lisaa->getVirhe($asennusPaivamaaraVirhe)) == null
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
                            	echo '<label>Päivä:' . '&nbsp;</label>';
                            	echo '<select class="selectpicker" data-width="auto" name="paiva">' ."\n";
								echo '<option value="none"', ($lisaa->getPaiva() == 'none') 
								? 'selected':'' ,'>Päivä</option>';
								echo "\n";
                            	for($pvmNro=1;$pvmNro<=31;$pvmNro++){
									$pv=strftime($format, mktime(0,0,0,0,$pvmNro));
									
									 echo '<option value="'.(($syottoVirhe == FALSE) ? $pv .'">' .$pv 
									 	: (($lisaa->getPaiva() == $pvmNro) ? $pv .'" selected>' .$pv : $pvmNro .'">' .$pv ));
									 echo "</option>";
                            	}
                            	echo "</select>" ."\n";
                            	
                            	// Kuukausi alasvetovalikko, loopataan kuukaudet 1-12 ilman etunollia
                            	// Jos syöttökentässä on ollut virhe, palautetaan annettu arvo
                            	echo '<label>'.'&nbsp;&nbsp;'.'Kuukausi:' . '&nbsp;' . '</label>' ."\n";
								echo '<select class="selectpicker" data-width="auto" name="kuukausi">';
								echo '<option value="none"', ($lisaa->getKuukausi() == 'none') 
								? 'selected':'' ,'>Kuukausi</option>';
								echo "\n";
								for($kkNro=1;$kkNro<=12;$kkNro++){
									$kk=strftime('%B', mktime(0,0,0,$kkNro));

									 echo '<option value="'.(($syottoVirhe == FALSE) ? $kkNro .'">' .$kk
									 	: (($lisaa->getKuukausi() == $kkNro) ? $kkNro .'" selected>' .$kk : $kkNro .'">' .$kk ));
									 echo "</option>";
								}
								echo "</select>\n";
								
								// Vuosi alasvetovalikko, loopataan vuodet 1990-2030
								// Mutta ei laiteta vuosilistaan uudempaa vuotta kuin nykyvuosi
								// Nykyinen systeemi lisää automaattisesti vuoteen 2030 asti
                            	// Jos syöttökentässä on ollut virhe, palautetaan annettu arvo
								echo '<label>'.'&nbsp;&nbsp;'.'Vuosi:'.'&nbsp;'.'</label>' ."\n";
								echo '<select class="selectpicker" data-width="auto" name="vuosi">';
								echo '<option value="none"', ($lisaa->getVuosi() == 'none') 
								? 'selected':'' ,'>Vuosi</option>';
								echo "\n";
									$nykyVuosi = (new DateTime)->format("Y");
									
										for($vuosNro=1991;$vuosNro<=2031;$vuosNro++){
											$vuos=strftime('%Y', mktime(0,0,0,0,0,$vuosNro));
											if ($vuos<=$nykyVuosi) {
												
									 echo '<option value="'.(($syottoVirhe == FALSE) ? $vuos .'">' .$vuos
									 	: (($lisaa->getVuosi() == $vuos) ? $vuos .'" selected>' .$vuos : $vuos .'">' .$vuos ));
									 echo "</option>";
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
	                             	<?php echo (($lisaa->getVirhe($levytilaVirhe)) == null
	                             	? '<div class="input-group">' : '<div class="input-group has-error">' );?>
	                                
	                                <span class="input-group-addon"><i class="glyphicon glyphicon-hdd"></i></span>
	                                
	                                <input name="levytila" class="form-control" type="number" min="1" value=<?php
	                             		echo (($syottoVirhe == FALSE)) ? '""' : '"'.$lisaa->getLevytila().'"';?> placeholder="100"/>
                            	</div> <!-- ./input-group -->
							</div> <!-- ./form-group -->

							  <!-- ** KÄYTTÖJÄRJESTELMÄ ** -->
							  <!-- valinnat tehty n00b tyylillä, eikä ole käytetty mitään muuuttujia, listoja saatikka luokkia -->
                            <div class="form-group">
                                <label>Käyttöjärjestelmä</label>
                              
                             <!-- Tarkistetaan onko syöttökentässä virhe, jos on korostetaan kehys punaisella --> 
                             <?php echo (($lisaa->getVirhe($kayttoJarjestelmaVirhe)) == null
                             	? '<div class="input-group">' : '<div class="input-group has-error">' );?>
                                

                                <span class="input-group-addon"><i class="glyphicon glyphicon-cog"></i></span>
                             
                             
											
                             <!-- Jos syöttökentässä on ollut virhe, palautetaan annettu arvo -->   
                                <select name="kayttoJarjestelma" class="form-control">
							<?php 
							echo '<option value="none"', ($lisaa->getKayttoJarjestelma() == 'none') 
								? 'selected':'' ,'>Valitse käyttöjärjestelmä</option>';
							echo "\n"; 
							
							echo '<option value="'.(($syottoVirhe == FALSE) ? 'Windows Server 2008">Windows Server 2008'
								: (($lisaa->getKayttoJarjestelma() == 'Windows Server 2008') 
								? 'Windows Server 2008" selected>Windows Server 2008' : 'Windows Server 2008">Windows Server 2008' ));
							echo "</option>\n";
							
							echo '<option value="'.(($syottoVirhe == FALSE) ? 'Windows Server 2008 R2">Windows Server 2008 R2'
									: (($lisaa->getKayttoJarjestelma() == 'Windows Server 2008 R2')
									? 'Windows Server 2008 R2" selected>Windows Server 2008 R2' : 'Windows Server 2008 R2">Windows Server 2008 R2' ));
							echo "</option>\n";
							
							echo '<option value="'.(($syottoVirhe == FALSE) ? 'Windows Server 2012">Windows Server 2012'
									: (($lisaa->getKayttoJarjestelma() == 'Windows Server 2012')
									? 'Windows Server 2012" selected>Windows Server 2012' : 'Windows Server 2012">Windows Server 2012' ));
							echo "</option>\n";
							
							echo '<option value="'.(($syottoVirhe == FALSE) ? 'Windows Server 2016">Windows Server 2016'
									: (($lisaa->getKayttoJarjestelma() == 'Windows Server 2016')
									? 'Windows Server 2016" selected>Windows Server 2016' : 'Windows Server 2016">Windows Server 2016' ));
							echo "</option>\n";
							
							
 							?>
                                	</select>
                            	</div> <!-- ./input-group -->
							</div> <!-- ./form-group -->

							  <!-- ** LISÄTIETOA ** -->
                            <div class="form-group">
                                <label>Lisätietoa</label>
                             
                             <!-- Tarkistetaan onko syöttökentässä virhe, jos on korostetaan kehys punaisella -->    
                             <?php echo (($lisaa->getVirhe($lisatietoaVirhe)) == null
                             	? '<div class="input-group">' : '<div class="input-group has-error">' );?>

                                	<span class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></span>  
                                                            
                               <!-- Jos syöttökentässä on ollut virhe, palautetaan annettu arvo -->                
                                <textarea name="lisatietoa" class="form-control" rows="3"><?php
                             echo (($syottoVirhe == FALSE)) ? '' : $lisaa->getLisatietoa(); ?></textarea>
                            </div> <!-- ./input-group -->
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
                           
                         
                        </form>
                        
                        </div> <!-- /.vasen col-lg-6 -->
                        
						
                           <div class="col-lg-6">
                           
							
							<!--  Virheviestit  -->
							<!-- Asiakkaan nimi virheet -->  
							<div class="form-group" style="padding-top:3.5%;">
								<div class="input-group">
									<p>
		                            <?php echo (($lisaa->getVirhe($asiakkaanNimiVirhe)) 
		                            ? '<span style="color:red";>' .$lisaa->getVirhe($asiakkaanNimiVirhe). '</span>'
									: '&nbsp;');?>
		                            </p>
	                            </div>
                            </div>
                            
                            <!-- Sähköpostiosoite virheet -->
							<div class="form-group" style="padding-top:4%;">
								<div class="input-group">
									<p>
									<?php echo (($lisaa->getVirhe($sahkopostiosoiteVirhe)) 
		                            ? '<span style="color:red";>' .$lisaa->getVirhe($sahkopostiosoiteVirhe). '</span>'
									: '&nbsp;');?>
		                            </p>
	                            </div>
                            </div>
                            
                            <!-- Puhelinnumero virheet -->
							<div class="form-group" style="padding-top:4%;">
								<div class="input-group">
									<p>
									<?php echo (($lisaa->getVirhe($puhelinNumeroVirhe)) 
		                            ? '<span style="color:red";>' .$lisaa->getVirhe($puhelinNumeroVirhe). '</span>'
									: '&nbsp;');?>
		                          	</p>
	                            </div>
                            </div>
                          	
                          	<!-- Asennuspäivämäärä virheet -->
							<div class="form-group" style="padding-top:4%;">
								<div class="input-group">
									<p>
									<?php echo (($lisaa->getVirhe($asennusPaivamaaraVirhe)) 
		                            ? '<span style="color:red";>' .$lisaa->getVirhe($asennusPaivamaaraVirhe). '</span>'
									: '&nbsp;');?>
		                            </p>
	                            </div>
                            </div>
                            
                            <!-- Levytila virheet -->
                            <div class="form-group" style="padding-top:3.5%;">
								<div class="input-group">
									<p>
									<?php echo (($lisaa->getVirhe($levytilaVirhe)) 
		                            ? '<span style="color:red";>' .$lisaa->getVirhe($levytilaVirhe). '</span>'
									: '&nbsp;');?>
		                            </p>
	                            </div>
                            </div>
                            
                            <!-- Käyttöjärjestelmä virheet -->
                            <div class="form-group" style="padding-top:3.5%;">
								<div class="input-group">
									<p>
									<?php echo (($lisaa->getVirhe($kayttoJarjestelmaVirhe)) 
		                            ? '<span style="color:red";>' .$lisaa->getVirhe($kayttoJarjestelmaVirhe). '</span>'
									: '&nbsp;');?>
		                            </p>
	                            </div>
                            </div>
                            
                            <!-- Lisätietoa virheet -->
                            <div class="form-group" style="padding-top:7%;">
								<div class="input-group">
									<p>
									<?php echo (($lisaa->getVirhe($lisatietoaVirhe)) 
		                            ? '<span style="color:red";>' .$lisaa->getVirhe($lisatietoaVirhe). '</span>'
									: '&nbsp;');?>
		                        	</p>
	                            </div>
                            </div>
                             
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