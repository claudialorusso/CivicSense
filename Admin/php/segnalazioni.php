<?php
require_once (dirname (__DIR__,2).'\db_connection.php');
$conn = DBconnection::OpenCon();

$quer = mysqli_query($conn, "SELECT * FROM segnalazioni ");


while ($row = mysqli_fetch_assoc($quer)) {
    echo "
    <tr>
     
                <td>" . htmlspecialchars($row['id']) . " <br></td>
                
                <td>" . htmlspecialchars($row['datainv']) . " <br></td> 
                
              <td>" . htmlspecialchars($row['orainv']) . "<br></td>

               <td>" . htmlspecialchars($row['via']) . "<br></td>

                <td>" . htmlspecialchars($row['descrizione']) . "<br></td>

                 <td>" . htmlspecialchars($row['foto']) . "<br></td>

                  <td>" . htmlspecialchars($row['email']) . "<br></td>

                   <td>" . htmlspecialchars($row['stato']) . "<br></td>

                    <td>" . htmlspecialchars($row['team']) . "<br></td>

                   <td>" . htmlspecialchars($row['gravit�']) . "<br></td>
               
          </tr> ";
}

DBconnection::CloseCon();
?>