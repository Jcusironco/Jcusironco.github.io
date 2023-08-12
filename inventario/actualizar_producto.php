<?php
$conexion = mysqli_connect("localhost", "root", "", "almacen");

if (!$conexion) {
  die("Error al conectarse a la base de datos: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $id = $_POST["id"];
  $codigo = $_POST["codigo"];
  $nombre = $_POST["nombre"];
  $modelo = $_POST["modelo"];
  $unidadMedida = $_POST["unidad_medida"];
  $minimoStock = $_POST["minimoStock"];
  $ubicacion = $_POST["ubicacion"];
  $cantidadPorUnidad = $_POST["cantidad_por_unidad"];
  $precioCompra = $_POST["precio_compra"];
  $precioVenta = $_POST["precio_venta"];

  $sql = "UPDATE productos SET codigo='$codigo', nombre='$nombre', modelo='$modelo', unidad_medida='$unidadMedida', minimoStock=$minimoStock, ubicacion='$ubicacion', cantidad_por_unidad=$cantidadPorUnidad, precio_compra=$precioCompra, precio_venta=$precioVenta WHERE id=$id";

  if (mysqli_query($conexion, $sql)) {
    header('Location: ../extend/alerta.php?msj=Producto actualizado correctamente&c=inv&p=inv&t=success');
    exit();
  } else {
    header('Location: ../extend/alerta.php?msj=Error al actualizar el producto&c=inv&p=inv&t=error');
    exit();
  }
}

?>
