<?php
$conexion = mysqli_connect("localhost", "root", "", "almacen");

// Verificar si la conexión fue exitosa
if (!$conexion) {
  die("Error al conectarse a la base de datos: " . mysqli_connect_error());
}

// Verificar si la solicitud es de tipo POST y el parámetro 'id' está presente
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
  $id = $_POST['id'];

  // Obtener los detalles de la venta
  $venta = mysqli_fetch_assoc(mysqli_query($conexion, "SELECT * FROM ventas WHERE id = $id"));

  // Verificar si se encontró la venta
  if ($venta) {
    $productoId = $venta['producto_id'];
    $cantidadDevuelta = $venta['cantidad_vendida'];

    // Obtener los detalles del producto
    $producto = mysqli_fetch_assoc(mysqli_query($conexion, "SELECT * FROM productos WHERE id = $productoId"));

    // Verificar si se encontró el producto
    if ($producto) {
      $cantidadActual = $producto['cantidad_por_unidad'];
      $cantidadActual += $cantidadDevuelta; // Añadir la cantidad devuelta a la cantidad actual

      // Actualizar la cantidad del producto en la base de datos
      mysqli_query($conexion, "UPDATE productos SET cantidad_por_unidad = $cantidadActual WHERE id = $productoId");

      // Eliminar la venta de la base de datos
      mysqli_query($conexion, "DELETE FROM ventas WHERE id = $id");

      // Mostrar un mensaje de éxito
      header('location:../extend/alerta.php?msj=Devolución realizada con éxito. Cantidad total devuelta: ' . $cantidadDevuelta . '&c=dev&p=dev&t=success');
      exit();
    } else {
      header('location:../extend/alerta.php?msj=No se encontró el producto asociado a la venta&c=dev&p=dev&t=error');
      exit();
    }
  } else {
    header('location:../extend/alerta.php?msj=No se encontró la venta&c=dev&p=dev&t=error');
    exit();
  }
}
?>
