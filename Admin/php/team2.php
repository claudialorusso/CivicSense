<?php
require_once (dirname (__DIR__,2).'\db_connection.php');
$conn = DBconnection::OpenCon();

$quer = mysqli_query($conn, "SELECT * FROM segnalazioni WHERE gravita IS NOT NULL AND team IS NULL");


if (mysqli_num_rows($quer) > 0) {
    // output data of each row
    while ($row = mysqli_fetch_assoc($quer)) {
        echo "
    <tr>
     
                <td>" . htmlspecialchars($row['id']) . " <br></td>
                
                <td>" . htmlspecialchars($row['via']) . " <br></td> 
                
              <td>" . htmlspecialchars($row['gravita']) . "<br></td>
			  
			    <td>" . htmlspecialchars($row['tipo']) . "<br></td>
               
          </tr> ";
    }
}
DBconnection::CloseCon();
?>