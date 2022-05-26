<?php session_start() ?>

<!DOCTYPE html>

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin - Login</title>

    <!-- Bootstrap core CSS-->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin.css" rel="stylesheet">

</head>

<body class="bg-dark">

<div class="container">
    <div class="card card-login mx-auto mt-5">
        <div class="card-header">Login</div>
        <div class="card-body">
            <form action="#" method="POST">
                <div class="form-group">
                    <div class="form-label-group">
                        <input type="email" name="email" id="inputEmail" class="form-control" placeholder="Email"
                               required="required" autofocus="autofocus">
                        <label for="inputEmail"> Email </label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-label-group">
                        <input type="password" id="inputPassword" name="password" class="form-control"
                               placeholder="Password" required="required">
                        <label for="inputPassword"> Password </label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" value="remember-me">
                            Ricordami
                        </label>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary btn-block"> Login</button>
                <br>
                <center><a class="d-block small mt-3" href="registrateam.php">Sei un nuovo team? Registra la tua
                        password!</a></center>
            </form>

        </div>
    </div>
</div>

<!-- Bootstrap core JavaScript-->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="vendor/jquery-easing/jquery.easing.min.js"></script>

<?php
#FIXME CLAUDIA

include 'config.php';
$connection = include 'config.php';
//session_start();

# this returns an error if a user clicks the login button without filling the required fields

//if (isset($_POST['submit'])) {
if (isset($_POST['email'], $_POST['password'])) {
       //checks whether the login credentials supplied by the user match those in our database.

        $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
        $password = $_POST['password'];

        //Prepare SQL statement to prevent SQL Injection.

        $sql = "SELECT * FROM team WHERE email_t = :email";
        $query = $connection->prepare($sql);
        $query->bindParam("email", $email, PDO::PARAM_STR);
        $query->execute();

        $result = $query->fetch(PDO::FETCH_ASSOC);

        if (!$result) {
            echo 'Email e/o password non corrette!';
        } else {
            if ($password === $result['password']){ //password_verify(($password === $result['PASSWORD'])) TODO uses hash
                if ($email === "civicsense2019@gmail.com") { //FIXME Claudia
                    echo 'Accesso consentito alla sezione riservata';
                    echo '<script>window.location.href = "index.php";</script>';
                } else {
                    // create sessions to know the user is logged in

                    $_SESSION['user_id'] = $result['ID'];
                    echo 'Accesso consentito alla area riservata (TEAM)';
                    header("location: http://localhost//CivicSense/Team/index.php");
                }
            } else echo 'Email e/o password non corrette!';
        }
}
//}

/*

//use me filter_var($email, FILTER_VALIDATE_EMAIL);




$hasher = new PasswordHash($hash_cost_log2, $hash_portable);
$hash = $hasher->HashPassword($password);
if (strlen($hash) < 20)
    fail('Failed to hash new password');
unset($hasher);

//Recupero dati
if (isset($email) && isset($password)) {

    #TODO
    if ($email == "civicsense2019@gmail.com") {
        if ($password == "admin") {
            echo 'Accesso consentito alla sezione riservata';
            echo '<script>window.location.href = "index.php";</script>';

        } else {
            echo 'Accesso negato alla sezione riservata.La password è errata!';
        }
    } else {
        //Connessione Database
        # FIXME CLAUDIA
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){ //I check if the email is in a valid format
            $hash = "*"; // In case the user is not found

            $conn = mysqli_connect("localhost", "root", "") or die ("Connessione non riuscita"); #connessione a mysql, la pass non la ho xk è scaricato automaticamente

            mysqli_select_db($conn, "civicsense") or die ("DataBase non trovato"); #connessione al db

            $sql = "SELECT * FROM team WHERE email_t = ?";
            ($stmt = $conn->prepare($sql)) || echo('ATTENZIONE: Errore di connessione al DB');
            $stmt->bind_param('s', $email) || echo('ATTENZIONE: DB Error');
            $stmt->execute() || fail('ATTENZIONE:','DB execution error');
            $stmt->bind_result($hash) || echo('MySQL bind_result' . $conn->error);

            if ($hasher->CheckPassword($password, $hash)) {
                $what = 'Authentication succeeded';
            } else {
                $what = 'Authentication failed';
            }
            unset($hasher);

            /*
                        $query1 = ("SELECT * FROM team WHERE codice = ?");
                        $statement = $conn->prepare($query1);
                        $statement->bind_param('i', $team);
/


        $sql = "SELECT * FROM team ";
        $result = mysqli_query($sql);
        }






        if (mysqli_num_rows($result) > 0) {

            while ($row = mysqli_fetch_assoc($result)) {
                if ($password != $row["password"] || $email != $row["email_t"]) {
                    //CODICE JAVASCRIPT
                    echo 'ATTENZIONE: La password o la email inserita non è corretta!';
                } else if ($password == $row["password"] || $email == $row["email_t"]) {
                    $_SESSION['email'] = $email;
                    $_SESSION['pass'] = $password;
                    $_SESSION['idT'] = $row['codice'];
                    echo 'Accesso consentito area riservata (TEAM)';
                    header("location: http://localhost//CivicSense/Team/index.php");
                }

            }
        }


    }


}
*/
?>
