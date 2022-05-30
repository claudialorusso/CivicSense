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
<link href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin.css" rel="stylesheet">

    <!-- Grafico -->
    <link rel="stylesheet" href="css/graficostyle.css">

</head>

<body id="page-top">


<div class="card-header">
    <i class="fas fa-table"></i>
    inserisci segnalazione

</div>

<form method="post" action="inserisci.php" style=" margin-top:5%; margin-left:5%;">
    <b>DATA INVIO: <input type="date" name="data"><br><br></b>
    <b> ORA INVIO: </b> <input type="time" name="ora"><br><br></b>
    <b> VIA (VIA NOMEVIA, N CIVICO, CAP, PROVINCIA (ES: PULSANO O TARANTO), TA, ITALIA: <input type="text"
                                                                                               name="via"><br><br></b>
    <b> DESCRIZIONE: <input type="text" name="descr"><br><br></b>
    <b> FOTO: <input type="file" name="foto"><br><br></b>
    <b> EMAIL (LA VOSTRA): <input type="email" name="email"><br><br></b>
    <b> LATITUDINE: <input type="text" name="lat"><br><br></b>
    <b> LONGITUDINE: <input type="text" name="long"><br><br></b>
    <b> TIPOLOGIA: </b> <select class="text" name="tipo">

        <option value="1">SEGNALAZIONI AREE VERDI</option>
        <option value="2">RIFIUTI E PULIZIA STRADALE</option>
        <option value="3">STRADE E MARCIAPIEDI</option>
        <option value="4">SEGNALETICA E SEMAFORI</option>
        <option value="4">ILLUMINAZIONE PUBBLICA</option>
    </select>

    <input type="submit" name="submit" class="btn btn-primary btn-block" style="width:15%; margin-top:5%;">

</form>

<?php
require_once (dirname (__DIR__,1).'\db_connection.php');
$conn = DBconnection::OpenCon();

$data = (isset($_POST['data'])) ? $_POST['data'] : null;
$ora = (isset($_POST['ora'])) ? $_POST['ora'] : null;
$via = (isset($_POST['via'])) ? $_POST['via'] : null;
$descr = (isset($_POST['descr'])) ? $_POST['descr'] : null;
$foto = (isset($_POST['foto'])) ? $_POST['foto'] : null;
$email = (isset($_POST['email'])) ? $_POST['email'] : null;
$lat = (isset($_POST['lat'])) ? $_POST['lat'] : null;
$long = (isset($_POST['long'])) ? $_POST['long'] : null;
$tipo = (isset($_POST['tipo'])) ? $_POST['tipo'] : null;

$sql = "INSERT INTO segnalazioni (datainv, orainv, via, descrizione, foto, email, tipo, latitudine, longitudine) VALUES (?,?, ?, ?, ?, ?, ?, ?, ?) ";

$statement = $conn->prepare($sql);
$statement->bind_param('ssssssiss', $data, $ora, $via, $descr, $foto, $email, $tipo, $lat, $long);
$result = $statement->execute();

if ($result) {
    echo "<center> inserimento avvenuto. </center>";

}

DBconnection::CloseCon();


?>


</body>