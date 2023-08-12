<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los valores enviados por el formulario y validarlos
    $fecha_desde = filter_input(INPUT_POST, 'fecha_desde', FILTER_SANITIZE_STRING);
    $fecha_hasta = filter_input(INPUT_POST, 'fecha_hasta', FILTER_SANITIZE_STRING);

    require_once('../fpdf185/fpdf.php');

    // Conexión a la base de datos
    $conexion = mysqli_connect("localhost", "root", "", "almacen");

    // Verificar si la conexión fue exitosa
    if (!$conexion) {
        die("Error al conectarse a la base de datos: " . mysqli_connect_error());
    }

    $pdf = new FPDF();
    $pdf->AliasNbPages();
    $pdf->AddPage();
    // Logo
    $pdf->Image('../img/logo.jpeg', 30, 10, 25);
    // Formato
    $pdf->SetFont('Arial', 'B', 16);
    // Título
    $pdf->Cell(55);
    $pdf->Cell(100, 25, 'MARCELO MOTORS', 1, 0, 'C');
    // Fecha
    $pdf->SetFont("Arial", "", 10);
    $pdf->Cell(40, 5, "Fecha: " . date("d/m/Y"), 0, 1, 'C');
    $pdf->Ln(30);
    $pdf->SetFont('Arial', 'B', 9);

    // Encabezados de la tabla
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(12, 10, 'NRO', 1, 0, 'C', 0);
    $pdf->Cell(25, 10, 'CODIGO', 1, 0, 'C', 0);
    $pdf->Cell(75, 10, 'NOMBRE', 1, 0, 'C', 0);
    $pdf->Cell(17, 10, 'STOCK', 1, 0, 'C', 0);
    $pdf->Cell(25, 10, 'P.UNITARIO', 1, 0, 'C', 0);
    $pdf->Cell(25, 10, 'MONTO', 1, 0, 'C', 0);
    $pdf->Ln();

    // Consulta SQL para obtener las ventas  por fechahora descendente
    $query = "SELECT p.codigo, p.nombre AS producto, v.cantidad_vendida, CAST(ROUND(v.total/v.cantidad_vendida, 2) AS DECIMAL(10,2)) AS precio_unitario, CAST(v.total AS DECIMAL(10,2)) AS total FROM ventas v JOIN productos p ON v.producto_id = p.id WHERE v.fechahora BETWEEN '$fecha_desde 00:00:00' AND '$fecha_hasta 23:59:59' ORDER BY v.fechahora DESC";
    $sel = $conexion->query($query);

    $nro = 1; // Inicializar contador de número
    $totalGeneral = 0; // Variable para almacenar el total general

    while ($f = $sel->fetch_assoc()) {
        // Obtener la información de venta para el cliente y la fecha/hora actual
        $codigo = $f['codigo'];
        $producto = $f['producto'];
        $cantidad_vendida = $f['cantidad_vendida'];
        $precio_unitario = $f['precio_unitario'];
        $total = $f['total'];

        // Agregar una fila a la tabla en el PDF
        $pdf->Cell(12, 10, $nro, 1, 0, 'C', 0);
        $pdf->Cell(25, 10, $codigo, 1, 0, 'L', 0);
        $pdf->Cell(75, 10, $producto, 1, 0, 'L', 0);
        $pdf->Cell(17, 10, $cantidad_vendida, 1, 0, 'C', 0);
        $pdf->Cell(25, 10, $precio_unitario, 1, 0, 'R', 0);
        $pdf->Cell(25, 10, $total, 1, 0, 'R', 0);
        $pdf->Ln();

        $nro++; // Aumentar el contador de número
        $totalGeneral += $total; // Sumar al total general
    }

    // Agregar línea para el total general
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(154, 10, 'TOTAL GENERAL', 1, 0, 'R', 0);
    $pdf->Cell(25, 10, number_format($totalGeneral, 2), 1, 0, 'R', 0);
    $pdf->Ln();

    // Salida del PDF como descarga
    $pdf->Output('detalleventas.pdf', 'D');
}
?>


