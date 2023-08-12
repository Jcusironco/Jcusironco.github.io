<?php
ob_start(); // Iniciar almacenamiento en búfer de salida

$conexion = mysqli_connect("localhost", "root", "", "almacen");

// Verificar si la conexión fue exitosa
if (!$conexion) {
    die("Error al conectarse a la base de datos: " . mysqli_connect_error());
}

// Verificar si se ha enviado un archivo
if (isset($_FILES['archivo_excel'])) {
    // Ruta temporal del archivo subido
    $archivo_tmp = $_FILES['archivo_excel']['tmp_name'];

    // Obtener la extensión del archivo
    $extension = pathinfo($_FILES['archivo_excel']['name'], PATHINFO_EXTENSION);

    // Verificar si el archivo es de tipo Excel
    if ($extension == 'xlsx' || $extension == 'xls') {
        // Cargar la biblioteca PHPExcel
        require_once '../PHPExcel/Classes/PHPExcel.php';

        // Crear un objeto PHPExcel
        $objPHPExcel = PHPExcel_IOFactory::load($archivo_tmp);

        // Obtener la hoja activa del archivo
        $hoja = $objPHPExcel->getActiveSheet();

        // Obtener el número de filas con datos en la hoja
        $filas = $hoja->getHighestRow();

        // Importar los datos a la base de datos
        for ($i = 2; $i <= $filas; $i++) {
            $id = $hoja->getCell('A' . $i)->getValue();
            $fechaHora = $hoja->getCell('B' . $i)->getValue();
            $productoId = $hoja->getCell('C' . $i)->getValue();
            $cantidadComprada = $hoja->getCell('D' . $i)->getValue();
            $unidadMedidaComprada = $hoja->getCell('E' . $i)->getValue();
            $precioCompra = $hoja->getCell('F' . $i)->getValue();
            $precioVenta = $hoja->getCell('G' . $i)->getValue();

            // Realizar la inserción en la base de datos
            $query = "INSERT INTO compras (id, fechahora, producto_id, cantidad_comprada, unidad_medida_comprada, precio_compra, precio_venta) VALUES ('$id', '$fechaHora', '$productoId', '$cantidadComprada', '$unidadMedidaComprada', '$precioCompra', '$precioVenta')";

            if (!mysqli_query($conexion, $query)) {
                // Detener el almacenamiento en búfer y limpiarlo
                ob_end_clean();
                // Imprimir el error específico de MySQL
                echo "Error al ejecutar la consulta: " . mysqli_error($conexion);
                exit();
            }
        }

        // Detener el almacenamiento en búfer y limpiarlo
        ob_end_clean();
        // Redireccionar a una página de éxito
        header('location:../extend/alerta.php?msj=Importación exitosa&c=comp&p=comp&t=success');
        exit();
    } else {
        // Detener el almacenamiento en búfer y limpiarlo
        ob_end_clean();
        // Redireccionar a una página de error si el archivo no es de tipo Excel
        header('location:../extend/alerta.php?msj=El archivo debe ser de tipo Excel (xlsx, xls)&c=comp&p=comp&t=error');
        exit();
    }
} else {
    // Detener el almacenamiento en búfer y limpiarlo
    ob_end_clean();
    // Redireccionar a una página de error si no se ha enviado ningún archivo
    header('location:../extend/alerta.php?msj=No se ha seleccionado ningún archivo&c=comp&p=comp&t=error');
    exit();
}

// Cerrar la conexión a la base de datos
mysqli_close($conexion);
?>
