<?php
include '../conexion/conexion.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $codigo = $con->real_escape_string(htmlentities($_POST['codigo']));
  $nombre = $con->real_escape_string(htmlentities($_POST['nombre']));
  $modelo = $con->real_escape_string(htmlentities($_POST['modelo']));
  $unidad_medida = $con->real_escape_string(htmlentities($_POST['unidad_medida']));
  $minimoStock = intval($_POST['minimoStock']);
  $ubicacion = $con->real_escape_string(htmlentities($_POST['ubicacion']));
  $cantidad_por_unidad = intval($_POST['cantidad_por_unidad']);
  $precio_compra = floatval($_POST['precio_compra']);
  $precio_venta = floatval($_POST['precio_venta']);
  
  // Insert the new product into the database
  $ins = $con->query("INSERT INTO productos (codigo, nombre, modelo, unidad_medida, minimoStock, cantidad_por_unidad, precio_compra, precio_venta,ubicacion)
                      VALUES ('$codigo', '$nombre', '$modelo', '$unidad_medida', $minimoStock, $cantidad_por_unidad, $precio_compra, $precio_venta , '$ubicacion')");

  if ($ins) {
    header('location: ../extend/alerta.php?msj=Se registró el producto&c=inv&p=inv&t=success');
  } else {
    header('location: ../extend/alerta.php?msj=No se pudo registrar el producto&c=inv&p=inv&t=error');
  }
} else {
  // Redirect if no POST request received
  header('location: ../extend/alerta.php?msj=Utiliza el formulario&c=inv&p=inv&t=error');
}
?>