<?php

require_once (dirname (__DIR__,2).'\db_connection.php');
$conn = DBconnection::OpenCon();
//session_start();

# this returns an error if a user clicks the login button without filling the required fields

//if (isset($_POST['submit'])) {
if (isset($_POST['email'], $_POST['password'])) {
    //checks whether the login credentials supplied by the user match those in our database.

    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $password = $_POST['password'];

    //Prepare SQL statement to prevent SQL Injection.

    $sql = "SELECT * FROM team WHERE email_t = :email";
    $query = $conn->prepare($sql);
    $query->bindParam("email", $email, PDO::PARAM_STR);
    $query->execute();

    $result = $query->fetch(PDO::FETCH_ASSOC);

    if (!$result) {
        echo 'Email e/o password non corrette!';
    } else {
        if ($password === $result['password']) { //password_verify(($password === $result['PASSWORD'])) TODO uses hash
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