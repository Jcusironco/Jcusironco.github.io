<?php
include '../conexion/conexion.php';

// Verificar si se recibió el ID del producto a eliminar
if (isset($_GET['id'])) {
  $producto_id = $_GET['id'];
  $id = $con->real_escape_string(htmlentities($_GET['id']));

  $del = $con->query("DELETE FROM productos WHERE id='$id'");

  if ($del) {
    header('location: ../extend/alerta.php?msj=Se eliminó el producto&c=inv&p=inv&t=success');
  } else {
    header('location: ../extend/alerta.php?msj=No se pudo eliminar el producto&c=inv&p=inv&t=error');
  }
} else {
  // Redirigir en caso de no recibir una solicitud POST
  header('location: ../extend/alerta.php?msj=Utiliza el formulario&c=inv&p=inv&t=error');
}
?>
