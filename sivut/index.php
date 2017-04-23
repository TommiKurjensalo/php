<?php 
require_once "keijoLuokka.php";

// Käynnistetään sessio
session_start ();

// Onko painettu kirjaudu-painiketta
	if (isset($_POST["kirjaudu"])) {
		
		// Tarkistetaan, että nimi ja salasana kenttään on syötetty jotain
		if(!empty($_POST["keijoNimi"]) && !empty($_POST["keijoKovaKasi"])) {
						
		
		// Luodaan uusi olio luokalle
		$keijo = new Keijo();
		// Lähetetään tunnus ja salasana keijoLuokalle, joka tarkistaa tunnukset tietokannasta
		$lkm = $keijo->keijollaOnKovaKasi($_POST["keijoNimi"], $_POST["keijoKovaKasi"]);
		
		// echo '<div style="padding-left:300px;">rivit: ' .var_dump($rivit). '</div>';
		
		if ($lkm > 0) {
			
			// Jos käyttäjä valitsi muista minut, asetetaan cookie joka on voimassa 30päivää
			if (!empty($_POST["muistaMinut"])) {
				setcookie("member_keijo", $_POST["keijoNimi"], time() + (86400 * 30), "/"); // 86400 = 1 pv
				setcookie("member_kovaKasi", $_POST["keijoKovaKasi"], time() + (86400 * 30), "/"); // 86400 = 1 pv
			} else {
				if(isset($_COOKIE["member_keijo"])) {
					setcookie ("member_keijo","");
				}
				if(isset($_COOKIE["member_kovaKasi"])) {
					setcookie ("member_kovaKasi","");
				}
			}
			
			$_SESSION['onKirjauduttu'] = true;
			
			// Asetetaan nimi ja salasana tiedot sessioon
			$_SESSION['keijoNimi'] = $_POST["keijoNimi"];
			$_SESSION['keijoKovaKasi'] = $_POST["keijoKovaKasi"];
			
			$_SESSION['start'] = time(); // Otetaan sisäänkirjautumisaika talteen.
			
			// Päätetään istunto 60min kirjautumisesta.
			$_SESSION['expire'] = $_SESSION['start'] + (60 * 60);
			$_SESSION['tervetuloa'] = "Tervetuloa ".$_SESSION['keijoNimi'];
			session_write_close ();
			header('Location: index.php');
			exit();
		} else {
			$_SESSION['onKirjauduttu'] = false;
			$_SESSION['message'] = "Virheellinen käyttäjätunnus tai salasana";
			session_write_close ();
			header('Location: index.php');		
			exit();
		}

	} else {
		$_SESSION['onKirjauduttu'] = false;
		$_SESSION['message'] = "Käyttäjätunnus ja/tai salasana kenttä olivat tyhjiä";
		header('Location: index.php');
		session_write_close ();
		exit();
	}
	
	session_write_close ();
	
	
}  else {
	

	$now = time(); // Laitetaan nykyhetki muuttujaan
	// Tarkistetaan, että on sisäänkirjauduttu ja sessioaika ei ole vielä mennyt umpeen
	if (isset($_SESSION['onKirjauduttu']) && is_bool($_SESSION['onKirjauduttu'] === true) && $now <= $_SESSION['expire']) {
		
		// Jos sivulle tultiin ensimmäistä kertaa
		// Tarkistetaan onko sessiota jo olemassa
		if (!isset($_SESSION['message'])) {
			$_SESSION['message'] = "";
			$_SESSION['onKirjauduttu'] = false;
		} elseif ($_SESSION['onKirjauduttu'] === true) {
			$_SESSION['onKirjauduttu'] = true;
		}
	
	} else {
	
			
	}
	
}

// Jos käyttäjä valitsi kirjaudu ulos
if (isset($_GET["kirjauduUlos"])) {

	// Poistetaan PHPSESSID selaimesta
	if ( isset( $_COOKIE[session_name()] ) )
	setcookie( session_name(), “”, time()-3600, “/” );
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
                
                <?php 
               $now = time(); // Laitetaan nykyhetki muuttujaan
                // Tarkistetaan, että on sisäänkirjauduttu ja sessioaika ei ole vielä mennyt umpeen
                if (isset($_SESSION['onKirjauduttu']) && is_bool($_SESSION['onKirjauduttu'] === true) && $now <= $_SESSION['expire']) {
                	
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

	<div class="etusivu">
           
			<h1>Note$ for bu$ine$$</h1>

	<div class="col-lg-10" style="padding: 1% 5% 0 40%;"> <!-- col-lg-10 -->
	<?php
	print '<form class="form-signin" role="form" action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'" method="post">'."\n";
			
			
	if (!isset($_SESSION['onKirjauduttu'])) {
		
		print '<div style="background: rgba(60, 60, 60, 0.5); border:1px solid black; padding:10%;">'."\n".
				'<h2 style="color:white;">Kirjautuminen</h2>'."\n".
		    	'<input type="text" class="form-control" name="keijoNimi" placeholder="Tunnus" value="'.(isset($_COOKIE["keijoNimi"]) ? $_COOKIE["keijoNimi"].'"'
		    			:"").'" required autofocus />'."\n".
		    	'<input type="password" class="form-control" name="keijoKovaKasi" value="'.(isset($_COOKIE["keijoKovaKasi"]) ? $_COOKIE["keijoKovaKasi"]
		    			:"").'" required placeholder="Salasana" />'."\n".      
		    	'<label class="checkbox" style="color:white; padding-left:6%;">'."\n".
		    	'<input type="checkbox" value="remember-me" id="rememberMe" name="muistaMinut" '.(isset($_COOKIE["keijoNimi"]) ? 'checked':"").' > Muista minut</label>'."\n".
		    '<button name="kirjaudu" class="btn btn-lg btn-primary btn-block" type="submit">Kirjaudu</button>'."\n".
			'</div> <!-- / eof läpinäkyvä tausta -->';
		
		echo ((isset($_SESSION['message']))
				? '<h3 style="color:red; padding: 0 0 0 20%;"><b>'.$_SESSION['message'].'</b></h3>'
				:'');				
	} 
			
		echo ((isset($_SESSION['tervetuloa']))
				? '<h3 style="color:green; padding: 0 0 0 30%;"><b>'.$_SESSION['tervetuloa'].'</b></h3>'
				:'');
		
		if (isset($_COOKIE["isDebug"])) {
			echo '<div style="color:white;">';
			echo (isset($_SESSION['onKirjauduttu']) ? 'onKirjauduttu: true ':'onKirjauduttu: false ');
			echo (isset($_SESSION['expire']) ? ' exp: ' .$now.'<=' .$_SESSION['expire'] :' false ');
			echo (isset($_SESSION['start']) ? ' start: '. $_SESSION['start'] :' false ');
			echo '</div>';
		}
		print '</form>'."\n";
	   	 ?>
	   
  	</div> <!-- ./ col-lg-10 -->

  
	</div>
        <!-- /.etusivu -->
        
	</div>
    <!-- /#wrapper -->
    
    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

</body>

</html>
