
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Dashboard MARCELO MOTORS</title>
  <link rel="shortcut icon" type="image/x-icon" href="../img/logis.ico">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,600|Open+Sans" rel="stylesheet">
  <link rel="stylesheet" href="../css/estiloVenta.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<?php
include '../extend/header.php';
//include '../extend/permiso.php';
?>
</head>
<style>
  @media (max-width: 600px) {
    #chartContainer {
      flex-direction: column;
    }
  }

  #chartContainer {
    display: flex;
    flex-wrap: wrap;
    margin: 0 auto; /* Agregamos esta propiedad para centrar los elementos */
    max-width: 800px; /* Ajustamos el ancho máximo del contenedor */
  }

  .chart-container {
    width: 100%; /* Cambiamos el ancho al 100% para dispositivos móviles */
    padding: 10px;
    box-sizing: border-box;
  }

  .card-title {
    color: black; /* Cambiamos el color del texto a negro */
  }
</style>
<body>
  <div id="chartContainer">
    <div class="chart-container">
      <div class="card">
        <div class="card-content">
          <span class="card-title">Producto más vendido</span>
          <div id="piechart" style="width: 100%; height: 400px;"></div>
        </div>
      </div>
    </div>
    <div class="chart-container">
      <div class="card">
        <div class="card-content">
          <span class="card-title">Ventas y Compras</span>
          <canvas id="chart"></canvas>
        </div>
      </div>
    </div>
  </div>
 <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Producto');
        data.addColumn('number', 'Cantidad');

        <?php
          // Ejemplo utilizando mysqli
          $host = 'localhost';
          $dbname = 'almacen';
          $username = 'root';
          $password = '';

          $conexion = mysqli_connect($host, $username, $password, $dbname);

          // Verificar si la conexión fue exitosa
          if (!$conexion) {
              die("Error al conectarse a la base de datos: " . mysqli_connect_error());
          }

          // Obtener el mes actual
          $mes_actual = date('m');

          // Consulta para obtener los productos más vendidos del mes actual
          $consulta = "SELECT p.nombre AS producto, SUM(v.cantidad_vendida) AS total_vendido
                      FROM ventas v
                      INNER JOIN productos p ON v.producto_id = p.id
                      WHERE MONTH(v.fechahora) = $mes_actual
                      GROUP BY v.producto_id
                      ORDER BY total_vendido DESC
                      LIMIT 20";

          $resultado = mysqli_query($conexion, $consulta);

          // Verificar si la consulta fue exitosa
          if (!$resultado) {
              die("Error al ejecutar la consulta: " . mysqli_error($conexion));
          }

          // Agregar los datos al DataTable
          while ($fila = mysqli_fetch_assoc($resultado)) {
              $producto = $fila['producto'];
              $cantidad = $fila['total_vendido'];

              echo "data.addRow(['$producto', $cantidad]);";
          }

          // Cerrar la conexión
          mysqli_close($conexion);
        ?>

        var options = {
          title: 'Productos más vendidos por mes',
          backgroundColor: {
            fill: 'transparent'
          },
          legendTextStyle: {
            color: '#000000'
          },
          titleTextStyle: {
            color: '#000000'
          }
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));
        chart.draw(data, options);
      }
    </script>


<script>
  <?php
  // Configuración de la conexión a la base de datos
  $host = 'localhost';
  $dbname = 'almacen';
  $username = 'root';
  $password = '';

  // Establecer la conexión
  $conexion = mysqli_connect($host, $username, $password, $dbname);

  // Verificar si la conexión fue exitosa
  if (!$conexion) {
      die("Error al conectarse a la base de datos: " . mysqli_connect_error());
  }

  // Generar un conjunto completo de meses (desde enero hasta diciembre)
  $mesesCompletos = array();
  for ($i = 1; $i <= 12; $i++) {
      $mesesCompletos[$i] = array('ventas' => 0, 'compras' => 0);
  }

  // Consulta para obtener la suma total de ventas por mes
  $consultaVentas = "SELECT MONTH(fechahora) AS mes, SUM(total) AS total_ventas
                    FROM ventas
                    GROUP BY mes";

  $resultadoVentas = mysqli_query($conexion, $consultaVentas);

  // Verificar si la consulta de ventas fue exitosa
  if (!$resultadoVentas) {
      die("Error al ejecutar la consulta de ventas: " . mysqli_error($conexion));
  }

  // Agregar los datos de ventas al arreglo $mesesCompletos
  while ($filaVentas = mysqli_fetch_assoc($resultadoVentas)) {
      $mes = (int)$filaVentas['mes'];
      $totalVentas = (int)$filaVentas['total_ventas'];
      $mesesCompletos[$mes]['ventas'] = $totalVentas;
  }

  // Consulta para obtener la suma total de compras por mes
  $consultaCompras = "SELECT MONTH(fechahora) AS mes, SUM(precio_compra * cantidad_comprada) AS total_compras
                    FROM compras
                    GROUP BY mes";

  $resultadoCompras = mysqli_query($conexion, $consultaCompras);

  // Verificar si la consulta de compras fue exitosa
  if (!$resultadoCompras) {
      die("Error al ejecutar la consulta de compras: " . mysqli_error($conexion));
  }

  // Agregar los datos de compras al arreglo $mesesCompletos
  while ($filaCompras = mysqli_fetch_assoc($resultadoCompras)) {
      $mes = (int)$filaCompras['mes'];
      $totalCompras = (int)$filaCompras['total_compras'];
      $mesesCompletos[$mes]['compras'] = $totalCompras;
  }

  // Extraer los datos de ventas y compras para el gráfico
  $dataVentas = array();
  $dataCompras = array();
  for ($i = 1; $i <= 12; $i++) {
      $dataVentas[] = $mesesCompletos[$i]['ventas'];
      $dataCompras[] = $mesesCompletos[$i]['compras'];
  }

  // Convertir los datos en formato JSON
  $json_dataVentas = json_encode(array_values($dataVentas));
  $json_dataCompras = json_encode(array_values($dataCompras));
  ?>

  // Datos obtenidos de las consultas SQL
  var dataVentas = <?php echo $json_dataVentas; ?>;
  var dataCompras = <?php echo $json_dataCompras; ?>;

  // Nombres de los meses
  var meses = [
      'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
      'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
  ];

  // Crear el gráfico
  var ctx = document.getElementById('chart').getContext('2d');
  var chart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: meses,
        datasets: [
            {
                label: 'Ventas',
                data: dataVentas,
                backgroundColor: 'rgba(54, 162, 235, 0.2)', // Cambiar el color de las barras de ventas (azul)
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            },
            {
                label: 'Compras',
                data: dataCompras,
                backgroundColor: 'rgba(255, 99, 132, 0.2)', // Cambiar el color de las barras de compras (rojo)
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            }
        ]
      },
      options: {
          scales: {
              y: {
                  beginAtZero: true,
                  stepSize: 1
              }
          },
          plugins: {
              annotation: {
                  annotations: [{
                      type: 'line',
                      mode: 'horizontal',
                      scaleID: 'y',
                      value: dataVentas[0],
                      borderColor: 'rgba(75, 192, 192, 1)',
                      borderWidth: 1,
                      label: {
                          enabled: true,
                          content: 'Ventas: ' + dataVentas[0].toString(),
                          position: 'right'
                      }
                  }, {
                      type: 'line',
                      mode: 'horizontal',
                      scaleID: 'y',
                      value: dataCompras[0],
                      borderColor: 'rgba(54, 162, 235, 1)',
                      borderWidth: 1,
                      label: {
                          enabled: true,
                          content: 'Compras: ' + dataCompras[0].toString(),
                          position: 'right'
                      }
                  }],
                  drawTime: 'afterDatasetsDraw'
              },
              datalabels: {
                  anchor: 'end',
                  align: 'end',
                  color: 'black',
                  font: {
                      weight: 'bold'
                  },
                  formatter: function(value) {
                      return value.toString();
                  }
              }
          },
          onAfterDraw: function(chart) {
              var ctx = chart.ctx;
              chart.data.datasets.forEach(function(dataset, datasetIndex) {
                  var meta = chart.getDatasetMeta(datasetIndex);
                  meta.data.forEach(function(bar, index) {
                      var data = dataset.data[index];
                      ctx.fillStyle = 'black';
                      ctx.font = '12px Arial';
                      ctx.textAlign = 'center';
                      ctx.textBaseline = 'bottom';
                      ctx.fillText(data, bar.x, bar.y - 5);
                  });
              });
          }
      }
  });
</script>


</body>
<?php include '../extend/scripts.php'; ?>
</html>
