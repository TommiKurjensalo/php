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
                        <a href="muokkaa.php" class="active"><i class="fa fa-fw fa-edit"></i> Muokkaa</a>
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
                            Muokkaa asiakastietoja
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i>  <a href="index.php">Hallintapaneli</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-edit"></i> Muokkaa
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->

                <div class="row">
                    <div class="col-lg-4">

                        <form role="form">

                            <div class="form-group">
                                <label>Asiakkaan nimi</label>
                                <input class="form-control" type="text" placeholder="Neste Oy">
                            </div>

                            <div class="form-group">
                                <label>Sähköpostiosoite</label>
                                <input class="form-control" type="email" placeholder="nimi@esimerkki.fi"></input>
                            </div>
                            
                            <div class="form-group">
                                <label>Puhelinnumero</label>
                                <input class="form-control" type="tel" placeholder="040-3493384"></input>
                            </div>

                            <div class="form-group">
                                <label>Asennuspäivämäärä</label>
                                <input class="form-control" type="date" placeholder="27.03.2017"></input>
                            </div>
                            
                            <div class="form-group">
                                <label>Levytila (Gt)</label>
                                <input class="form-control" type="number" placeholder="100"></input>
                            </div>

                            <div class="form-group">
                                <label>Käyttöjärjestelmä</label>
                                <select class="form-control">
                                    <option>Windows Server 2008</option>
                                    <option>Windows Server 2008 R2</option>
                                    <option>Windows Server 2012 R2</option>
                                    <option>Windows Server 2016</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Lisätietoa</label>
                                <textarea class="form-control" rows="3"></textarea>
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

                    </div>
                    
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
