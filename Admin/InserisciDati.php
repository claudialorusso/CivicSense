<?php
	$conn = new MySQLi("localhost","root","","civicsense");

	$upload_path = 'jpeg/';
	
	if ($_SERVER['REQUEST_METHOD']=='POST') {
		$file_path = $upload_path . $_FILES['image']['name'];
		$img_name = $_FILES['image']['name'];
		$email = $_POST['email'];
		$tipo = $_POST['tipo'];
		if($tipo == "Segnalazione di area verde"){
			$tipo = 1;
		}else if($tipo == "Rifiuti e pulizia stradale"){
			$tipo = 2;
		}else if($tipo == "Strade e marciapiedi"){
			$tipo = 3;
		}else if($tipo == "Segnaletica e semafori"){
			$tipo = 4;
		}else if($tipo == "Illuminazione pubblica"){
			$tipo = 5;
		}
		$via = $_POST['via'];
		$descrizione = $_POST['descrizione'];
		$lat = $_POST['latitudine'];
		$lat = floatval($lat);
		$lng = $_POST['longitudine'];
		$lng = floatval($lng);

		try{
            $file_path = realpath($file_path);
            if(!$file_path) {
                $err_message = "Percorso file non corretto"; //@fixme CLAUDIA
            } else {
                # I list all of the jpg files contained in "jpeg/"
                $file_list = glob($upload_path . '*.jpg');
                #array_push(@$file_list, glob($upload_path . '*.png')); //@fixme CLAUDIA I don't know if it's needed
                #checks whether the image is real or not
                $real = false;
                foreach($file_list as $filename){
                    if(realpath($filename)==$file_path){
                        $real=true; #YAY! I founded the image! The path is valid!
                        break;
                    }
                }
                if($real){
                    $base_filename = basename($file_path);
                    move_uploaded_file($_FILES['image']['tmp_name'], "'$upload_path' . '$base_filename'"); //@TODO CLAUDIA Check
                    $sql = "INSERT INTO 'segnalazioni'('datainv', 'orainv', 'via', 'descrizione', 'foto', 'email','tipo','latitudine','longitudine') VALUES (CURRENT_DATE,CURRENT_TIME,'".$via."','".$descrizione."','{$img_name}','".$email."','".$tipo."',".$lat.",".$lng.")";
                    $result = mysqli_query($conn,$sql);
                    if($result){
                        echo "Inserimento dei dati completato";
                    }
                    else{
                        echo "Errore nell'inserimento dei dati";
                    }
                }

            }
		}catch(Exception $e){
            $e->getMessage(); // @TODO CLAUDIA error message needs to be managed
        }
        $conn->close();
	}
	
?>