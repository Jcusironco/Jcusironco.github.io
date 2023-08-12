<?php
include '../conexion/conexion.php';
include '../extend/permiso.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Obtener el valor seleccionado del campo de entrada
  $producto_seleccionado = $_POST['producto'];

  // Obtener el ID y el nombre del producto seleccionado
  $producto_parts = explode(' - ', $producto_seleccionado);
  $id_producto = $producto_parts[0];
  $nombre_producto = $producto_parts[1];

  $cantidad_comprada = $con->real_escape_string(htmlentities($_POST['cantidad_comprada']));
  $unidad_medida_comprada = $con->real_escape_string(htmlentities($_POST['unidad_medida_comprada']));
  $precio_compra = $con->real_escape_string(htmlentities($_POST['precio_compra']));
  $precio_venta = $con->real_escape_string(htmlentities($_POST['precio_venta']));

  // Obtener la fecha y hora actual
  date_default_timezone_set('America/Lima');
  $fechahora = date('Y-m-d H:i:s');

  // Insertar la compra en la tabla 'compras'
  $ins = $con->query("INSERT INTO compras (fechahora, producto_id, cantidad_comprada, unidad_medida_comprada, precio_compra, precio_venta) 
        VALUES ('$fechahora', '$id_producto', '$cantidad_comprada', '$unidad_medida_comprada', '$precio_compra', '$precio_venta')");

  // Actualizar la cantidad de productos en la tabla 'productos'
  $update = $con->query("UPDATE productos SET cantidad_por_unidad = cantidad_por_unidad + $cantidad_comprada WHERE id = $id_producto");

  if ($ins && $update) {
    // Obtener el ID de la compra recién insertada
    $id_compra = $con->insert_id;

    // Restar la cantidad comprada del producto en la tabla 'productos'
    $consultaCompra = $con->query("SELECT cantidad_comprada, producto_id FROM compras WHERE id = $id_compra");
    $compra = $consultaCompra->fetch_assoc();
    $cantidad_comprada = $compra['cantidad_comprada'];
    $id_producto = $compra['producto_id'];
    $restarCantidad = $con->query("UPDATE productos SET cantidad_por_unidad = cantidad_por_unidad - $cantidad_comprada WHERE id = $id_producto");

    if ($restarCantidad) {
      header('location: ../extend/alerta.php?msj=Se registró la compra&c=comp&p=comp&t=success');
      exit();
    } else {
      header('location: ../extend/alerta.php?msj=No se pudo restar la cantidad comprada del producto&c=comp&p=comp&t=error');
      exit();
    }
  } else {
    header('location: ../extend/alerta.php?msj=No se pudo registrar la compra&c=comp&p=comp&t=error');
    exit();
  }
} elseif ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['eliminar'])) {
  // Obtener el ID de la compra a eliminar
  $id_compra = $_GET['eliminar'];

  // Obtener la cantidad comprada y el ID del producto asociado a la compra
  $consultaCompra = $con->query("SELECT cantidad_comprada, producto_id FROM compras WHERE id = $id_compra");
  $compra = $consultaCompra->fetch_assoc();
  $cantidad_comprada = $compra['cantidad_comprada'];
  $id_producto = $compra['producto_id'];

  // Restar la cantidad comprada del producto en la tabla 'productos'
  $restarCantidad = $con->query("UPDATE productos SET cantidad_por_unidad = cantidad_por_unidad - $cantidad_comprada WHERE id = $id_producto");

  if ($restarCantidad) {
    // Eliminar la compra de la tabla 'compras'
    $eliminacion = $con->query("DELETE FROM compras WHERE id = $id_compra");

    if ($eliminacion) {
      header('location: ../extend/alerta.php?msj=Se eliminó la compra correctamente&c=comp&p=comp&t=success');
      exit();
    } else {
      header('location: ../extend/alerta.php?msj=Error al eliminar la compra&c=comp&p=comp&t=error');
      exit();
    }
  } else {
    header('location: ../extend/alerta.php?msj=Error al restar la cantidad comprada del producto&c=comp&p=comp&t=error');
    exit();
  }
} else {
  // Redirigir en caso de no recibir una solicitud POST o GET válida
  header('location: ../extend/alerta.php?msj=Utiliza el formulario&c=comp&p=comp&t=error');
  exit();
}
?>