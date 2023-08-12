<!DOCTYPE html>
<html lang="en">
<head>
  <title>Ventas e Devoluciones MARCELO MOTORS</title>
  <link rel="shortcut icon" type="image/x-icon" href="../img/logis.ico">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,600|Open+Sans" rel="stylesheet">
  <link rel="stylesheet" href="../css/estilosUsuario.css">
</head>
<?php include '../extend/header.php';
//include '../extend/permiso.php';
 ?>
 <style>
.card-title1 {
  font-size: 24px;
  font-weight: bold;
}
.card:first-child {
  background-color: #b3e5fc; /* Light blue color */
}
.card {
  max-height: 1500px; /* Ajusta la altura máxima según tus necesidades */
  overflow-y: auto; /* Agrega una barra de desplazamiento vertical cuando sea necesario */
}

</style>
<body>
<div class="row">
  <div class="col s12">
    <div class="card">
      <div class="card-content blue lighten-2">
        <center><span class="card-title1">VENTAS Y DEVOLUCIONES</span></center>
      </div> 
    </div>
    <div class="card">
      <?php
      $conexion = mysqli_connect("localhost", "root", "", "almacen");
      // Verificar si la conexión fue exitosa
      if (!$conexion) {
        die("Error al conectarse a la base de datos: " . mysqli_connect_error());
      }

      // Establecer el número de registros por página
      $registros_por_pagina = 15;

      // Obtener el número total de registros
      $total_registros = mysqli_num_rows($conexion->query("SELECT DISTINCT nombre, fechahora FROM ventas"));

      // Calcular el número total de páginas
      $total_paginas = ceil($total_registros / $registros_por_pagina);

      // Obtener el número de página actual
      if (!isset($_GET['page'])) {
        $page = 1;
      } else {
        $page = intval($_GET['page']);
        if ($page < 1) $page = 1;
        if ($page > $total_paginas) $page = $total_paginas;
      }

      // Calcular el número de registro inicial y final para la página actual
      $registro_inicial = ($page - 1) * $registros_por_pagina;
      $registro_final = $registro_inicial + $registros_por_pagina - 1;

      // Realizar la consulta SQL para obtener las ventas y devoluciones ordenadas por fechahora descendente
      $query = "SELECT DISTINCT nombre, fechahora FROM ventas ORDER BY fechahora DESC LIMIT $registro_inicial, $registros_por_pagina";
      $sel = $conexion->query($query);
      ?>
      <div class="card-content">
        <span class="card-title">Ventas y Devoluciones</span>
        <table>
          <thead>
            <th>Nombre</th>
            <th>Fechahora</th>
            <th>Total</th>
            <th>Ver Detalle</th>
          </thead>
          <?php 
          while ($f = $sel->fetch_assoc()) {
            // Obtener la información de venta para el cliente y la fecha/hora actual
            $nombre = $f['nombre'];
            $fechahora = $f['fechahora'];
            $venta_sel = $conexion->query("SELECT * FROM ventas WHERE nombre = '$nombre' AND fechahora = '$fechahora'");
            
            // Calcular el costo total de las ventas para el cliente y la fecha/hora actual
            $costoTotal = 0;
            while ($venta = $venta_sel->fetch_assoc()) {
              $costoTotal += $venta['total'];
            }

            // Imprimir la fila de la tabla con la información de venta
            ?>
            <tr>
              <td><?php echo $nombre ?></td>
              <td><?php echo $fechahora ?></td>
              <td><?php echo $costoTotal ?></td>
              <td>
                <!-- "Ver Detalle" button -->
                <a href="#modal<?php echo $nombre . $fechahora ?>" class="btn-floating green tooltipped modal-trigger" data-position="bottom" data-tooltip="Ver Detalle"><i class="material-icons">open_in_new</i></a>
              </td>
            </tr>
            <?php
          }
          ?>
        </table>
      </div>
      <div class="pagination-container">
        <div class="pagination">
          <?php if ($total_paginas > 1): ?>
            <ul class="pagination-list">
              <?php if ($page > 1): ?>
                <li>
                  <a href="?page=1" class="pagination-link" aria-label="Primera página">
                    <span class="icon">
                      <i class="fas fa-angle-double-left"></i>
                    </span>
                  </a>
                </li>
              <?php endif; ?>

              <?php
              // Calcula el rango de páginas a mostrar
              $rango = 3; // Número de páginas a mostrar a izquierda y derecha de la página actual
              $inicio = $page - $rango;
              $fin = $page + $rango;

              if ($inicio < 1) {
                $inicio = 1;
                $fin = min($total_paginas, $inicio + ($rango * 2));
              }

              if ($fin > $total_paginas) {
                $fin = $total_paginas;
                $inicio = max(1, $fin - ($rango * 2));
              }
              ?>

              <?php if ($inicio > 1): ?>
                <li>
                  <a href="?page=<?php echo $page - 1; ?>" class="pagination-link" aria-label="Anterior">
                    <span class="icon">
                      <i class="fas fa-angle-left"></i>
                    </span>
                  </a>
                </li>
              <?php endif; ?>

              <?php for ($i = $inicio; $i <= $fin; $i++): ?>
                <li>
                  <a href="?page=<?php echo $i; ?>" class="pagination-link <?php echo ($i == $page) ? 'is-current' : ''; ?>">
                    <?php echo $i; ?>
                  </a>
                </li>
              <?php endfor; ?>

              <?php if ($fin < $total_paginas): ?>
                <li>
                  <a href="?page=<?php echo $page + 1; ?>" class="pagination-link" aria-label="Siguiente">
                    <span class="icon">
                      <i class="fas fa-angle-right"></i>
                    </span>
                  </a>
                </li>
              <?php endif; ?>

              <?php if ($page < $total_paginas): ?>
                <li>
                  <a href="?page=<?php echo $total_paginas; ?>" class="pagination-link" aria-label="Última página">
                    <span class="icon">
                      <i class="fas fa-angle-double-right"></i>
                    </span>
                  </a>
                </li>
              <?php endif; ?>
            </ul>
          <?php endif; ?>
        </div>
      </div>
      <style >.pagination-container {
        text-align: center;
        margin-right: 20px; /* Ajusta el valor según sea necesario */
      }
      </style>
    </div>
  </div>
</div>

<?php 
$sel->data_seek(0); // Reiniciar el puntero del resultado
while ($f = $sel->fetch_assoc()) {
  $nombre = $f['nombre'];
  $fechahora = $f['fechahora'];
  $venta_sel = $conexion->query("SELECT * FROM ventas WHERE nombre = '$nombre' AND fechahora = '$fechahora'");
  ?>
  <div id="modal<?php echo $nombre . $fechahora ?>" class="modal">
    <div class="modal-content">
      <a href="#!" class="modal-close waves-effect waves-green btn-flat right"><i class="material-icons">close</i></a>
      <h5>Detalle de Ventas</h5>
      <!-- Agregar el botón de cierre -->

      <table class="detalle-table">
        <thead>
          <th>Producto</th>
          <th>Cantidad Vendida</th>
          <th>Unidad</th>
          <th>Total Unidad</th>
          <th>Devolver</th>
        </thead>
        <?php
        $venta_sel->data_seek(0); // Reiniciar el puntero del resultado
        while ($venta = $venta_sel->fetch_assoc()) {
          $producto_id = $venta['producto_id'];
          $producto_sel = $conexion->query("SELECT nombre FROM productos WHERE id = $producto_id");
          $producto = $producto_sel->fetch_assoc();
          ?>
          <tr>
            <td><?php echo $producto['nombre'] ?></td>
            <td><?php echo $venta['cantidad_vendida'] ?></td>
            <td><?php echo $venta['unidad_medida_vendida'] ?></td>
            <td><?php echo $venta['total'] ?></td>
            <td>
              <!-- "Devolver" button -->
              <a href="#" class="btn-floating blue tooltipped" onclick="confirmDevolverProducto(<?php echo $venta['id'] ?>)" data-position="bottom" data-tooltip="Devolver"><i class="material-icons">undo</i></a>
              <!-- "Devolver Cantidad" button -->
              <a href="#" class="btn-floating blue tooltipped" onclick="confirmDevolverCantidad(<?php echo $venta['id'] ?>)" data-position="bottom" data-tooltip="Devolver Cantidad"><i class="material-icons">remove</i></a>
            </td>
          </tr>
          <?php
        }
        ?>
      </table>
    </div>
  </div>
  <?php
}
?>

<!-- Incluir la librería Modal de Materialize CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Inicializar los modals
    var modals = document.querySelectorAll('.modal');
    M.Modal.init(modals);
  });

  function confirmDevolverProducto(id) {
    // Mostrar mensaje de confirmación
    const result = confirm('¿Estás seguro de que deseas devolver este producto?');
    if (result) {
      devolverProducto(id);
    }
  }

  function confirmDevolverCantidad(id) {
    // Obtener la cantidad a devolver
    const cantidadDevuelta = prompt('Ingresa la cantidad a devolver:');
    if (cantidadDevuelta !== null) {
      // Convertir la cantidad a un número entero
      const cantidad = parseInt(cantidadDevuelta);
      if (!isNaN(cantidad) && cantidad > 0) {
        devolverCantidad(id, cantidad);
      } else {
        alert('La cantidad ingresada es inválida.');
      }
    }
  }

  function devolverProducto(id) {
    const xhr = new XMLHttpRequest();

    xhr.onreadystatechange = function() {
      if (xhr.readyState === 4) {
        if (xhr.status === 200) {
          // Optionally, handle the response from the server
          console.log(xhr.responseText);
          // Recargar la página después de la devolución del producto
          location.reload();
        } else {
          console.error('Error:', xhr.status, xhr.statusText);
        }
      }
    };

    xhr.open("POST", "devolver_producto.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send("id=" + id);
  }

  function devolverCantidad(id, cantidad) {
    const xhr = new XMLHttpRequest();

    xhr.onreadystatechange = function() {
      if (xhr.readyState === 4) {
        if (xhr.status === 200) {
          // Optionally, handle the response from the server
          console.log(xhr.responseText);
          // Recargar la página después de la devolución de la cantidad
          location.reload();
        } else {
          console.error('Error:', xhr.status, xhr.statusText);
        }
      }
    };

    xhr.open("POST", "devolver_cantidad.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send("id=" + id + "&cantidad=" + cantidad);
  }
</script>


  <?php include '../extend/scripts.php'; ?>
  <script src="../js/validacion.js"></script>
</body>
</html>

