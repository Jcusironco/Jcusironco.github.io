<?php
$conexion = mysqli_connect("localhost", "root", "", "almacen");

// Verificar si la conexión fue exitosa
if (!$conexion) {
    die("Error al conectarse a la base de datos: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del formulario
    $nombres = $_POST['nombres'];
    $fechaHora = $_POST['fechaHora'];
    $filasTablaJSON = $_POST['filasTabla'];
    $filasTabla = json_decode(stripslashes($filasTablaJSON), true);
    $cantidadTotal = 0;

    foreach ($filasTabla as $fila) {
        $productoId = $fila['id'];
        $unidadMedida = $fila['unidadMedida'];
        $cantidadFila = $fila['cantidad'];
        $totalFila = $fila['total'];

        // Insertar datos en la tabla de ventas
        $query = "INSERT INTO compras (fechahora, producto_id, cantidad_comprada, unidad_medida_comprada, precio_compra,precio_venta)
                  VALUES ('$fechaHora', '$productoId', '$cantidadFila', '$unidadMedida', '')";
        if (!mysqli_query($conexion, $query)) {
            header('Location: ../extend/alerta.php?msj=Error al registrar la venta&c=ven&p=ven&t=error');
            exit;
        }

    // Cerrar la conexión a la base de datos
    mysqli_close($conexion);

    // Redirigir a una página de éxito
    header('Location: ../extend/alerta.php?msj=La venta se realizó exitosamente&c=ven&p=ven&t=success');
    exit;
} else {
    // Redirigir a una página de error
    header('Location: ../extend/alerta.php?msj=Utiliza el formulario&c=ven&p=ven&t=error');
    exit;
}
?>
