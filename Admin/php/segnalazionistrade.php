<?php
require_once (dirname (__DIR__,2).'\db_connection.php');
$conn = DBconnection::OpenCon();

$upload_path = 'img/';
$quer = mysqli_query($conn, "SELECT * FROM segnalazioni WHERE tipo = '3' ");


while ($row = mysqli_fetch_assoc($quer)) {
    echo "
            <tr>
                <td>" . htmlspecialchars($row['id']) . " <br></td>
                
                <td>" . htmlspecialchars($row['datainv']) . " <br></td> 
                
              <td>" . htmlspecialchars($row['orainv']) . "<br></td>

               <td>" . htmlspecialchars($row['via']) . "<br></td>

                <td>" . htmlspecialchars($row['descrizione']) . "<br></td>

                 <td><img width='200px' height='200px' src=" . $upload_path . htmlspecialchars($row['foto']) . "><br></td>

                  <td>" . htmlspecialchars($row['email']) . "<br></td>

                   <td>" . htmlspecialchars($row['stato']) . "<br></td>

                    <td>" . htmlspecialchars($row['team']) . "<br></td>

                   <td>" . htmlspecialchars($row['gravita']) . "<br></td>
               
          </tr> ";
}
DBconnection::CloseCon();
?>