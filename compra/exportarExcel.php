<?php
$conexion = mysqli_connect("localhost", "root", "", "almacen");

// Verificar si la conexión fue exitosa
if (!$conexion) {
    die("Error al conectarse a la base de datos: " . mysqli_connect_error());
}

// Preparar la consulta
$query = "SELECT * FROM compras";
$resultados = mysqli_query($conexion, $query);

// Verificar si se encontraron resultados
if (mysqli_num_rows($resultados) > 0) {
    // Generar archivo Excel con los resultados
    require_once '../PHPExcel/Classes/PHPExcel.php';

    $filename = "compras.xlsx";
    $objPHPExcel = new PHPExcel();
    $objPHPExcel->setActiveSheetIndex(0);
    $objPHPExcel->getActiveSheet()->setTitle('Compras');

    // Establecer color de fondo en el encabezado
    $headerStyle = array(
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                'rgb' => 'D3D3D3'
            )
        )
    );
    $objPHPExcel->getActiveSheet()->getStyle('A1:G1')->applyFromArray($headerStyle);

    $objPHPExcel->getActiveSheet()->setCellValue('A1', 'ID');
    $objPHPExcel->getActiveSheet()->setCellValue('B1', 'Fecha y Hora');
    $objPHPExcel->getActiveSheet()->setCellValue('C1', 'Producto ID');
    $objPHPExcel->getActiveSheet()->setCellValue('D1', 'Cantidad Comprada');
    $objPHPExcel->getActiveSheet()->setCellValue('E1', 'Unidad de Medida Comprada');
    $objPHPExcel->getActiveSheet()->setCellValue('F1', 'Precio de Compra');
    $objPHPExcel->getActiveSheet()->setCellValue('G1', 'Precio de Venta');

    $i = 2;
    while ($fila = mysqli_fetch_assoc($resultados)) {
        $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $fila['id']);
        $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $fila['fechahora']);
        $objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $fila['producto_id']);
        $objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $fila['cantidad_comprada']);
        $objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $fila['unidad_medida_comprada']);
        $objPHPExcel->getActiveSheet()->setCellValue('F' . $i, $fila['precio_compra']);
        $objPHPExcel->getActiveSheet()->setCellValue('G' . $i, $fila['precio_venta']);
        $i++;
    }

    // Establecer bordes de las filas
    $objPHPExcel->getActiveSheet()->getStyle('A1:G'.($i-1))->applyFromArray(array(
        'borders' => array(
            'allborders' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN
            )
        )
    ));

    // Establecer ancho de las columnas
    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);

    // Configurar la salida del archivo
    ob_clean();

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="'.$filename.'"');
    header('Cache-Control: max-age=0');

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    $objWriter->save('php://output');
    exit();
} else {
    header('Location: ../extend/alerta.php?msj=No se encontraron resultados&c=comp&p=comp&t=error');
}

// Cerrar la conexión a la base de datos
mysqli_close($conexion);
?>
