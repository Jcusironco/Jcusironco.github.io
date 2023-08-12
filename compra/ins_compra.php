<?php
include '../conexion/conexion.php';
include '../extend/permiso.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $fechaHora = $_POST['fechaHora'];
  $filasTablaJSON = $_POST['filasTabla'];
  $filasTabla = json_decode(stripslashes($filasTablaJSON), true);

  foreach ($filasTabla as $fila) {
    $productoId = $fila['id'];
    $cantidadComprada = $fila['cantidad'];
    $unidadMedidaComprada = isset($fila['unidadMedida']) ? $fila['unidadMedida'] : 'UNIDAD';
    $precioCompra = $fila['precioCompra'];
    $precioVenta = $fila['precioVenta'];

    // Insertar la compra en la tabla 'compras'
    $ins = $con->query("INSERT INTO compras (fechahora, producto_id, cantidad_comprada, unidad_medida_comprada, precio_compra, precio_venta) 
        VALUES ('$fechaHora', '$productoId', '$cantidadComprada', '$unidadMedidaComprada', '$precioCompra', '$precioVenta')");

    // Actualizar la cantidad de productos en la tabla 'productos'
    $update = $con->query("UPDATE productos SET cantidad_por_unidad = cantidad_por_unidad + $cantidadComprada WHERE id = $productoId");

    // Actualizar los precios en la tabla 'productos'
    $updatePrecios = $con->query("UPDATE productos SET precio_compra = '$precioCompra', precio_venta = '$precioVenta' WHERE id = $productoId");

    if (!($ins && $update && $updatePrecios)) {
      header('location: ../extend/alerta.php?msj=No se pudo registrar la compra o actualizar los precios&c=comp&p=comp&t=error');
      exit(); // Agregado para evitar que se ejecute el código restante
    }
  }

  // Si se completó el bucle sin problemas, significa que todas las filas se insertaron correctamente
  header('location: ../extend/alerta.php?msj=Se registró la compra y se actualizaron los precios&c=comp&p=comp&t=success');
  exit();
} else {
  // Redirigir en caso de no recibir una solicitud POST
  header('location: ../extend/alerta.php?msj=Utiliza el formulario&c=comp&p=comp&t=error');
  exit();
}
?>