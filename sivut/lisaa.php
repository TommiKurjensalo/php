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

                            <!-- ** ASIAKKAAN NIMI ** -->
                            <div class="form-group">
                                <label>Asiakkaan nimi</label>

                             <?php if (($lisaa->getVirhe($asiakkaanNimiVirhe)) == null) {
                             	echo '<div class="input-group">';                                           	
                             } else {
                             	echo '<div class="input-group has-error">';                           	
                             }?>  
                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                                     
                            <input name="asiakkaanNimi" class="form-control" type="text" <?php 
                            if (($lisaa->getVirhe($asiakkaanNimiVirhe)) == null) {echo ' value="'.$lisaa->getAsiakkaanNimi().'"';} ?>placeholder="Neste Oy"></input>
							
							
                            </div> <!-- ./input-group -->
							</div> <!-- ./form-group -->
							<!-- <p><?php print ('<span style="color:red";>' . $lisaa->getVirhe($asiakkaanNimiVirhe) . "</span>");?></p> -->
							
                            <div class="form-group">
                                <label>Sähköpostiosoite</label>
                            
                              <?php if (($lisaa->getVirhe($sahkopostiosoiteVirhe)) == null) {
                             	echo '<div class="input-group">';                                           	
                             } else {
                             	echo '<div class="input-group has-error">';                           	
                             }?> 
                            
                                <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                                
                                
                                <input name="sahkopostiosoite" class="form-control" type="email" <?php 
                            if (($lisaa->getVirhe($sahkopostiosoiteVirhe)) == null) {echo ' value="'.$lisaa->getSahkopostiosoite().'"';} ?>placeholder="nimi@esimerkki.fi"></input>
                           
                            </div> <!-- ./input-group -->
                            <!-- <p><?php print ('<span style="color:red";>' . $lisaa->getVirhe($sahkopostiosoiteVirhe) . "</span>");?></p> -->
							</div> <!-- ./form-group -->
                            
                              <!-- ** PUHELINNUMERO ** -->
                            <div class="form-group">
                                <label>Puhelinnumero</label>
                                
                              <?php if (($lisaa->getVirhe($puhelinNumeroVirhe)) == null) {
                             	echo '<div class="input-group">';                                           	
                             } else {
                             	echo '<div class="input-group has-error">';                           	
                             }?> 
                            
                                <span class="input-group-addon"><i class="glyphicon glyphicon-phone"></i></span>
                                
                                
                                <input name="puhelinNumero" class="form-control" type="tel" <?php 
                            if (($lisaa->getVirhe($puhelinNumeroVirhe)) == null) {echo ' value="'.$lisaa->getPuhelinNumero().'"';} ?>placeholder="040-3493384"></input>
                            </div> <!-- ./input-group -->
                           <!-- <p><?php print ('<span style="color:red";>' . $lisaa->getVirhe($puhelinNumeroVirhe) . "</span>");?></p> -->
							</div> <!-- ./form-group -->

							  <!-- ** ASENNUSPÄIVÄMÄÄRÄ ** -->
							<div class="form-group">
                            
                            	<span class="glyphicon glyphicon-calendar"></span>
                            	<label>Asennuspäivämäärä</label>
                           	
                            	
                             <?php if (($lisaa->getVirhe($asennusPaivamaaraVirhe)) == null) {
                             	echo '<div class="form-inline">';                                           	
                             } else {
                             	echo '<div class="form-inline has-error">';                           	
                             }?> 
							

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
                            	//echo "<div class='input-group'>";
                            		
                            	echo '<label>Päivä:' . '&nbsp;' . ' </label>';
                            	echo '<select class="selectpicker" data-width="auto" name="paiva">';
								echo '<option value="none"', ($lisaa->getPaiva() == 'none') 
								? 'selected':'' ,'>Päivä</option>';
                            	for($i=1;$i<=31;$i++){
									$pv=strftime($format, mktime(0,0,0,0,$i));
									echo '<option value='. $i.'>'.$pv.'</option>';
                            	}
                            	echo "</select>";
                            	//echo "</div>";
                            	
                            	// Kuukausi alasvetovalikko, loopataan kuukaudet 1-12 ilman etunollia
                            	// echo "<div style='margin-left:5%;'>";
                            	echo '<label>'.'&nbsp;&nbsp;'.'Kuukausi:' . '&nbsp;' . '</label>';
								echo '<select class="selectpicker" data-width="auto" name=kuukausi>';
								echo '<option value="none"', ($lisaa->getKuukausi() == 'none') 
								? 'selected':'' ,'>Kuukausi</option>';
								for($i=1;$i<=12;$i++){
									$kk=strftime('%B', mktime(0,0,0,$i));
									echo "<option value='". $i."'>".$kk."</option>";
								}
								echo "</select>";
								//echo "</div>";
								
								// Vuosi alasvetovalikko, loopataan vuodet 1990-2030
								// Mutta ei laiteta vuosilistaan uudempaa vuotta kuin nykyvuosi
								// Nykyinen systeemi lisää automaattisesti vuoteen 2030 asti
								//echo "<div class='form-group' style='margin-left:5%;'>";
								echo '<label>'.'&nbsp;&nbsp;'.'Vuosi:'.'&nbsp;'.' </label>';
								echo '<select class="selectpicker" data-width="auto" name=vuosi>';
								echo '<option value="none"', ($lisaa->getVuosi() == 'none') 
								? 'selected':'' ,'>Vuosi</option>';
									$nykyVuosi = (new DateTime)->format("Y");
									
										for($i=1991;$i<=2031;$i++){
											$vuos=strftime('%Y', mktime(0,0,0,0,0,$i));
											if ($vuos<=$nykyVuosi) {
												echo "<option value='".$vuos."'>".$vuos."</option>";
											}
										
									}
								echo "</select>";
								//echo "</div>";
								?>
                                </div> <!-- ./form-inline -->
                           </div> <!-- ./form-group -->
                            
                              <!-- ** LEVYTILA ** -->
                            <div class="form-group">
                                <label>Levytila (Gt)</label>
                                
                             <?php if (($lisaa->getVirhe($levytilaVirhe)) == null) {
                             	echo '<div class="input-group">';                                           	
                             } else {
                             	echo '<div class="input-group has-error">';                           	
                             }?> 
                                
                                <span class="input-group-addon"><i class="glyphicon glyphicon-hdd"></i></span>
                                
                                
                                <input name="levytila" class="form-control" type="number"<?php 
                            if (($lisaa->getVirhe($levytilaVirhe)) == null) {echo ' value="'.$lisaa->getLevytila().'"';} ?> placeholder="100"></input>
                            </div> <!-- ./input-group -->
                           <!-- <p><?php print ('<span style="color:red";>' . $lisaa->getVirhe($levytilaVirhe) . "</span>");?></p> -->
							</div> <!-- ./form-group -->

							  <!-- ** KÄYTTÖJÄRJESTELMÄ ** -->
                            <div class="form-group">
                                <label>Käyttöjärjestelmä</label>
                                
                             <?php if (($lisaa->getVirhe($kayttoJarjestelmaVirhe)) == null) {
                             	echo '<div class="input-group">';                                           	
                             } else {
                             	echo '<div class="input-group has-error">';                           	
                             }?> 
                                

                                <span class="input-group-addon"><i class="glyphicon glyphicon-cog"></i></span>
                                
                                <select name="kayttoJarjestelma" class="form-control">
							<?php echo '<option value="none"', ($lisaa->getKayttoJarjestelma() == 'none') 
							? 'selected':'' ,'>Valitse käyttöjärjestelmä</option>'; ?>                    
                            <?php echo '<option ', ($lisaa->getKayttoJarjestelma() == 'Windows Server 2008') 
                            ? 'selected':'' ,'>Windows Server 2008</option>'; ?>
                            <?php echo '<option ', ($lisaa->getKayttoJarjestelma() == 'Windows Server 2008 R2') 
                            ? 'selected':'' ,'>Windows Server 2008 R2</option>'; ?>
                            <?php echo '<option ', ($lisaa->getKayttoJarjestelma() == 'Windows Server 2012') 
                            ? 'selected':'' ,'>Windows Server 2012</option>'; ?>
                            <?php echo '<option ', ($lisaa->getKayttoJarjestelma() == 'Windows Server 2016') 
                            ? 'selected':'' ,'>Windows Server 2016</option>'; ?>
                                </select>
                            </div> <!-- ./input-group -->
                          <!--  <p><?php print ('<span style="color:red";>' . $lisaa->getVirhe($kayttoJarjestelmaVirhe) . "</span>");?></p> -->
							</div> <!-- ./form-group -->

							  <!-- ** LISÄTIETOA ** -->
                            <div class="form-group">
                                <label>Lisätietoa</label>
                                
                             <?php if (($lisaa->getVirhe($lisatietoaVirhe)) == null) {
                             	echo '<div class="input-group">';                                           	
                             } else {
                             	echo '<div class="input-group has-error">';                           	
                             }?> 

                                <span class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></span>  
                                
                                              
                                <textarea name="lisatietoa" class="form-control" rows="3"><?php 
                            if (($lisaa->getVirhe($lisatietoaVirhe)) == null) {echo $lisaa->getLisatietoa();} ?></textarea>
                            </div> <!-- ./input-group -->
                          <!--  <p><?php print ('<span style="color:red";>' . $lisaa->getVirhe($lisatietoaVirhe) . "</span>");?></p> -->
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
							 
							<br> <br>
                            <?php print ("<span style='color:red';>" . $lisaa->getVirhe($asiakkaanNimiVirhe) . "</span>");?></p>
                            
							<br> <br> 
                            <?php print ("<span style='color:red';>" . $lisaa->getVirhe($sahkopostiosoiteVirhe) . "</span>");?></p>
                            
							<br> <br>
                            <?php print ("<span style='color:red';>" . $lisaa->getVirhe($puhelinNumeroVirhe) . "</span>");?></p>
                          
                          	
							<br> <br>
                            <?php print ("<span style='color:red';>" . $lisaa->getVirhe($asennusPaivamaaraVirhe) . "</span>");?></p>
                            
                            <br> <br>
                            <?php print ("<span style='color:red';>" . $lisaa->getVirhe($levytilaVirhe) . "</span>");?></p>
                            
                            <br> <br> 
                            <?php print ("<span style='color:red';>" . $lisaa->getVirhe($kayttoJarjestelmaVirhe) . "</span>");?></p>
                            
                            <br> <br> <br> <br>
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