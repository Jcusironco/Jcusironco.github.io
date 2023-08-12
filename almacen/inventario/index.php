<!DOCTYPE html>
<html lang="en">
<head>
  <title>Inventario MARCELO MOTORS</title>
  <link rel="shortcut icon" type="image/x-icon" href="../img/logis.ico">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,600|Open+Sans" rel="stylesheet">
  <link rel="stylesheet" href="../css/estilosUsuario.css">
  <link rel="stylesheet" href="../css/estiloImportar.css">
  <link rel="stylesheet" href="../css/estiloEditarVehi.css">
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
          <center><span class="card-title1">REGISTRO DE PRODUCTOS</span></center>
        </div>
      </div>
      <div class="card">
        <div class="card-content">
          <div class="row">
            <div class="col s4 offset-s8">
              <nav class="brown lighten-5">
                <div class="nav-wrapper">
                  <div class="input-field">
                    <input type="search" id="buscar" autocomplete="off">
                    <label for="buscar"><i class="material-icons">search</i></label>
                    <i class="material-icons">close</i>
                  </div>
                </div>
              </nav>
            </div>
          </div>
          <div class="contenedor">
            <article>
              <button id="btn-abrir-popup" class="btn-abrir-popup blue">+ Nuevo</button>
              <button id="btn-abrir-popup1" class="btn-abrir-popup1 lemon green">Excel</button>
            </article>
            <div class="overlay" id="overlay">
              <div class="popup" id="popup">
                <a href="#" id="btn-cerrar-popup" class="btn-cerrar-popup"><i class="fas fa-times"></i></a>
                <h3>REGISTRO DE PRODUCTOS</h3>
                <h4>Rellene los datos</h4>
                <form action="ins_producto.php" method="post" enctype="multipart/form-data" autocomplete="off" class="registro-form">
                  <div class="col s12 m6">
                    <div class="contenedor-inputs">
                      <label for="codigo">Código:</label>
                      <input type="text" id="codigo" name="codigo" placeholder="Ingrese el código del producto" required>

                      <label for="nombre">Nombre producto:</label>
                      <input type="text" id="nombre" name="nombre" placeholder="Ingrese el nombre del producto" required>

                      <label for="modelo">modelo:</label>
                      <input type="text" id="modelo" name="modelo" placeholder="Ingrese el modelo del producto" required>

                      <label for="unidad_medida">Unidad de Medida:</label>
                      <select id="unidad_medida" name="unidad_medida" required>
                        <option value="UNIDAD">UNIDAD</option>
                        <!-- Puedes agregar más opciones aquí según tus necesidades -->
                      </select>
                    </div>
                  </div>
                  <div class="col s12 m6">
                    <div class="contenedor-inputs">
                      <label for="ubicacion">Ubicacion</label>
                      <input type="text" id="ubicacion" name="ubicacion" placeholder="Ingrese la direccion del producto" required>
                      <label for="minimoStock">Stock mínimo:</label>
                      <input type="number" step="0.01" id="minimoStock" name="minimoStock" placeholder="Ingrese el stock mínimo"required>
                      <label for="cantidad_por_unidad">Stock:</label>
                      <input type="number" id="cantidad_por_unidad" name="cantidad_por_unidad" placeholder="Ingrese el Stock" required>

                      <label for="precio_compra" style="display: none;">Precio de Compra:</label>
                      <input type="number" step="0.01" id="precio_compra" name="precio_compra" placeholder="Ingrese el precio de compra" style="display: none;">

                      <label for="precio_venta" style="display: none;">Precio de Venta:</label>
                      <input type="number" step="0.01" id="precio_venta" name="precio_venta" placeholder="Ingrese el precio de venta" style="display: none;">
                    </div>
                  </div>
                  <input type="submit" class="btn-submit" id="btn_almacenar" value="Guardar">
                </form>

              </div>
            </div>
            <script src="../js/popup.js"></script>
            <div id="excel-popup">
              <div id="excel-popup-overlay"></div>
              <div class="contenido">
                <div class="overlay1" id="overlay1">
                  <div class="popup1" id="popup1">
                    <a href="#" id="btn-cerrar-popup1" class="btn-cerrar-popup1 limon">&times;</a>
                    <h3>Excel</h3>
                    <h5>Importador y Exportador</h5>
                    <div class="form-container">
                      <form method="post" enctype="multipart/form-data" action="exportarExcelProductos.php">
                        <div class="contenedor-inputs">
                          <button type="submit" name="export">Exportar a Excel</button>
                        </div>
                      </form>
                      <form method="post" enctype="multipart/form-data" action="importarExcelProductos.php">
                        <div class="contenedor-inputs">
                          <label for="archivo_excel" class="btn-seleccionar-archivo"></label>
                          <input type="file" id="archivo_excel" name="archivo_excel" accept=".xls,.xlsx">
                          <br>
                          <input type="submit" name="submit" value="Importar">
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <script>
              // Obtener elementos del DOM
              const btnAbrirPopup1 = document.getElementById('btn-abrir-popup1');
              const overlay1 = document.getElementById('overlay1');
              const popup1 = document.getElementById('popup1');
              const btnCerrarPopup1 = document.getElementById('btn-cerrar-popup1');

              // Función para abrir el popup
              function abrirPopup1() {
                overlay1.style.visibility = 'visible';
                overlay1.style.opacity = '1';
              }

              // Función para cerrar el popup
              function cerrarPopup1() {
                overlay1.style.visibility = 'hidden';
                overlay1.style.opacity = '0';
              }

              // Asignar eventos a los botones
              btnAbrirPopup1.addEventListener('click', abrirPopup1);
              btnCerrarPopup1.addEventListener('click', cerrarPopup1);

            </script>
          </div>
          
          <?php


            // Establecer el número de registros por página
            $registros_por_pagina = 15;

            // Obtener el número total de registros
            $sel = $con->query("SELECT COUNT(*) as total_registros FROM productos");
            $total_registros = $sel->fetch_assoc()['total_registros'];

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

            // Consultar los registros de la página actual
            $sel = $con->query("SELECT * FROM productos LIMIT $registro_inicial, $registros_por_pagina");
            $num_rows = $sel->num_rows;
          ?>
          <div class="card-content">
            <span class="card-title">Productos (<?php echo $total_registros ?>)</span>
            <table>
              <thead>
                <tr>
                  <th>Nombre</th>
                  <th>Modelo</th>
                  <th>Codigo</th>
                  <th>U.M</th>
                  <th>Minimo</th>
                  <th>Stock</th>
                  <th>P. Compra</th>
                  <th>P. Venta</th>
                  <th>Ubicacion</th>
                  <th>Acciones</th>
                </tr>
              </thead>
              <tbody>
                <?php while ($row = mysqli_fetch_assoc($sel)) {
                  // Obtener el valor de minimoStock y cantidad_por_unidad
                  $minimoStock = intval($row['minimoStock']);
                  $cantidadUnidad = intval($row['cantidad_por_unidad']);

                  // Comparar minimoStock con cantidad_por_unidad
                  if ($minimoStock >= $cantidadUnidad) {
                    echo '<script>alert("¡El stock de ' . $row['nombre'] . ' está agotado! Aumente el stock.");</script>';
                  }
                ?>
                <tr>
                  <td><?php echo $row['nombre'] ?></td>
                  <td><?php echo $row['modelo'] ?></td>
                  <td><?php echo $row['codigo'] ?></td>
                  <td><?php echo $row['unidad_medida'] ?></td>
                  <td><?php echo $row['minimoStock'] ?></td>
                  <td><?php echo $row['cantidad_por_unidad'] ?></td>
                  <td><?php echo $row['precio_compra'] ?></td>
                  <td><?php echo $row['precio_venta'] ?></td>
                  <td><?php echo $row['ubicacion'] ?></td>
                  <td style="white-space: nowrap;">
                    <button class="boton-editar" data-id="<?php echo $row['id']; ?>">
                      <i class="fas fa-pencil-alt"></i>
                    </button>
                    
                    <button class="btn red tooltipped btn-small truncate" onclick="eliminarProducto('<?php echo $row['id']; ?>')" data-position="bottom" data-tooltip="Eliminar" style="padding: 20px 20px; display: inline-flex; align-items: center; justify-content: center;">
                      <i class="fas fa-trash-alt" style="font-size: 12px;"></i>
                    </button>
                  </td>
                </tr>
                <?php } ?>
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
          <div id="editar-popup">
            <div id="editar-popup-overlay"></div>
            <div class="contenido">
              <div class="cerrar">
                <button onclick="cerrarEditarPopup()">X</button>
              </div>
              <h4>EDITAR PRODUCTO</h4>
              <form action="actualizar_producto.php" method="POST">
                <div class="col s12 m6">
                  <label for="editar-codigo">Código:</label>
                  <input type="text" id="editar-codigo" name="codigo" required>
                  <label for="editar-nombre">Nombre:</label>
                  <input type="text" id="editar-nombre" name="nombre" required>
                  <label for="editar-modelo">Modelo:</label>
                  <input type="text" id="editar-modelo" name="modelo" required>
                  <label for="editar-unidad_medida">Unidad de Medida:</label>
                  <input type="text" id="editar-unidad_medida" name="unidad_medida" required>
                  <label for="editar-ubicacion">Ubicación:</label>
                  <input type="text" id="editar-ubicacion" name="ubicacion" required>
                </div>
                <div class="col s12 m6">
                  <label for="editar-minimoStock">Stock mínimo:</label>
                  <input type="number" step="0.01" id="editar-minimoStock" name="minimoStock" required>
                  <label for="editar-cantidad_por_unidad">Cantidad por Unidad:</label>
                  <input type="number" step="0.01" id="editar-cantidad_por_unidad" name="cantidad_por_unidad" required>
                  <label for="editar-precio_compra">Precio de Compra:</label>
                  <input type="number" step="0.01" id="editar-precio_compra" name="precio_compra" required>
                  <label for="editar-precio_venta">Precio de Venta:</label>
                  <input type="number" step="0.01" id="editar-precio_venta" name="precio_venta" required>

                  <!-- Agregar un campo oculto para guardar el ID del producto -->
                  <input type="hidden" id="editar-id" name="id">
                </div>

                <!-- Agregar un botón para enviar el formulario -->
                <div class="col s12">
                  <input type="submit" class="btn-submit" id="btn_almacenar" value="Guardar">
                </div>

              </form>
            </div>
          </div>

          <script>
            const botonesEditar = document.querySelectorAll('.boton-editar');

            botonesEditar.forEach(function(botonEditar) {
              botonEditar.addEventListener('click', function() {
                const editarId = document.querySelector('#editar-id');
                const editarCodigo = document.querySelector('#editar-codigo');
                const editarNombre = document.querySelector('#editar-nombre');
                const editarModelo = document.querySelector('#editar-modelo');
                const editarUnidadMedida = document.querySelector('#editar-unidad_medida');
                const editarUbicacion = document.querySelector('#editar-ubicacion');
                const editarMinimoStock = document.querySelector('#editar-minimoStock');
                const editarCantidadPorUnidad = document.querySelector('#editar-cantidad_por_unidad');
                const editarPrecioCompra = document.querySelector('#editar-precio_compra');
                const editarPrecioVenta = document.querySelector('#editar-precio_venta');

                // Obtener el ID del producto a editar desde el atributo "data-id"
                const idProducto = botonEditar.dataset.id;

                // Hacer una petición AJAX para obtener los datos del producto por su ID
                fetch(`obtener_producto.php?id=${idProducto}`)
                  .then(response => response.json())
                  .then(data => {

                    // Poner los datos del producto en los campos del formulario
                    editarId.value = data.id;
                    editarCodigo.value = data.codigo;
                    editarNombre.value = data.nombre;
                    editarModelo.value = data.modelo;
                    editarUnidadMedida.value = data.unidad_medida;
                    editarUbicacion.value = data.ubicacion;
                    editarMinimoStock.value = data.minimoStock;
                    editarCantidadPorUnidad.value = data.cantidad_por_unidad;
                    editarPrecioCompra.value = data.precio_compra;
                    editarPrecioVenta.value = data.precio_venta;

                    // Mostrar el popup de edición
                    const editarPopup = document.querySelector('#editar-popup');
                    editarPopup.style.display = 'block';
                  })
                  .catch(error => console.error(error));
              });
            });

            function cerrarEditarPopup() {
              const editarPopup = document.querySelector('#editar-popup');
              editarPopup.style.display = 'none';
            }
            function eliminarProducto(id) {
              swal({
                title: '¿Está seguro de que desea eliminar el producto?',
                text: '¡Al eliminarlo no podrá recuperarlo!',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminarlo'
              }).then(function() {
                location.href = 'eliminar_producto.php?id=' + id;
              });
            }
          </script>
        </div>
      </div>
    </div>
  </div>

  <?php include '../extend/scripts.php'; ?>
  <script src="../js/validacion.js"></script>
</body>
</html>

