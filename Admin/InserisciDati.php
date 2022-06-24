<?php
$conn = new MySQLi("localhost", "root", "", "civicsense");

$upload_path = 'jpeg/';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $img_name = $_FILES['image']['name']; //Ex. immagine.jpg

    $img_extension = substr($img_name, -4);
    if ( $img_extension === '.jpg' || $img_extension === 'jpeg') {
        $file_path = $upload_path . basename($img_name); //Ex. jpeg/immagine.jpg
        $email = $_POST['email'];
        $tipo = $_POST['tipo'];
        if ($tipo == "Segnalazione di area verde") {
            $tipo = 1;
        } else if ($tipo == "Rifiuti e pulizia stradale") {
            $tipo = 2;
        } else if ($tipo == "Strade e marciapiedi") {
            $tipo = 3;
        } else if ($tipo == "Segnaletica e semafori") {
            $tipo = 4;
        } else if ($tipo == "Illuminazione pubblica") {
            $tipo = 5;
        }
        $via = $_POST['via'];
        $descrizione = $_POST['descrizione'];
        $lat = $_POST['latitudine'];
        $lat = floatval($lat);
        $lng = $_POST['longitudine'];
        $lng = floatval($lng);

        try {
            $file_path = realpath($file_path);
            if (!$file_path) {
                $err_message = "Percorso file non corretto";
            } else {
                $base_filename = basename($file_path);
                move_uploaded_file($_FILES['image']['tmp_name'], "'$upload_path' . '$base_filename'");

                $sql = "INSERT INTO segnalazioni (datainv, orainv, via, descrizione, foto, email, tipo, latitudine, longitudine) VALUES (CURRENT_DATE,CURRENT_TIME, ?, ?, ?, ?, ?, ?, ?) ";

                $statement = $conn->prepare($sql);
                $statement->bind_param('ssssiss',  $via, $descr, $foto, $email, $tipo, $lat, $long);
                $result = $statement->execute();

                if ($result) {
                    echo "Inserimento dei dati completato";
                } else {
                    echo "Errore nell'inserimento dei dati";
                }
            }
        } catch (Exception $e) {
            $e->getMessage(); // @TODO CLAUDIA error message needs to be managed
        }
        $conn->close();
    }

}

?>