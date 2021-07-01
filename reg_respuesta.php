
 <?php
$cod_alumno="ZZ00-00";



$host = "localhost";
$dbuser = "root";
$dbpass="";
$dbname="atencion_alumnos";


date_default_timezone_set('America/Mexico_City');

$conn = mysqli_connect($host, $dbuser, $dbpass, $dbname);
if(!$conn){
  die("No hay conexion: ".mysqli_connect_error());
}

//INFORMACION FORMULARIO

$respuesta=$_POST['respuesta'];
$fecha=date("d-m-Y H:i:s");
$id_ticket=$_POST['id_ticket'];

$responder = "INSERT INTO msj_alumno  VALUES ( '',  '$id_ticket',  '$respuesta', '1', '$fecha');";
    mysqli_query ($conn,$responder);

    header("refresh:1;url=../tabla_tickets.php");
?>