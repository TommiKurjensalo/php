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
                                     
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>

	<div class="etusivu">
           
			<h1>Note$ for bu$ine$$</h1>

	
	<div class="col-lg-8" style="padding: 0 0 0 50%;"> <!-- vasen col-lg-6 -->
	    <form class="form-signin" role="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">       
		    <h2 style="color:white;">Kirjautuminen</h2>
		    	<input type="text" class="form-control" name="username" placeholder="Tunnus" required autofocus />
		    	<input type="password" class="form-control" name="password" placeholder="Salasana" required />      
		    	<label class="checkbox" style="color:white; padding-left:6%;">
		    	<input type="checkbox" value="remember-me" id="rememberMe" name="rememberMe"> Muista minut</label>
		    <button class="btn btn-lg btn-primary btn-block" type="submit">Kirjaudu</button>   
	    </form>
  	</div>
  	
  
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
