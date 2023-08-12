<?php
$conexion = mysqli_connect("localhost", "root", "", "sistemans");

// Verificar si la conexión fue exitosa
if (!$conexion) {
  die("Error al conectarse a la base de datos: " . mysqli_connect_error());
}

if (isset($_GET['busqueda'])) {
  $busqueda = $_GET['busqueda'];
  $query = "SELECT * FROM clientes WHERE NumeroIdentificacion LIKE '%$busqueda%' OR Nombre LIKE '%$busqueda%'";
  $result = mysqli_query($conexion, $query);

  $resultados = array();

  if (mysqli_num_rows($result) > 0) {
    while ($cliente = mysqli_fetch_assoc($result)) {
      $resultados[] = $cliente;
    }
  }

  echo json_encode($resultados);
}
?>
