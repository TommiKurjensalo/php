<?php
// Liitetään lomakekenttien käsittelyyn tarkoitettu luokka
require_once "lisaaLuokka.php";
require_once "listaaKaikkiLuokka.php";

// Käynnistetään sessio
session_start ();
	
// Alustetaan muuttuja $syottoVirhe
$syottoVirhe = FALSE;


// Onko painettu tallenna-painiketta
if (isset($_POST["hae"])) {

   // Viedään muodostimelle kenttien arvot
   $lisaa = new Lisaa(0,
   		$_POST["asiakkaanNimi"],
   		$_POST["paiva"],
   		$_POST["kuukausi"],
   		$_POST["vuosi"],
   		$_POST["kayttoJarjestelmaId"]
   		);
   
   // Haetaan mahdolliset virhekoodit
   $asiakkaanNimiVirhe = $lisaa->checkAsiakkaanNimi(FALSE,0,50);
   $asennusPaivamaaraVirhe = $lisaa->checkAsennusPaivamaara(FALSE);
   $kayttoJarjestelmaVirhe = $lisaa->checkKayttoJarjestelma(FALSE);
    
   // Haetaan mahdolliset syöttövirheet ja annetaan boolean tyyppinen true tai false arvo
   if ($asiakkaanNimiVirhe > 0) $syottoVirhe = TRUE;
   if ($asennusPaivamaaraVirhe > 0) $syottoVirhe = TRUE;
   if ($kayttoJarjestelmaVirhe > 0) $syottoVirhe = TRUE;
   
}

// Sivulle tultiin ensimmäistä kertaa
else {

	$now = time(); // Laitetaan nykyhetki muuttujaan
	// Tarkistetaan, että on sisäänkirjauduttu ja sessioaika ei ole vielä mennyt umpeen
	if (isset($_SESSION['onKirjauduttu']) && $_SESSION['onKirjauduttu'] === true && $now <= $_SESSION['expire']) {
	
		// Tehdään tyhjä olio
		$lisaa = new Lisaa();
		// Nollataan virhekoodit
		$asiakkaanNimiVirhe = 0;
		$puhelinNumeroVirhe = 0;
		$asennusPaivamaaraVirhe = 0;
		$kayttoJarjestelmaVirhe = 0;
		
	} else {
	
		header('Location: index.php');
		exit;
			
	}
	
}

// Jos käyttäjä valitsi kirjaudu ulos
if (isset($_GET["kirjauduUlos"])) {


	// Tyhjennetään sessiot globaalisti
	$_SESSION = array();

	if (ini_get("session.use_cookies")) {
		$params = session_get_cookie_params();
		setcookie(session_name(), '', time() - 42000,
				$params["path"], $params["domain"],
				$params["secure"], $params["httponly"]
		);
	}
	
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

    <script type="text/javascript">
		function GetClock(){
		var d=new Date();
		var nmonth=d.getMonth(),ndate=d.getDate(),nyear=d.getYear();
		if(nyear<1000) nyear+=1900;
		var nhour=d.getHours(),nmin=d.getMinutes(),nsec=d.getSeconds();
		if(nmin<=9) nmin="0"+nmin
		if(nsec<=9) nsec="0"+nsec;
		
		document.getElementById('clockbox').innerHTML=""+ndate+"."+(nmonth+1)+"."+nyear+" "+nhour+":"+nmin+":"+nsec+"";
		}
		
		window.onload=function(){
		GetClock();
		setInterval(GetClock,1000);
		}
		// http://www.webestools.com/scripts_tutorials-code-source-7-display-date-and-time-in-javascript-real-time-clock-javascript-date-time.html

	</script>
    
</head>

<body>

    <div id="wrapper"> <!-- koko sivun "käärre" -->

        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                 <a class="navbar-brand" href="index.php">Notes for business</a>
                     <div class="form-inline" style="font-size:1.2em; color:#F0F0F0; margin:0.7% 0 0 73%; width:30%">
			              <?php 
			              // Määritetään oletus aikavyöhyke ja maa-asetukset
			              date_default_timezone_set('Europe/Helsinki');
			              setlocale(LC_ALL, array('fi_FI.UTF-8','fi_FI@euro','fi_FI','finnish'));
			              
			              echo 'Sessio vanhenee: '. date("j.n.Y H:i:s ",$_SESSION['expire']) .
			                	' Pvm/klo: <span id="clockbox"></span>';
			              ?>
               		 </div>  
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
                            Hae / Poista asiakastietoja
                        </h1>
                        <!--  Debuggausta varten
                        <?php 
                        if (isset($_COOKIE["isDebug"])) {
                        	echo ' nimi: ' .$asiakkaanNimiVirhe;
			  				echo ' pvm: ' .$asennusPaivamaaraVirhe;
			   				echo ' os: ' .$kayttoJarjestelmaVirhe;
                        }
			   			?>
			   				-->
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i>  <a href="index.php">Etusivu</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-edit"></i> Hae / Poista
                            </li>
                        </ol>
                    </div> <!-- /. heading col-lg-12 -->
                </div> <!-- /. heading row -->
                

                
                    <div class="row">
                   <!--  <?php  echo 'Syöttövirheet: ' . (($syottoVirhe == TRUE) ? 'true' : 'false'); ?>  -->
						<div class="col-sm-12"> <!-- painike col-lg-12 -->
                        	<form class="form-inline" role="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                        	
							   	<!-- ** ASIAKKAAN NIMI ** -->
								<label>Asiakkaan nimi</label>  
									
                                 <!-- Tarkistetaan onko syöttökentässä virhe, jos on korostetaan kehys punaisella -->
                            	 <?php echo ($lisaa->getVirhe($asiakkaanNimiVirhe) == null 
                             		? '<div class="input-group mb-2 mr-sm-2 mb-sm-0">' : '<div class="input-group has-error mb-2 mr-sm-2 mb-sm-0">' );?>
                            
	                            <!-- Jos syöttökentässä on ollut virhe, palautetaan annettu arvo -->                       
	                            <div class="input-group-addon"><i class="glyphicon glyphicon-user"></i></div>
	                            <input name="asiakkaanNimi" class="form-control" type="text" value=
	                            <?php echo (($syottoVirhe == FALSE) ? '""' : (empty($lisaa->getAsiakkaanNimi()) || ($lisaa->getAsiakkaanNimi() == null)) ? '""' 
								: '"'.$lisaa->getAsiakkaanNimi().'"');?> placeholder="Neste Oy"/>
								<?php echo '</div>' ?> 
								
                            
 								<!-- ** ASENNUSPÄIVÄMÄÄRÄ ** -->	

 							
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
                            	echo '<label>Asennuspäivämäärä:' . '&nbsp;</label>';
                            	// Aloitus input-group
                            	echo '<div class="input-group mb-2 mr-sm-2 mb-sm-0">';
                            	echo '<div class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></div>';
                            	echo '<select class="selectpicker" data-width="auto" name="paiva">' ."\n";
								echo '<option value="none"', ($lisaa->getPaiva() == 'none') 
								? ' selected':'' ,'>Päivä</option>';
								echo "\n";
                            	for($pvmNro=1;$pvmNro<=31;$pvmNro++){
									$pv=strftime($format, mktime(0,0,0,0,$pvmNro));
									
									 echo '<option value="'.(($syottoVirhe == FALSE) ? $pv .'">' .$pv 
									 	: (($lisaa->getPaiva() == $pv) ? $pv .'" selected>' .$pv : $pv .'">' .$pv ));
									 echo "</option>" ."\n";
                            	}
                            	echo "</select>" ."\n";
                            	
                            	// Kuukausi alasvetovalikko, loopataan kuukaudet 1-12 ilman etunollia
                            	// Jos syöttökentässä on ollut virhe, palautetaan annettu arvo
                            	echo '<label style="margin-top:8%;">'.'&nbsp;&nbsp;'.'Kuukausi:' . '&nbsp;' . '</label>' ."\n";
                            	//echo '<div class="input-group mb-2 mr-sm-2 mb-sm-0">';
                            	echo '<div class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></div>';
								echo '<select class="selectpicker" data-width="auto" name="kuukausi">';
								echo '<option value="none"', ($lisaa->getKuukausi() == 'none') 
								? ' selected':'' ,'>Kuukausi</option>';
								echo "\n";
								for($kkNro=1;$kkNro<=12;$kkNro++){
									$kk=strftime('%B', mktime(0,0,0,$kkNro));

									 echo '<option value="'.(($syottoVirhe == FALSE) ? $kkNro .'">' .$kk
									 	: (($lisaa->getKuukausi() == $kkNro) ? $kkNro .'" selected>' .$kk : $kkNro .'">' .$kk ));
									 echo "</option>" ."\n";
								}
								echo "</select>\n";
								
								// Vuosi alasvetovalikko, loopataan vuodet 1990-2030
								// Mutta ei laiteta vuosilistaan uudempaa vuotta kuin nykyvuosi
								// Nykyinen systeemi lisää automaattisesti vuoteen 2030 asti
                            	// Jos syöttökentässä on ollut virhe, palautetaan annettu arvo
								echo '<label>'.'&nbsp;&nbsp;'.'Vuosi:'.'&nbsp;'.'</label>' ."\n";
								//echo '<div class="input-group mb-2 mr-sm-2 mb-sm-0">';
								echo '<div class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></div>';
								echo '<select class="selectpicker" data-width="auto" name="vuosi">';
								echo '<option value="none"', ($lisaa->getVuosi() == 'none') 
								? ' selected':'' ,'>Vuosi</option>';
								echo "\n";
									$nykyVuosi = (new DateTime)->format("Y");
									
										for($vuosNro=1991;$vuosNro<=2031;$vuosNro++){
											$vuos=strftime('%Y', mktime(0,0,0,0,0,$vuosNro));
											if ($vuos<=$nykyVuosi) {
												
									 echo '<option value="'.(($syottoVirhe == FALSE) ? $vuos .'">' .$vuos
									 	: (($lisaa->getVuosi() == $vuos) ? $vuos .'" selected>' .$vuos : $vuos .'">' .$vuos ));
									 echo "</option>" ."\n";
											}
										
									}
								echo "</select></div>\n"; // end of class input-group
								
								?>
                                
                          
                           
                            <!-- ** KÄYTTÖJÄRJESTELMÄ ** -->
							  <!-- valinnat tehty n00b tyylillä, eikä ole käytetty mitään muuuttujia, listoja saatikka luokkia -->
                           
                                <label>Käyttöjärjestelmä</label>
                              
									<div class="input-group">
                                
                                		<span class="input-group-addon"><i class="glyphicon glyphicon-cog"></i></span>
											
								<select name="kayttoJarjestelmaId" class="form-control">
							<?php 
							echo '<option value="none"', ($lisaa->getKayttoJarjestelmaId() == 'none') 
								? 'selected':'' ,'>Valitse käyttöjärjestelmä</option>';
							echo "\n"; 
									
							echo '<option value="'.(($syottoVirhe == FALSE) ? '1">Windows Server 2008'
								: (($lisaa->getKayttoJarjestelmaId() === '1') 
								? '1" selected>Windows Server 2008' : '1">Windows Server 2008' ));
							echo "</option>\n";
							
							echo '<option value="'.(($syottoVirhe == FALSE) ? '2">Windows Server 2008 R2'
									: (($lisaa->getKayttoJarjestelmaId() === '2')
									? '2" selected>Windows Server 2008 R2' : '2">Windows Server 2008 R2' ));
							echo "</option>\n";
							
							echo '<option value="'.(($syottoVirhe == FALSE) ? '3">Windows Server 2012'
									: (($lisaa->getKayttoJarjestelmaId() === '3')
									? '3" selected>Windows Server 2012' : '3">Windows Server 2012' ));
							echo "</option>\n";
							
							echo '<option value="'.(($syottoVirhe == FALSE) ? '4">Windows Server 2016'
									: (($lisaa->getKayttoJarjestelmaId() === '4')
									? '4" selected>Windows Server 2016' : '4">Windows Server 2016' ));
							echo "</option>\n";
							
							
 							?>
								</select>
									</div> <!-- ./input-group -->
							
									
                            
	                           	<!-- ** TALLENNA PAINIKKE ** -->
	                           	<span class="icon-input-btn"><span class="glyphicon glyphicon-ok"></span>
                    			<input name="hae" type="submit" class="btn btn-primary px-2" value="Hae"></span> 
                             

                         	
                         		<div class="pull-right input-group" style="background:yellow; margin-top:0.5%;">
                         	   <?php 
                        		try {
                        			require_once "PDO.php";
                        			$Database = new Database();
                        			
									echo ' DB Yhteys: ' .($Database->isConnected() ? 'ON' : 'OFF');
									
                        		} catch (Exception $error) {
									print($error->getMessage());
								}
								?>
								</div>
								
								</form> <!-- /. lomakkeet -->
                         
                         <hr> <!-- line breaker -->
                         
                         </div> <!-- /. painike col-lg-12 -->
							

                         	
                         	<div id="haettuLista" class="col-sm-12"> <!-- tulostetut col-sm-12 -->
                        
                         <?php 
                        // Jos käyttäjä poisti jonkun 
                         if (isset($_POST["asiakasNro"])) {
                         	$kantakasittely = new Listaa();
                         	$poistaRivi = $kantakasittely->poistaAsiakas($_POST["asiakasNro"]);
                         	
                         	echo (($poistaRivi > 0) 
                         	? '<h3 style="color:green"><i class="glyphicon glyphicon-ok"></i>Asiakas ' .$_POST["asiakkaanNimi"]. ' poistettu onnistuneesti</h3>'
   							:'<h3 style="color:red"><i class="glyphicon glyphicon glyphicon-info-sign"></i>Asiakasta ' .$_POST["asiakkaanNimi"]. ' ei onnistuttu poistamaan</h3>');
                         }
                         //echo 'asiakasNro: ' .(isset($_POST["asiakasNro"]) ? $_POST["asiakasNro"] : '');
						
                         // Tulostetaan sivun otsikot
                         echo '<div class="table-responsive">';
	                         echo '<table class="table table-striped table-hover">';
		                         echo '<thead>';
			                         echo '<tr>';
				                         echo '<th>#</th>';
				                         echo '<th>Nimi</th>';
				                         echo '<th>Sähkopostiosoite</th>';
				                         echo '<th>Puhelinnumero</th>';
				                         echo '<th>Kayttojärjestelmä</th>';
				                         echo '<th>Asennuspäivamäärä</th>';
				                         echo '<th>Levytila(Gt)</th>';
				                         echo '<th>Lisätietoa</th>';
				                         echo '<th>Poista</th>';
			                         echo '</tr>';
		                         echo '</thead>';
                         echo '<tbody>';
                        
                         	// Jos käyttäjä klikkasi "hae" painiketta
                         	if (isset($_POST["hae"])) {
                         		
                           try {
                           			// Luodaan uusi olio, jotta voidaan hakea asiakkaita $lisaa olion avulla
									$kantakasittely = new Listaa();							
									$rivit = $kantakasittely->haeAsiakas($lisaa);
							
									// Tulostetaan haetut rivit
									foreach ( $rivit as $lisaa) {
								    	print("<tr>");
									    	print("<td>".utf8_encode($lisaa->getLisaaId())."</td>");
									    	print("<td>".utf8_encode($lisaa->getAsiakkaanNimi())."</td>");
									    	print("<td>".utf8_encode($lisaa->getSahkopostiosoite())."</td>");
									    	print("<td>".utf8_encode($lisaa->getPuhelinNumero())."</td>");
									    	print("<td>".utf8_encode($lisaa->getKayttoJarjestelmaNimi())."</td>");
									    	print("<td>".DateTime::createFromFormat('Y-m-d', $lisaa->getAsennusPaivamaara())->format('d.m.Y')."</td>");
									    	print("<td>".utf8_encode($lisaa->getLevytila())."</td>");
									    	print("<td>".$lisaa->getLisatietoa()."</td>");
									    	print '<form class="inline-form" role="form" action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'" method="post">';
									    	print '<input type="hidden" name="asiakasNro" value="'.$lisaa->getLisaaId().'"/>';
									    	print '<input type="hidden" name="asiakkaanNimi" value="'.$lisaa->getAsiakkaanNimi().'"/>';
									    	print '<td><button type="submit" name="poistaRivi" value="poistaAsiakasRivi" class="btn btn-danger">
    										<i class="glyphicon glyphicon glyphicon-remove"></i></button></td>';
									    	print '</form>';
								   	print("</tr>");
									}
									
							 	} catch (Exception $error) {
									print($error->getMessage());
								}
                         	}
								
								
						echo '</tbody>';
						echo '</table>';
						echo '</div>';
						 
						//  Kyselyn tulosrivien määrä
						print("<p>Haettu yhteensä " . (isset($rivit) && ($rivit !=null) ? count($rivit) : ' 0') . " riviä</p>");
                         
						?>
 					
                    
                    </div> <!-- /.tulostetut col-sm-12 -->
                        
                    
                </div> <!-- /.row -->

           
            </div>  <!-- /.container-fluid -->
            

        </div> <!-- /#page-wrapper -->
        
	
    </div> <!-- /#wrapper -->
    

    <!-- jQuery -->
    <script src="js/jquery-2.2.3.js"></script>

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

$(document).on("ready", function() {
	$.ajax({
		url: "asiakkaatJSON.php",
		method: "get",
		data: {nimi: $("#asiakkaanNimi").val()},
		dataType: "json", timeout: 5000
		dataType: "json",
		timeout: 5000
	})
.done(function(data) {
	$("#haettuLista").html("");
		for(var i = 0; i < data.length; i++) {
	$("#haettuLista").append(
		"<p>Nimi: " + data[i].asiakkaanNimi +
		"<br>Sähköposti: " + data[i].sahkopostiosoite +
		"<br>Puh: " + data[i].puhelinNumero +
		"<br>OS: " + data[i].kayttoJarjestelmaNimi + 
		"<br>Pvm: " + data[i].asennusPaivamaara +
		"<br>HDD: " + data[i].levytila +
		"<br>Info: " + data[i].lisatietoa + "</p>");
		} //for
	}) //done
	.fail(function() {
		$("#haettuLista").html("<p>Listausta ei voida tehdä</p>");
		}); //fail
	d}); //ready
	
</script>

</body>

</html>