<?php 
require_once "asetuksetLuokka.php";

// Käynnistetään sessio
session_start ();

// Onko painettu tallenna-painiketta
if (isset($_POST["tallenna"])) {
	
	// Viedään muodostimelle kenttien arvot	
		if (isset($_POST["debug"])) {
			$v_debug = true;
			
			// Kirjoitetaan session tiedot talteen
			$_SESSION ["s_debug"] = $v_debug;
			session_write_close ();
			
			// Asetetaan cookie, koska debug haluttiin päälle
			setcookie("isDebug", $_POST["debug"], time() +86400, "/"); // 86400 = 1 day
			
		//	echo "<br><div style='padding-left:300px;'> Cookies on päällä </div>"; 
			
			// Debug tulostus otetaan pois päältä
		} else {
				// Tuhotaan cookie, koska käyttäjä niin halusi
				setcookie("isDebug", "", time() - 3600, "/");
			
			//	echo "<br><div style='padding-left:300px;'>if else isset COOKIE[isDebug] ". (!isset($_COOKIE["isDebug"]) ? "false" : "true");
			//	echo (!isset($_COOKIE["isDebug"]) ? "<br> Cookies are disabled" :''). "</div>";
				

				$v_debug = false;
				// Kirjoitetaan session tiedot talteen
				$_SESSION ["s_debug"] = $v_debug;
				session_write_close ();
				
				
				
		}
		// Jos debug on päällä, tulostetaan tietoja
		if (isset($_COOKIE["isDebug"])) {
			echo "<div style='padding-left:300px;'>";
			echo "POST[debug]: ".(isset($_POST["debug"]) 
					? $_POST["debug"] : 'pois päältä') ."</div>";
				
		echo "<div style='padding-left:300px;'>if COOKIE[isDebug] sisältö: " .(isset($_COOKIE["isDebug"]) && !empty($_COOKIE["isDebug"]) 
			? 'true</div>' : 'false</div>');
		}

	// Jos debug on asetettu päällä ja sessio asetukset on olemassa, nollataan sessio debug
	// koska ei ole painettu tallenna valintaa
	}/* elseif (isset ( $_POST ["debug"] )) {
		if (isset ( $_SESSION ["s_debug"] )) {
			echo (isset($_COOKIE["isDebug"]) ? "<div style='padding-left:300px;'> elseif isset post&session </div>" :'');
			$_SESSION["s_debug"] = array ();
			session_write_close ();
			}
		
			// Tullaan sivulle
		} */
		else {
			
			
			$now = time(); // Laitetaan nykyhetki muuttujaan
			// Tarkistetaan, että on sisäänkirjauduttu ja sessioaika ei ole vielä mennyt umpeen
			if (isset($_SESSION['onKirjauduttu']) && $_SESSION['onKirjauduttu'] === true && $now <= $_SESSION['expire']) {
				
				// Jos cookiesta löytyy tieto, että debug tulostus on päällä
				// Laitetaan arvo myös paikalliselle muuttujalle
				if (isset($_COOKIE["isDebug"]) && !empty($_COOKIE["isDebug"])) {
					$v_debug = true;
					$_SESSION["s_debug"] = $v_debug;
					session_write_close();
				} 
				// Muuten laitetaan arvo falseksi
				else {
					$v_debug = false;
					$_SESSION["s_debug"] = $v_debug;
					session_write_close();
				}
				

			
				// Debug varten
				if (isset($_COOKIE["isDebug"])) {
					if (isset($_SESSION["s_debug"]) && !empty($_SESSION["s_debug"])) {
						echo  "<div style='padding-left:300px;'><br>else isset SESSION[s_debug] sisältö: ".$_SESSION["s_debug"]." </div>";
					}
						
					echo (isset($_COOKIE["isDebug"]) ?
							"<div style='padding-left:300px;'>" .
							" else isset COOKIE[isDebug] sisältö: " .$_COOKIE["isDebug"]. "</div>":'');
				} 
			
					} else {
					
						header('Location: index.php');
						exit;
							
					}
			
		}

// Jos käyttäjä valitsi kirjaudu ulos
if (isset($_GET["kirjauduUlos"])) {

	session_start ();
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
    <script src="js/bootstrap.min.js"></script>

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
<body>

    <div id="wrapper">

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
            </div>
            
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
            </div>
            <!-- /.navbar-collapse -->
        </nav>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Asetukset
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i>  <a href="index.php">Etusivu</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-edit"></i> Asetukset
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->

                <div class="row"> <!-- row -->


                  <form class="form-inline" role="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                    <div class="col-lg-2"> <!-- col-lg-2 - debug tulostus -->
                            <div class="form-check form-check-inline">
  							  <label class="form-check-label"> Debug tulostus päälle?
	                                	<input name="debug" type="checkbox" class="form-check-input" value="true"
	                                	<?php echo ((!empty($v_debug) && $v_debug === true) ? ' checked' : ''); ?> /> Kyllä/Ei</label>
	                        </div> <!-- ./ form-check -->

	                        <!--  Tallenna painike  -->
                          	<div class="form-group"> 		
                            		<input name="tallenna" type="submit" class="btn btn-primary px-2" value="Tallenna"/>                        
							</div> <!-- ./form-group -->
						 
						 
					</div> <!-- ./col-lg-2 - debug tulostus -->
					
					<div class="col-lg-2"> <!-- luo testi asiakkaita -->
						<label>Luodaanko 10kpl testiasiakkaita?</label>
							<?php
							// Jos luodaan testiasiakkaita, luodaan asiakas olio jolla viedään tiedot kantaan
								if (isset($_POST["luoTestiAsiakkaita"])) {
									try {
									
										$asiakas = new Asetukset();
										$rivit = $asiakas->lisaaTestiAsiakkaita();
									
										echo ((stripos($rivit[0], 'lisaa ok') !== FALSE && stripos($rivit[1], 
					                      'lisaa_kayttojarjestelma ok') !== FALSE)
					                       ? '<h3 style="color:green"><i class="glyphicon glyphicon-ok">
					                       </i> Testi asiakkaat on lisätty onnistuneesti!' 
											: '<h3>Lisäys epäonnistui</h3>');
									} catch (Exception $error) {
				
										print($error->getMessage());
										echo "<br>";
										}
								}
							?>
								<!-- luo testi asiakkaat painike -->
								<div class="form-group">
	                 					<input name="luoTestiAsiakkaita" type="submit" class="btn btn-primary px-2" value="Kyllä"/> 
								</div> <!-- ./form-group -->
								
						</div> <!-- ./col-lg-2 - luo testi asiakkaita -->
					</form>		
                            
                </div> <!-- /.row -->
                

            </div> <!-- /.container-fluid -->
            

        </div>  <!-- /#page-wrapper -->
       

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->

</body>

</html>