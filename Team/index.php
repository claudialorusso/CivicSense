<?php session_start() ?>
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
    <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin.css" rel="stylesheet">

    <!-- grafico -->
    <link rel="stylesheet" href="css/graficostyle.css">


</head>

<body id="page-top">

<nav class="navbar navbar-expand navbar-dark bg-dark static-top">

    <a class="navbar-brand mr-1" href=""> Area riservata</a>


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

    <div class="card mb-3">


        <!-- MAPPA -->

        <style>
            #map {
                height: 500px;
                width: 100%;
                margin-left: 0%;
            }

            * {
                margin: 0;
                padding: 0;
            }
        </style>


        <div id="map"></div>

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

                if (isset($_SESSION['idT'])) {
                    $sql = "SELECT * FROM segnalazioni WHERE team = " . $_SESSION['idT'];
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


        <script async defer
                src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB7GIu4drL85xcaTdq8hAtRzVWjbKxs3NQ&callback=initMap">
        </script>


        <!-- FINE MAPPA -->


        <br><br><br>

        <div class="card-header">
            <i class="fas fa-table"></i>
            Tabella Segnalazioni da risolvere
        </div>
        <br><br>
        <div class="card-body">
            <!-- Tabella -->
            <div class="table-responsive" style="overflow-x: scroll;">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>CODICE SEGNALAZIONE</th>
                        <th>DATA</th>
                        <th>ORA</th>
                        <th>VIA</th>
                        <th>DESCRIZIONE</th>
                        <th>FOTO</th>
                        <th>TIPO</th>
                        <th>STATO</th>
                        <th>GRAVITA'</th>
                    </tr>
                    </thead>

                    <?php include("php/segnalazione.php"); ?>


                </table>


                <!-- MODIFICA STATO SEGNALAZIONE -->

                <!-- inserimento da form del codice della segnalazione da modificare -->
                <br><br><br>

                <div class="card-header">
                    <i class="fas fa-table"></i>
                    Modifica stato di una segnalazione
                </div>

                <form method="post" action="modifiche.php" style=" margin-top:5%; margin-left:5%">
                    <b>CODICE SEGNALAZIONE DA MODIFICARE: <input type="text" name="id"><br><br></b>
                    <b> INSERISCI LO STATO MODIFICATO: </b> <select class="text" name="stato">

                        <option value="Risolto">Risolto</option>
                        <option value="In risoluzione">In risoluzione</option>

                        <input type="submit" class="btn btn-primary btn-block" style="width:15%; margin-top:5%;">

                </form>

                <br><br><br>


                <br><br>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
        

    <!-- Core plugin JavaScript-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js" integrity="sha512-0QbL0ph8Tc8g5bLhfVzSqxe9GERORsKhIn1IrpxDAgUsbBGz/V7iSav2zzW325XGd1OMLdL4UiqRJj702IeqnQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- Page level plugin JavaScript-->
    <script src="vendor/datatables/jquery.dataTables.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin.min.js"></script>

    <!-- Demo scripts for this page-->
    <script src="js/demo/datatables-demo.js"></script>


</body>

</html>
