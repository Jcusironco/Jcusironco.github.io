<!DOCTYPE html>
<html lang="en">
<head>
  <title>Caja MARCELO MOTORS</title>
  <link rel="shortcut icon" type="image/x-icon" href="../img/logis.ico">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,600|Open+Sans" rel="stylesheet">
</head>
<?php
include '../extend/header.php';
//include '../extend/permiso.php';
?>
<?php
date_default_timezone_set('America/Lima'); // Establecer la zona horaria de Perú
$currentDate = date('Y-m-d'); // Obtener la fecha actual en formato YYYY-MM-DD
$currentMonth = date('Y-m'); // Obtener el mes actual en formato YYYY-MM

// Obtener el ingreso en efectivo total del mes actual
$ingresoEfectivo = 0.00; // Establecer el ingreso en efectivo predeterminado
$ingresoEfectivoQuery = mysqli_query($con, "SELECT SUM(total) AS total_ventas FROM ventas WHERE DATE_FORMAT(fechahora, '%Y-%m') = '$currentMonth'");
if ($ingresoEfectivoQuery) {
  $ingresoEfectivoResult = mysqli_fetch_assoc($ingresoEfectivoQuery);
  $ingresoEfectivo = $ingresoEfectivoResult['total_ventas'];
} else {
  echo "Error en la consulta: " . mysqli_error($con);
}

// Obtener la venta en efectivo del día actual
$ventaEfectivo = 0.00; // Establecer la venta en efectivo predeterminada
$ventaEfectivoQuery = mysqli_query($con, "SELECT SUM(total) AS total_ventas FROM ventas WHERE DATE(fechahora) = '$currentDate'");
if ($ventaEfectivoQuery) {
  $ventaEfectivoResult = mysqli_fetch_assoc($ventaEfectivoQuery);
  $ventaEfectivo = $ventaEfectivoResult['total_ventas'];
} else {
  echo "Error en la consulta: " . mysqli_error($con);
}

// Obtener los egresos de compras del mes actual
$egresosCompras = 0.00; // Establecer los egresos de compras predeterminados
$egresosComprasQuery = mysqli_query($con, "SELECT SUM(cantidad_comprada * precio_compra) AS total_compra FROM compras WHERE DATE_FORMAT(fechahora, '%Y-%m') = '$currentMonth'");
if ($egresosComprasQuery) {
  $egresosComprasResult = mysqli_fetch_assoc($egresosComprasQuery);
  $egresosCompras = $egresosComprasResult['total_compra'];
} else {
  echo "Error en la consulta: " . mysqli_error($con);
}

// Obtener las compras en efectivo del día actual
$comprasEfectivo = 0.00; // Establecer las compras en efectivo predeterminadas
$comprasEfectivoQuery = mysqli_query($con, "SELECT SUM(precio_compra) AS total_compra FROM compras WHERE DATE(fechahora) = '$currentDate'");
if ($comprasEfectivoQuery) {
  $comprasEfectivoResult = mysqli_fetch_assoc($comprasEfectivoQuery);
  $comprasEfectivo = $comprasEfectivoResult['total_compra'];
} else {
  echo "Error en la consulta: " . mysqli_error($con);
}

// Obtener las ganancias del mes actual
$totalComprasPorMesQuery = mysqli_query($con, "SELECT SUM(precio_compra * cantidad_comprada) AS total_compras FROM compras WHERE DATE_FORMAT(fechahora, '%Y-%m') = '$currentMonth'");
$totalComprasPorMesResult = mysqli_fetch_assoc($totalComprasPorMesQuery);
$totalComprasPorMes = $totalComprasPorMesResult['total_compras'];

$totalVentasPorMesQuery = mysqli_query($con, "SELECT SUM(total) AS total_ventas FROM ventas WHERE DATE_FORMAT(fechahora, '%Y-%m') = '$currentMonth'");
$totalVentasPorMesResult = mysqli_fetch_assoc($totalVentasPorMesQuery);
$totalVentasPorMes = $totalVentasPorMesResult['total_ventas'];

$gananciasPorMes = $totalVentasPorMes - $totalComprasPorMes;

// Obtener las ganancias del día actual
$totalComprasPorDiaQuery = mysqli_query($con, "SELECT SUM(precio_compra * cantidad_comprada) AS total_compras FROM compras WHERE DATE(fechahora) = '$currentDate'");
$totalComprasPorDiaResult = mysqli_fetch_assoc($totalComprasPorDiaQuery);
$totalComprasPorDia = $totalComprasPorDiaResult['total_compras'];

$totalVentasPorDiaQuery = mysqli_query($con, "SELECT SUM(total) AS total_ventas FROM ventas WHERE DATE(fechahora) = '$currentDate'");
$totalVentasPorDiaResult = mysqli_fetch_assoc($totalVentasPorDiaQuery);
$totalVentasPorDia = $totalVentasPorDiaResult['total_ventas'];

$gananciasPorDia = $totalVentasPorDia - $totalComprasPorDia;
?>
<body>
  <div class="row">
    <div class="col s12">
      <div class="card">
        <h3>FLUJO DE CAJA</h3>
        <button id="open-btn" class="btn-open">Reporte de pdf</button>
        <div class="overlay">
          <div class="popup">
            <h4>Generar Informe</h4>
            <form id="report-form" method="POST" action="reporte.php" enctype="multipart/form-data" autocomplete="off">
              <div class="contenedor-inputs">
                Desde
                <label for="min"></label>
                <input type="date" value="<?php echo date('Y-m-d'); ?>" id="min" name="fecha_desde">
              </div>
              <div class="contenedor-inputs">
                Hasta
                <label for="max"></label>
                <input type="date" value="<?php echo date('Y-m-d'); ?>" id="max" name="fecha_hasta">
              </div>
              <div class="contenedor-inputs">
                <button type="submit" class="btn-generar-informe">Generar Informe</button>
              </div>
            </form>
            <button id="close-btn" class="btn-close btn-close">cerrar</button>
          </div>
        </div>
        <script>
          const openBtn = document.getElementById('open-btn');
          const closeBtn = document.getElementById('close-btn');
          const overlay = document.querySelector('.overlay');

          openBtn.addEventListener('click', function() {
            overlay.style.display = 'flex';
          });

          closeBtn.addEventListener('click', function() {
            overlay.style.display = 'none';
          });
        </script>
        <!-- Archivo JavaScript para controlar el popup -->
        <style>
          .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: none;
            justify-content: center;
            align-items: center;
          }

          .popup {
            background-color: white;
            padding: 20px;
          }

          .btn-open,
          .btn-close {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
          }

          .btn-open:hover,
          .btn-close:hover {
            background-color: #45a049;
          }

          .btn-generar-informe {
            background-color: blue;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
          }

          .btn-generar-informe:hover {
            background-color: darkblue;
          }

          .btn-close-right {
            position: relative;
            float: right;
          }
        </style>
        <table>
          <tr>
            <td><h5>INGRESO EFECTIVO(MES)</h5></td>
            <td><h5>S/ <?php echo number_format($ingresoEfectivo, 2); ?></h5></td>
          </tr>
          <tr>
            <td><h6>VENTA</h6></td>
          </tr>
          <tr>
            <td>- Efectivo(Dia)</td>
            <td>S/ <?php echo number_format($ventaEfectivo, 2); ?></td>
          </tr>
          <tr>
            <td><h5>EGRESOS DE COMPRAS(MES)</h5></td>
            <td><h5>S/ <?php echo number_format($egresosCompras, 2); ?></h5></td>
          </tr>
          <tr>
            <td><h6>COMPRAS</h6></td>
          </tr>
          <tr>
            <td>- Compras(Dia)</td>
            <td>S/ <?php echo number_format($comprasEfectivo, 2); ?></td>
          </tr>
          <tr>
            <td><h5>GANANCIAS(MES)</h5></td>
            <td><h5>S/ <?php echo number_format($gananciasPorMes, 2); ?></h5></td>
          </tr>
          <tr>
            <td><h6>GANANCIAS</h6></td>
          </tr>
          <tr>
            <td>- Ganancias(Dia)</td>
            <td>S/ <?php echo number_format($gananciasPorDia, 2); ?></td>
          </tr>
        </table>
      </div>
    </div>
  </div>
</body>

<style>
  /* Estilos generales */
  body {
    background-color: #f2f2f2;
    color: #333;
  }

  /* Estilos para td y tr */
  td {
    padding: 10px;
  }

  tr:nth-child(even) {
    background-color: #fff;
  }

  /* Estilos para el encabezado */
  h3 {
    color: #333;
    margin-top: 0;
    padding: 10px;
    background-color: #ddd;
    text-align: center;
    font-weight: bold;
  }

  h6 {
    margin-top: 0;
    color: #333;
  }
  
  /* Estilos adicionales */
  tr:nth-child(1),
  tr:nth-child(4),
  tr:nth-child(7) {
    background-color: #ccc;
  }
  
  /* Modo claro */
  body.light-mode {
    background-color: #f2f2f2;
    color: #333;
  }
  
  body.light-mode tr:nth-child(1),
  body.light-mode tr:nth-child(4),
  body.light-mode tr:nth-child(7) {
    background-color: #ccc;
  }
  
  /* Modo oscuro */
  body.dark-mode {
    background-color: #333;
    color: #fff;
  }

tr:nth-child(3),

tr:nth-child(6),

tr:nth-child(9) {
  color: #000;
}
body.dark-mode tr:nth-child(2) h6,
body.dark-mode tr:nth-child(5) h6,
body.dark-mode tr:nth-child(8) h6 {
  color: #000;
}


  body.dark-mode tr:nth-child(1),
  body.dark-mode tr:nth-child(4),
  body.dark-mode tr:nth-child(7) {
    background-color: #000;
  }
  
  body.dark-mode h3,
  body.dark-mode h5,
  body.dark-mode h6 {
    color: #fff;
  }
.overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  display: none;
  justify-content: center;
  align-items: center;
}

.popup {
  background-color: white;
  padding: 20px;
}

.popup h4 {
  margin-top: 0;
}

.popup button {
  margin-top: 10px;
}

.popup button:first-child {
  margin-right: 10px;
}

</style>





<?php include '../extend/scripts.php'; ?>
<script src="../js/validacion.js"></script>
</body>
</html>
