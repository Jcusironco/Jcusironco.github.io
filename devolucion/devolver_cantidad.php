<?php
$conexion = mysqli_connect("localhost", "root", "", "almacen");

// Verificar si la conexión fue exitosa
if (!$conexion) {
  die("Error al conectarse a la base de datos: " . mysqli_connect_error());
}

// Obtener el ID de la venta y la cantidad a devolver
if (isset($_POST['id']) && isset($_POST['cantidad'])) {
  $venta_id = $_POST['id'];
  $cantidad_devuelta = $_POST['cantidad'];

  // Obtener la información de la venta
  $venta_sel = $conexion->query("SELECT * FROM ventas WHERE id = $venta_id");
  $venta = $venta_sel->fetch_assoc();

  // Verificar si se encontró la venta
  if ($venta) {
    $producto_id = $venta['producto_id'];

    // Obtener los detalles del producto
    $producto_sel = $conexion->query("SELECT * FROM productos WHERE id = $producto_id");
    $producto = $producto_sel->fetch_assoc();

    // Verificar si se encontró el producto
    if ($producto) {
      // Calcular el precio por unidad
      $precio_unidad = $venta['total'] / $venta['cantidad_vendida'];

      // Verificar si la cantidad devuelta es válida
      if ($cantidad_devuelta <= $venta['cantidad_vendida']) {
        // Calcular la nueva cantidad de producto
        $cantidad_actual = $producto['cantidad_por_unidad'] + $cantidad_devuelta;

        // Actualizar la cantidad del producto en la tabla productos
        $conexion->query("UPDATE productos SET cantidad_por_unidad = $cantidad_actual WHERE id = $producto_id");

        // Calcular el nuevo total y la nueva cantidad vendida
        $nuevo_total = $venta['total'] - ($precio_unidad * $cantidad_devuelta);
        $nueva_cantidad_vendida = $venta['cantidad_vendida'] - $cantidad_devuelta;

        // Actualizar la tabla de ventas con la cantidad restante y el nuevo total
        $conexion->query("UPDATE ventas SET cantidad_vendida = $nueva_cantidad_vendida, total = $nuevo_total WHERE id = $venta_id");

        // Verificar si se devolvieron todos los productos
        if ($nueva_cantidad_vendida == 0) {
          // Eliminar la venta si se devolvieron todos los productos
          $conexion->query("DELETE FROM ventas WHERE id = $venta_id");
        }

        // Enviar una respuesta de éxito al cliente
        header('location:../extend/alerta.php?msj=Devolución realizada con éxito. Cantidad total devuelta: ' . $cantidad_devuelta . '&c=dev&p=dev&t=success');
      } else {
        // Enviar una respuesta de error si la cantidad devuelta es mayor que la cantidad vendida
        header('location:../extend/alerta.php?msj=La cantidad devuelta no puede ser mayor que la cantidad vendida&c=dev&p=dev&t=error');
      }
    } else {
      // Enviar una respuesta de error si no se encontró el producto
      header('location:../extend/alerta.php?msj=No se encontró el producto&c=dev&p=dev&t=error');
    }
  } else {
    // Enviar una respuesta de error si no se encontró la venta
    header('location:../extend/alerta.php?msj=No se encontró la venta&c=dev&p=dev&t=error');
  }
} else {
  // Si no se proporciona un ID de venta o una cantidad, enviar una respuesta de error al cliente
  header('location:../extend/alerta.php?msj=ID de venta o cantidad no proporcionados&c=dev&p=dev&t=error');
}
?>
