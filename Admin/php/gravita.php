<?php

$conn = mysqli_connect("localhost", "root", "") or die ("Connessione non riuscita");

mysqli_select_db($conn, "civicsense") or die ("DataBase non trovato");


$id = (isset($_POST['id'])) ? $_POST['id'] : null;
$stato = (isset($_POST['stato'])) ? $_POST['stato'] : null;

if (isset($_POST['submit'])) {

    if ($id && $stato !== null) {

        $query = ("UPDATE segnalazioni SET stato = $stato WHERE id = $id");

        $result = mysqli_query($conn, $query);

        if ($result) {

            while ($row = mysqli_fetch_assoc($result)) {

                if ($id == $row['id']) {

                    echo("<br><b><br><p> <center> <font color=black font face='Courier'> Aggiornamento avvenuto correttamente. Ricarica la pagina per aggiornare la tabella.</b></center></p><br><br> ");
                } else {

                    echo("INSERISCI UN ID ESISTENTE");
                }

            }
        }
    } else {
        echo("inserisci tutti i campi");
    }
}

?>