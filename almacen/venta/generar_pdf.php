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

        // Verificar la cantidad disponible del producto en la tabla de productos
        $query = "SELECT cantidad_por_unidad FROM productos WHERE id = '$productoId'";
        $resultado = mysqli_query($conexion, $query);

        if ($resultado && mysqli_num_rows($resultado) > 0) {
            $filaProducto = mysqli_fetch_assoc($resultado);
            $cantidadDisponibleProducto = $filaProducto['cantidad_por_unidad'];

            if ($cantidadDisponibleProducto < $cantidadFila) {
                header('Location: ../extend/alerta.php?msj=No hay suficiente cantidad disponible para realizar la venta&c=ven&p=ven&t=error');
                exit;
            }
        } else {
            header('Location: ../extend/alerta.php?msj=Error al obtener información del producto&c=ven&p=ven&t=error');
            exit;
        }

        // Insertar datos en la tabla de ventas
        $query = "INSERT INTO ventas (nombre, fechahora, producto_id, cantidad_vendida, unidad_medida_vendida, total)
                  VALUES ('$nombres', '$fechaHora', '$productoId', '$cantidadFila', '$unidadMedida', '$totalFila')";
        if (!mysqli_query($conexion, $query)) {
            header('Location: ../extend/alerta.php?msj=Error al registrar la venta&c=ven&p=ven&t=error');
            exit;
        }

        // Actualizar el campo cantidad_por_unidad en la tabla de productos
        $query = "UPDATE productos SET cantidad_por_unidad = cantidad_por_unidad - '$cantidadFila' WHERE id = '$productoId'";
        if (!mysqli_query($conexion, $query)) {
            header('Location: ../extend/alerta.php?msj=Error al actualizar la cantidad del producto&c=ven&p=ven&t=error');
            exit;
        }

        $cantidadTotal += $cantidadFila;
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
