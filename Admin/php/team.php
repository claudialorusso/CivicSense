<?php
require_once (dirname (__DIR__,2).'\db_connection.php');
$conn = DBconnection::OpenCon();

$sql = mysqli_query($conn, "SELECT * FROM team");

// output data of each row
while ($row = mysqli_fetch_assoc($sql)) {
    echo "
		<tr>
                <td>" . htmlspecialchars($row['codice']) . " </td>
                
                <td>" . htmlspecialchars($row['email_t']) . "</td> 
                
              <td>" . htmlspecialchars($row['nomi']) . "</td>
               
          </tr> ";
}
DBconnection::CloseCon();
?>