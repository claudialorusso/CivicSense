<?php
require_once (dirname (__DIR__,2).'\db_connection.php');
$conn = DBconnection::OpenCon();
if (isset($_SESSION['idT'])) {
    $upload_path = '../Admin/img/';


    $team = (isset($_POST['team'])) ? $_POST['team'] : null;


    $quer = mysqli_query($conn, "SELECT * FROM segnalazioni WHERE stato  <> 'Risolto' AND team = " . $_SESSION['idT']);

    while ($row = mysqli_fetch_assoc($quer)) {
        echo "
            <tr>
                        <td>" . htmlspecialchars($row['id']) . " <br></td>
                        <td>" . htmlspecialchars($row['datainv']) . " <br></td> 
                        <td>" . htmlspecialchars($row['orainv']) . "<br></td>
                        <td>" . htmlspecialchars($row['via']) . "<br></td>
                        <td>" . htmlspecialchars($row['descrizione']) . "<br></td>
                        <td><img width='200px' height='200px' src=" . $upload_path . htmlspecialchars($row['foto']) . "><br></td> 
                        <td>" . htmlspecialchars($row['tipo']) . "<br></td>
                        <td>" . htmlspecialchars($row['stato']) . "<br></td>
                        <td>" . htmlspecialchars($row['gravita']) . "<br></td>
                       
            </tr> ";
    }


}

DBconnection::CloseCon();

?>