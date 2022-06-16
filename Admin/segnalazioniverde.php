<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin - Tables</title>

    <!-- Bootstrap core CSS-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>
    <!-- Custom fonts for this template-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Page level plugin CSS-->
    <link href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin.css" rel="stylesheet">

    <!-- grafico -->
    <link rel="stylesheet" href="css/graficostyle.css">


</head>

<body id="page-top">


<nav class="navbar navbar-expand navbar-dark bg-dark static-top">

    <a class="navbar-brand mr-1" href="" style="  "> Area riservata</a>

    <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
        <i class="fas fa-bars"></i>
    </button>
    <div class="titolo"><b>SEGNALAZIONI AREE VERDI </b> </a>

        <style>
            .titolo {
                font-size: 30px;
                color: white;
                margin-left: 30%;
            }
        </style>
    </div>

    <!-- INIZIO LOGOUT -->

    <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
        <ul class="navbar-nav ml-auto ml-md-0">
            <li class="nav-item dropdown no-arrow">
                <a class="nav-link dropdown-toggle" href="#" title="Logout" id="userDropdown" role="button"
                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-user-circle fa-fw"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                    <a class="dropdown-item" href="login.html" data-toggle="modal" data-target="#logoutModal">
                        Logout </a>
                </div>
            </li>
        </ul>
    </form>
</nav>

<!-- finestra avviso-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Sei sicuro di voler lasciare il sito?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Clicca "Logout" per uscire dal sito.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Annulla</button>
                <a class="btn btn-primary" href="login.php">Logout</a>
            </div>
        </div>
    </div>
</div>

<!-- FINE LOGOUT-->


<div id="wrapper">


    <!-- INIZIO SIDEBAR -->

    <ul class="sidebar navbar-nav" style="  ">
        <br>
        <li class="nav-item dropdown">
            <a class="nav-link" href="index.php">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Home</span>
            </a>
        </li>


        <li class="nav-item active">
            <a class="nav-link dropdown-toggle" id="pagesDropdown" role="button" data-toggle="dropdown"
               aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-fw fa-folder"></i>
                <span>Segnalazioni</span>
            </a>
            <div class="dropdown-menu" aria-labelledby="pagesDropdown">
                <a class="dropdown-item" href="segnalazionii.php">
                    <center><b>INDICE SEGNALAZIONI</b></center>
                </a>
                <a class="dropdown-item" href="segnalazioniverde.php" style=" background-color:orange;"> <b>
                        Segnalazione su aree verdi</b></a>
                <a class="dropdown-item" href="segnalazionirifiuti.php">Rifiuti e pulizia stradale</a>
                <a class="dropdown-item" href="segnalazionistrade.php">Strade e marciapiedi</a>
                <a class="dropdown-item" href="segnalazionisemafori.php">Segnaletica e semafori</a>
                <a class="dropdown-item" href="segnalazioniilluminazione.php">Illuminazione pubblica</a>
            </div>
        </li>

        <li class="nav-item dropdown">
            <a class="nav-link " href="team.php">
                <i class="fas fa-fw fa-folder"></i>
                <span>Team</span>
            </a>
    </ul>

    <!-- FINE SIDEBAR -->


    <div class="card mb-3" style="">
        <div class="card-header">
            <i class="fas fa-table"></i>
            Tabella Segnalazioni
        </div>
        <div class="card-body">

            <!-- MAPPA -->

            <style>
                #map {
                    height: 500px;
                    width: 100%;
                }

                * {
                    margin: 0;
                    padding: 0;
                }
            </style>
            </head>
            <body>

            <script>
                function initMap() {
                    var location = new google.maps.LatLng(40.382003, 17.367155);
                    var map = new google.maps.Map(document.getElementById("map"), {
                        zoom: 18,
                        center: location
                    });
                    <?php
                    require_once (dirname (__DIR__,1).'\db_connection.php');
                    $conn = DBconnection::OpenCon();
$sql = "SELECT * FROM segnalazioni where tipo = '1' ";
                    $result = mysqli_query($conn, $sql);
                    if ($result) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "
            var location = new google.maps.LatLng(" . htmlspecialchars($row['latitudine']) . "," . htmlspecialchars($row['longitudine']) . ");
            var marker = new google.maps.Marker({
              map: map,
              position: location

            }); ";
                        }
                    }
                    DBconnection::CloseCon();
                    ?>
                    /*var marker = new google.maps.Marker({
                            map: map,
                            position: location
                        });
                    var marker1 = new google.maps.Marker({
                      map: map,
                      position: location1
                    });*/

                }

            </script>

            <img src="img\disneyland.jpg">



            <!-- FINE MAPPA -->


            <br><br><br>
            <!-- Tabella -->
            <div class="table-responsive" style="overflow-x: scroll; ">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0"
                       style="background-color:white;">
                    <thead>
                    <tr>
                        <th>CODICE SEGNALAZIONE</th>
                        <th>DATA</th>
                        <th>ORA</th>
                        <th>VIA</th>
                        <th>DESCRIZIONE</th>
                        <th>FOTO</th>
                        <th>E-MAIL</th>
                        <th>STATO</th>
                        <th>TEAM</th>
                        <th>GRAVITA'</th>
                    </tr>
                    </thead>

                    <?php include("php/segnalazioniverde.php"); ?>

                </table>

                <!-- MODIFICA GRAVITA' -->

                <!-- inserimento da form del codice della segnalazione da modificare -->
                <br><br><br>

                <div class="card-header">
                    <i class="fas fa-table"></i>
                    Modifica gravità di una segnalazione
                </div>

                <form method="post" action="segnalazioniverde.php" style=" margin-top:5%; margin-left:5%">
                    <b> CODICE SEGNALAZIONE DA MODIFICARE: </b> <input type="text" name="idt"><br><br>
                    <b> INSERISCI LA GRAVITA' MODIFICATA: </b> <select class="text" name="gravit">

                        <option value="Alta">Alta</option>
                        <option value="Media">Media</option>
                        <option value="Bassa">Bassa</option>

                    </select>

                    <input type="submit" name="submit" class="btn btn-primary btn-block"
                           style="width:15%; margin-top:5%;">

                </form>

                <?php
                $conn = DBconnection::OpenCon();

                $idt = (isset($_POST['idt'])) ? $_POST['idt'] : null;
                $grav = (isset($_POST['gravit'])) ? $_POST['gravit'] : null;


                if (isset($_POST['submit'])) {

                    if ($idt && $grav !== null) {

                        $resultC = mysqli_query($conn, "SELECT * FROM segnalazioni WHERE tipo = '1'");
                        if ($resultC) {
                            $row = mysqli_fetch_assoc($resultC);
                            if ($row && $idt == $row['id']) {
                                $query = "UPDATE segnalazioni SET gravita = '$grav' WHERE id = ?";
                                $statement = $conn->prepare($query);
                                $statement->bind_param('i', $idt);
                                $result = $statement->execute();
                                if ($query) {
                                    echo("<br><b><br><p> <center> <font color=black font face='Courier'> Aggiornamento avvenuto correttamente. Ricarica la pagina per aggiornare la tabella.</b></center></p><br><br> ");
                                }
                            } else {
                                echo "<p> <center> <font color=black font face='Courier'> Inserisci ID esistente.</b></center></p>";
                            }
                        }
                    } else {
                        echo("<p> <center> <font color=black font face='Courier'> Compila tutti i campi.</b></center></p>");
                    }
                }

                DBconnection::CloseCon();
                ?>
                <br><br><br>

                <div class="card-header">
                    <i class="fas fa-table"></i>
                    Statistiche annuali per le segnalazioni delle aree verdi
                </div>
                <br><br>
                <!-- GRAFICO -->

                <script src="//www.amcharts.com/lib/3/amcharts.js"></script>
                <script src="//www.amcharts.com/lib/3/serial.js"></script>
                <script src="//www.amcharts.com/lib/3/themes/light.js"></script>

                <div id="chartdiv"></div>
                <script src='https://code.jquery.com/jquery-1.11.2.min.js'></script>

                <?php include("php/graficoverde.php"); ?>

                <!-- FINE GRAFICO -->

                <br><br>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
        

    <!-- Core plugin JavaScript-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js" integrity="sha512-0QbL0ph8Tc8g5bLhfVzSqxe9GERORsKhIn1IrpxDAgUsbBGz/V7iSav2zzW325XGd1OMLdL4UiqRJj702IeqnQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- Page level plugin JavaScript-->
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap4.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin.min.js"></script>

    <!-- Demo scripts for this page-->
    <script src="js/demo/datatables-demo.js"></script>

</body>

</html>
