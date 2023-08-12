<!DOCTYPE html>
<html lang="en">
<head>
  <title>Compras MARCELO MOTORS</title>
  <link rel="shortcut icon" type="image/x-icon" href="../img/logis.ico">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,600|Open+Sans" rel="stylesheet">
  <link rel="stylesheet" href="../css/estilosUsuario.css">
  <link rel="stylesheet" href="../css/estiloImportar.css">
  <link rel="stylesheet" href="../css/estiloEditarVehi.css">
</head>
<?php 
include '../extend/header.php';
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
<head>
<body>
  <div class="row">
    <div class="col s12">
      <div class="card">
        <div class="card-content blue lighten-2">
          <center><span class="card-title">REGISTRO DE COMPRAS</span></center>
        </div>
      </div>
      <div class="card">
        <div class="card-content">
        <?php

        // Establecer el número de registros por página
        $registros_por_pagina = 15;

        // Obtener el número total de registros
        $resultado = mysqli_query($con, "SELECT * FROM compras");
        if (!$resultado) {
            echo "Error de consulta: " . mysqli_error($con);
            exit;
        }

        $total_registros = mysqli_num_rows($resultado);

        // Calcular el número total de páginas
        $total_paginas = ceil($total_registros / $registros_por_pagina);

        // Obtener el número de página actual
        $page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
        $page = min($page, $total_paginas);

        // Calcular el número de registro inicial y final para la página actual
        $registro_inicial = max(0, ($page - 1) * $registros_por_pagina);

        $registro_final = $registro_inicial + $registros_por_pagina - 1;

        // Consultar los registros de la página actual
        $sel = $con->query("SELECT * FROM compras ORDER BY fechahora DESC LIMIT $registro_inicial, $registros_por_pagina");
        $num_rows = mysqli_num_rows($sel);

        ?>

        <div class="card-content">
          <span class="card-title">Compras (<?php echo $total_registros ?>)</span>
          <table>
            <thead>
              <tr>
                <th>Fecha Hora</th>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Unidad de Medida</th>
                <th>Precio Compra</th>
                <th>Precio Venta</th>
              </tr>
            </thead>
            <tbody>
              <?php
              if ($num_rows > 0) {
                while ($f = $sel->fetch_assoc()) {
                  ?>
                  <tr>
                    <td><?php echo $f['fechahora'] ?></td>
                    <td>
                      <?php
                      $producto_id = $f['producto_id'];
                      $producto_sel = mysqli_query($con, "SELECT nombre FROM productos WHERE id = $producto_id");
                      $producto = mysqli_fetch_assoc($producto_sel);
                      echo $producto['nombre'];
                      ?>
                    </td>
                    <td><?php echo $f['cantidad_comprada'] ?></td>
                    <td><?php echo $f['unidad_medida_comprada'] ?></td>
                    <td><?php echo $f['precio_compra'] ?></td>
                    <td><?php echo $f['precio_venta'] ?></td>
                  </tr>
                <?php
                }
              } else {
                ?>
                <tr>
                  <td colspan="6"></td>
                </tr>
              <?php
              }
              ?>
            </tbody>
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
          <style>.pagination-container {
            text-align: center;
            margin-right: 20px; /* Ajusta el valor según sea necesario */
          }
          </style>
     </div>
    </div>
  </div>

<?php include '../extend/scripts.php'; ?>
<script src="../js/validacion.js"></script>
</body>
</html>
