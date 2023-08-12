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
            $codigo = $hoja->getCell('B' . $i)->getValue();
            $nombre = $hoja->getCell('C' . $i)->getValue();
            $modelo = $hoja->getCell('D' . $i)->getValue();
            $unidad_medida = $hoja->getCell('E' . $i)->getValue();
            $minimoStock = $hoja->getCell('F' . $i)->getValue();
            $cantidad_por_unidad = $hoja->getCell('G' . $i)->getValue();
            $precio_compra = $hoja->getCell('H' . $i)->getValue();
            $precio_venta = $hoja->getCell('I' . $i)->getValue();
            $ubicacion = $hoja->getCell('J' . $i)->getValue();

            // Realizar la consulta de inserción en la base de datos
            $query = "INSERT INTO productos (id, codigo, nombre, modelo, unidad_medida, minimoStock, cantidad_por_unidad, precio_compra, precio_venta, ubicacion)
                      VALUES ('$id', '$codigo', '$nombre', '$modelo', '$unidad_medida', '$minimoStock', '$cantidad_por_unidad', '$precio_compra', '$precio_venta', '$ubicacion')";

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
        header('location:../extend/alerta.php?msj=Importación exitosa&c=inv&p=inv&t=success');
        exit();
    } else {
        // Detener el almacenamiento en búfer y limpiarlo
        ob_end_clean();
        // Redireccionar a una página de error si el archivo no es de tipo Excel
        header('location:../extend/alerta.php?msj=El archivo debe ser de tipo Excel (xlsx, xls)&c=inv&p=inv&t=error');
        exit();
    }
} else {
    // Detener el almacenamiento en búfer y limpiarlo
    ob_end_clean();
    // Redireccionar a una página de error si no se ha enviado ningún archivo
    header('location:../extend/alerta.php?msj=No se ha seleccionado ningún archivo&c=inv&p=inv&t=error');
    exit();
}

// Cerrar la conexión a la base de datos
mysqli_close($conexion);
?>
