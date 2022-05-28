<?php
$conn = mysqli_connect("localhost", "root", "") or die ("Connessione non riuscita");

mysqli_select_db($conn, "civicsense") or die ("DataBase non trovato"); #connessione al db


$upload_path = 'img/';
$quer = mysqli_query($conn, "SELECT * FROM segnalazioni WHERE tipo = '5' ");


while ($row = mysqli_fetch_assoc($quer)) {
    echo "
    <tr>
     
                <td>" . htmlspecialchars($row['id']) . " <br></td>
                
                <td>" . htmlspecialchars($row['datainv']) . " <br></td> 
                
              <td>" . htmlspecialchars($row['orainv']) . "<br></td>

               <td>" . htmlspecialchars($row['via']) . "<br></td>

                <td >" . htmlspecialchars($row['descrizione']) . "<br></td>

                 <td><img width='200px' height='200px' src=" . $upload_path . htmlspecialchars($row['foto']) . "><br></td>

                  <td>" . htmlspecialchars($row['email']) . "<br></td>

                   <td>" . htmlspecialchars($row['stato']) . "<br></td>

                    <td>" . htmlspecialchars($row['team']) . "<br></td>

                   <td>" . htmlspecialchars($row['gravita']) . "<br></td>
               
          </tr> ";
}
?>