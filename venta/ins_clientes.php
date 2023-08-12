<?php
$conexion = mysqli_connect("localhost", "root", "", "sistemans");
if (!$conexion) {
  die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $numeroIdentificacion = $conexion->real_escape_string(htmlentities($_POST['numeroResultado']));
  $nombre = $conexion->real_escape_string(htmlentities($_POST['nombres']));
  $telefono  = $conexion->real_escape_string(htmlentities($_POST['telefono']));
  $direccion = $conexion->real_escape_string(htmlentities($_POST['direccion']));
  $correo = $conexion->real_escape_string(htmlentities($_POST['correo']));
  $ins = $conexion->query("INSERT INTO clientes VALUES ('','$numeroIdentificacion','$nombre','$telefono','$direccion','$correo')");

  if ($ins) {
    header('location:../extend/alerta.php?msj=Se registró al cliente&c=cli&p=cli&t=success');
  } else {
    header('location:../extend/alerta.php?msj=No se pudo registrar al cliente&c=cli&p=cli&t=error');
  }
  $conexion->close();
} else {
  //formulario
  header('location:../extend/alerta.php?msj=Utiliza el formulario&c=cli&p=cli&t=error');
}
?>
