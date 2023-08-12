<?php
$conexion = mysqli_connect("localhost", "root", "", "almacen");

// Verificar si la conexión fue exitosa
if (!$conexion) {
    die("Error al conectarse a la base de datos: " . mysqli_connect_error());
}

// Preparar la consulta
$query = "SELECT * FROM productos";
$resultados = mysqli_query($conexion, $query);

// Verificar si se encontraron resultados
if (mysqli_num_rows($resultados) > 0) {
    // Generar archivo Excel con los resultados
    require_once '../PHPExcel/Classes/PHPExcel.php';

    $filename = "productos.xlsx";
    $objPHPExcel = new PHPExcel();
    $objPHPExcel->setActiveSheetIndex(0);
    $objPHPExcel->getActiveSheet()->setTitle('Productos');

    // Establecer color de fondo en el encabezado
    $headerStyle = array(
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                'rgb' => 'D3D3D3'
            )
        )
    );
    $objPHPExcel->getActiveSheet()->getStyle('A1:J1')->applyFromArray($headerStyle);

    $objPHPExcel->getActiveSheet()->setCellValue('A1', 'ID');
    $objPHPExcel->getActiveSheet()->setCellValue('B1', 'Código');
    $objPHPExcel->getActiveSheet()->setCellValue('C1', 'Nombre');
    $objPHPExcel->getActiveSheet()->setCellValue('D1', 'Modelo');
    $objPHPExcel->getActiveSheet()->setCellValue('E1', 'Unidad de Medida');
    $objPHPExcel->getActiveSheet()->setCellValue('F1', 'Stock Mínimo');
    $objPHPExcel->getActiveSheet()->setCellValue('G1', 'Cantidad por Unidad');
    $objPHPExcel->getActiveSheet()->setCellValue('H1', 'Precio de Compra');
    $objPHPExcel->getActiveSheet()->setCellValue('I1', 'Precio de Venta');
    $objPHPExcel->getActiveSheet()->setCellValue('J1', 'Ubicacion');

    $i = 2;
    while ($fila = mysqli_fetch_assoc($resultados)) {
        $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $fila['id']);
        $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $fila['codigo']);
        $objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $fila['nombre']);
        $objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $fila['modelo']);
        $objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $fila['unidad_medida']);
        $objPHPExcel->getActiveSheet()->setCellValue('F' . $i, $fila['minimoStock']);
        $objPHPExcel->getActiveSheet()->setCellValue('G' . $i, $fila['cantidad_por_unidad']);
        $objPHPExcel->getActiveSheet()->setCellValue('H' . $i, $fila['precio_compra']);
        $objPHPExcel->getActiveSheet()->setCellValue('I' . $i, $fila['precio_venta']);
        $objPHPExcel->getActiveSheet()->setCellValue('J' . $i, $fila['ubicacion']);
        $i++;
    }

    // Establecer bordes de las filas
    $objPHPExcel->getActiveSheet()->getStyle('A1:J'.($i-1))->applyFromArray(array(
        'borders' => array(
            'allborders' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN
            )
        )
    ));

    // Establecer ancho de las columnas
    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
    $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
    $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(30);

    // Configurar la salida del archivo
    ob_clean();

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="'.$filename.'"');
    header('Cache-Control: max-age=0');

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    $objWriter->save('php://output');
    exit();
} else {
    header('Location: ../extend/alerta.php?msj=No se encontraron resultados&c=inv&p=inv&t=error');
}

// Cerrar la conexión a la base de datos
mysqli_close($conexion);
?>
