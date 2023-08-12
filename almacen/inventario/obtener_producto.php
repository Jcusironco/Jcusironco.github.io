<?php
$conexion = mysqli_connect("localhost", "root", "", "almacen");

if (!$conexion) {
  die("Error al conectarse a la base de datos: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
  $idProducto = $_GET["id"];

  $sql = "SELECT * FROM productos WHERE id=$idProducto";
  $resultado = mysqli_query($conexion, $sql);

  if (mysqli_num_rows($resultado) > 0) {
    $producto = mysqli_fetch_assoc($resultado);
    echo json_encode($producto);
  } else {
    header('HTTP/1.1 404 Not Found');
    exit();
  }
}
?>
