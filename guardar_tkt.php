<?php
ob_start();

$host = "localhost";
	$dbuser = "root";
	$dbpass="";
	$dbname="atencion_alumnos";


date_default_timezone_set('America/Mexico_City');

	$conn = mysqli_connect($host, $dbuser, $dbpass, $dbname);
	if(!$conn){
		die("No hay conexion: ".mysqli_connect_error());
	}

	session_start();


//INFORMACION FORMULARIO

  $categoria=$_POST['categoria'];
  $pregunta=$_POST['pregunta'];
  $id_materia=$_POST['id_materia'];
  $cod_alumno="ZZ00-00";
    $fecha= date("d-m-Y H:i:s");
	$diaarchivos = date("j");
	$mesarchivos = date("F");
	$anioarchivos = date("Y");


	$directorio ="../uploads/".$anioarchivos."/".$mesarchivos."/".$diaarchivos."/";

	$archivo = $directorio . basename($_FILES["archivo"]["name"]);

	if (!file_exists($directorio)) {
			mkdir($directorio, 0777, true);
		}

if (move_uploaded_file($_FILES["archivo"]["tmp_name"], $archivo)) {
	$ruta_archivo = $archivo;
	$ru_arc = 'Ok';
}else {
	$ruta_archivo = "NA";
	$ru_arc='NA';
}



$guardar_ticket = "INSERT INTO tickets_registrados  VALUES ( '',  '2',  '$id_materia', '$categoria', '$fecha', '1','0',  '0',  '$ruta_archivo');";
			mysqli_query ($conn,$guardar_ticket);

            $sql="SELECT *  FROM tickets_registrados WHERE fecha_tkt='$fecha'";
            $result =  mysqli_query($conn,$sql);
                        while ($mostrar=mysqli_fetch_array($result)) {
                          $id_ticket = $mostrar['id_ticket'];
                          $f_ticket = $mostrar['fecha_tkt'];
                          $categoria = $mostrar['categoria'];
                          $guardar_msj_alumno = "INSERT INTO msj_alumno  VALUES ( '',  '$id_ticket',  '$pregunta', '$f_ticket');";
                          mysqli_query ($conn,$guardar_msj_alumno);
                        }


			$sql2="SELECT *  FROM tickets_registrados WHERE fecha_tkt='$fecha'";
			$result2 =  mysqli_query($conn,$sql2);
						$mostrar2=mysqli_fetch_array($result2);
							$id_ticket2 = $mostrar2['id_ticket'];
							$f_ticket2 = $mostrar2['fecha_tkt'];

			$sql3="SELECT *  FROM alumnos WHERE codigo='$cod_alumno'";
			$result3 =  mysqli_query($conn,$sql3);
						$mostrar3=mysqli_fetch_array($result3);
							$nombre = $mostrar3['nombre'];
							$direccion = $mostrar3['mail'];
						
/*
*/
					
					$email = explode("@",$direccion); 
					$bef_arroba=$email[0];
					$aft_arroba=$email[1];

					$resultado = substr($bef_arroba, 0, 3);
					$resultado2 = substr($bef_arroba, -3);

					$cadena_bfaf=$resultado2.$resultado;
					$longitud1 = strlen($cadena_bfaf);

					$longitud2 = strlen($bef_arroba);

					$res_long=$longitud2-$longitud1;
					$asteriscos = "*****";
/*
					for ($i=0;$i<$res_long;$i++){
						
						$asteriscos = $asteriscos."*";
					}
*/					
					$correo_asteriscos=$resultado.$asteriscos.$resultado2."@".$aft_arroba;
					



			echo'
			<!DOCTYPE html>
						
			<head>
			<meta charset="utf-8">
			<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
			<meta name="description" content="Start your development with a Dashboard for Bootstrap 4.">
			<meta name="author" content="Creative Tim">
			<title>Atención Alumnos</title>
			<!-- Favicon -->
			<link rel="icon" href="../assets/img/brand/favicon.png" type="image/png">
			<!-- Fonts -->
			<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
			<!-- Icons -->
			<link rel="stylesheet" href="../assets/vendor/nucleo/css/nucleo.css" type="text/css">
			<link rel="stylesheet" href="../assets/vendor/@fortawesome/fontawesome-free/css/all.min.css" type="text/css">
			<!-- Page plugins -->
			<link rel="stylesheet" href="../assets/vendor/animate.css/animate.min.css">
			<link rel="stylesheet" href="../assets/vendor/sweetalert2/dist/sweetalert2.min.css">
			<!-- Argon CSS -->
			<link rel="stylesheet" href="../assets/css/argon.css?v=1.1.0" type="text/css">
			</head>
					

			  <body>
			  <div class="alert alert-success alert-dismissible fade show" role="alert">
                <span class="alert-icon"><i class="fas fa-envelope-open-text"></i></span>
                <span class="alert-text"><strong>Estimado '.$nombre.' hemos registrado tu ticket!</strong> Hemos enviado un mensaje al siguiente correo: <strong>'.$correo_asteriscos.'</strong> para la activación del ticket número <strong>'.$id_ticket2.'</strong>!</span>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>

			 <button class="btn btn-success" data-toggle="sweet-alert" data-sweet-alert="success">'.$id_ticket2.'</button>
			 <button class="btn btn-info" data-toggle="sweet-alert" data-sweet-alert="info">'.$f_ticket2.'</button>
			  </body>
			</html>
'
	
?>
