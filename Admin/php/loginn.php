<?php
#FIXME CLAUDIA
require_once(dirname(__DIR__, 1) . '\db_connection.php');
$conn = DBconnection::OpenCon();

//session_start();

# this returns an error if a user clicks the login button without filling the required fields

//if (isset($_POST['submit'])) {
if (isset($_POST['email'], $_POST['password'])) {
    //checks whether the login credentials supplied by the user match those in our database.

    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $password = $_POST['password'];

    //Prepare SQL statement to prevent SQL Injection.
    try {
        $sql = "SELECT * FROM team WHERE email_t = ?";


        $statement = $conn->prepare($sql);
        $statement->bind_param('s', $email);
        $res_ex = $statement->execute();

        $result = $statement->get_result();
        if ($result->num_rows === 0) exit ('Email e/o password non corrette!');
        while ($row = $result->fetch_assoc()) {
            if (!$res_ex) {
                echo 'Email e/o password non corrette!';
            } else {
                if ($password === $row['password']) { //password_verify(($password === $result['PASSWORD'])) TODO use hash
                    //Utente autenticato
                    if ($row["admin"]) {
                        echo 'Accesso consentito alla sezione riservata';

                        echo '<script>window.location.href = "index.php";</script>';
                    } else {
                        // create sessions to know the user is logged in

                        require_once(dirname(__DIR__, 1) . '\session.php');
                        $session = new session();
                        // Set to true if using https
                        $session->start_session('_s', false);

                        #$_SESSION['something'] = 'A value.';
                        #echo $_SESSION['something'];
                        $_SESSION['user_id'] = $row['ID'];
                        $_SESSION['email'] = $email;
                        $_SESSION['pass'] = $password;
                        $_SESSION['idT'] = $row['codice'];
                        echo 'Accesso consentito alla area riservata (TEAM)';
                        header("location: http://localhost//CivicSense/Team/index.php");
                    }
                } else echo 'Email e/o password non corrette!';
            }
        }

    } catch (mysqli_sql_exception $e) {
        echo("Error: " . $e);
        exit;
    }

}

/*

	//Recupero dati
	if(isset($_POST['email']) && isset($_POST['password'])){
		$email = $_POST['email'];
		$password = $_POST['password'];
		if($email == "civicsense18@gmail.com")
		{
			if($password == "admin")
			{
				echo 'Accesso consentito alla sezione riservata';
			}
			else
			{
				echo 'Accesso negato alla sezione riservata.La password � errata!';
			}
		}
		else
		{
			$sql = 'SELECT * FROM team WHERE email_t = ' .$email. ';';
			$result = mysqli_query($conn, $sql);

			if (mysqli_num_rows($result) > 0) {
	   
	    		while($row = mysqli_fetch_assoc($result)) 
				{
					if($password != $row["password"] || $email != $row["email_t"])
					{
						//CODICE JAVASCRIPT
						echo 'ATTENZIONE: La password o la email inserita non è corretta!';
					}
					else if ($password == $row["password"] || $email == $row["email_t"]){
						echo 'Accesso consentito area riservata (TEAM)';
					}
			
				}
			}
		}
	}
	else{
		echo 'Non esistono;';
	}
	
*/


DBconnection::CloseCon();
?>