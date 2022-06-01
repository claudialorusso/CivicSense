<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin - Register</title>

    <!-- Bootstrap core CSS-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>
    <!-- Custom fonts for this template-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Custom styles for this template-->
    <link href="css/sb-admin.css" rel="stylesheet">

</head>

<body class="bg-dark">

<div class="container">
    <div class="card card-register mx-auto mt-5">
        <div class="card-header">Registra la password del team</div>
        <div class="card-body">
            <form action="registrateam.php" method="POST" autocomplete="off">

                <div class="form-group">
                    <div class="form-label-group">
                        <input type="email" name="email" id="inputEmail" class="form-control" placeholder="Email "
                               required="required">
                        <label for="inputEmail">Email </label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-row">
                        <div class="col-md-6">
                            <div class="form-label-group">
                                <input type="password" name="password" id="inputPassword" class="form-control"
                                       placeholder="Password" required="required">
                                <label for="inputPassword">Password</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-label-group">
                                <input type="password" id="confirmPassword" class="form-control"
                                       placeholder="Confirm password" required="required">
                                <label for="confirmPassword">Conferma la password</label>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btn-block"> Registrati</button>
            </form>
        </div>
    </div>
</div>

<?php
require_once (dirname (__DIR__,1).'\db_connection.php');
$conn = DBconnection::OpenCon();

$email = (isset($_POST['email'])) ? $_POST['email'] : null;
$pass = (isset($_POST['password'])) ? $_POST['password'] : null;


if ($email && $pass !== null) {


    $query = ("UPDATE team SET password = '$pass' WHERE email_t = ?");

    $statement = $conn->prepare($query);
    $statement->bind_param('s', $email);
    $result = $statement->execute();


    if ($query) {
        echo("<br><b><br><p> <center> <font color=white font face='Courier'> Password registrata! Clicca su <a href='login.php'> Login </a> per accedere. </b></center></p><br><br> ");
    }
}

DBconnection::CloseCon();
?>


<!-- Core plugin JavaScript-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js" integrity="sha512-0QbL0ph8Tc8g5bLhfVzSqxe9GERORsKhIn1IrpxDAgUsbBGz/V7iSav2zzW325XGd1OMLdL4UiqRJj702IeqnQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

</body>

</html>
