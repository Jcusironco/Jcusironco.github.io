<!DOCTYPE html>
<html lang="en">
<head>
  <title>Ventas CAR WASH</title>
  <link rel="shortcut icon" type="image/x-icon" href="../img/logis.ico">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,600|Open+Sans" rel="stylesheet">
  <?php
include '../extend/header.php';
//include '../extend/permiso.php';
?>

</head>
<style>
  /* Estilos generales */
  body {
    font-family: Arial, sans-serif;
  }

  .row {
    margin-bottom: 10px;
  }

  .contenedor {
    padding: 10px;
  }

  .card {
    background-color: #fff;
    color: #000;
    padding: 10px;
  }

  .contenedor-inputs {
    margin-bottom: 10px;
  }

  .input-field {
    width: 100%;
    margin-bottom: 10px;
  }

  input[type="text"],
  select {
    width: 100%;
    padding: 5px;
    border: 1px solid #ccc;
    border-radius: 5px;
  }

  button {
    padding: 5px 10px;
    background-color: #333;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
  }

  /* Estilos de la tabla */
  table {
    width: 100%;
    border-collapse: collapse;
  }

  th,
  td {
    padding: 8px;
    border: 1px solid #ccc;
  }

  th {
    background-color: #333;
    color: #fff;
    text-align: left;
  }

  /* Estilos específicos para la tabla de servicios */
  #tablaServicio {
    margin-bottom: 10px;
  }

  /* Estilos del resumen */
  #tablaResumen {
    margin-top: 20px;
  }

  #tablaResumen tr td {
    padding: 5px;
    text-align: right;
  }

  .error-message {
    color: red;
    font-size: 12px;
    margin-left: 5px;
  }

  /* Estilos del campo de búsqueda */
  #busqueda {
    width: 100%;
    padding: 8px;
    font-size: 14px;
    border: 1px solid #ccc;
    border-radius: 4px;
  }

  /* Estilos de los resultados de búsqueda */
  #resultados {
    position: absolute;
    z-index: 999;
    width: 98%;
    max-height: 200px;
    overflow-y: auto;
    background-color: #fff;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    padding: 4px;
    color: #000;
  }

  #resultados .item:hover {
    background-color: #ccc;
  }

  /* Modo oscuro */
  body.dark-mode {
    background-color: #333;
    color: #fff;
  }

  body.dark-mode .card {
    background-color: #000;
    color: #fff;
  }

  body.dark-mode th {
    background-color: #000;
  }

  body.dark-mode #resultados {
    background-color: #000;
    color: #fff;
  }

  body.dark-mode #resultados .item:hover {
    background-color: #666;
  }
</style>
<body>
  <div class="row">
    <div class="col s12">
      <div class="card">
        <form id="tipoPagoForm" action="generar_pdf.php" method="POST" class="" enctype="multipart/form-data"
          autocomplete="off">
          <div class="contenedor-inputs">
            <div class="input-field col s6">
              <label for="nombres"></label>
              <input type="text" placeholder="Nombre" id="nombres" name="nombres" required>
            </div>
          </div>

          <div class="contenedor-inputs">
            <div class="input-field col s6">
              <?php
              $conexion = mysqli_connect("localhost", "root", "", "almacen");
              if (!$conexion) {
                die("Connection failed: " . mysqli_connect_error());
              }
              $sel = mysqli_query($conexion, "SELECT codigo, nombre, unidad_medida, precio_venta FROM productos");
              ?>
              <select name="productos" id="productos" required>
                <?php while ($f_productos = mysqli_fetch_assoc($sel)) { ?>
                  <option value="<?php echo $f_productos['codigo']; ?>"><?php echo $f_productos['nombre'] . ' ' . $f_productos['unidad_medida'] . ' ' . $f_productos['precio_venta']; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>

          <div class="contenedor-inputs">
            <div class="input-field col s6">
              <button type="button" onclick="agregarSeleccion()">Agregar Selección</button>
            </div>
          </div>

          <div class="row">
            <div class="col s12">
              <div style="max-height: 300px; overflow-y: auto;">
                <table id="tablaServicio">
                  <thead>
                    <tr>
                      <th>Codigo</th>
                      <th>Descripción</th>
                      <th>U.M</th>
                      <th>Precio</th>
                      <th>Cantidad</th>
                      <th>Total</th>
                      <th>Acciones</th>
                    </tr>
                  </thead>
                  <tbody id="tablaBody">
                    <!-- Elements selected will be added here -->
                  </tbody>
                </table>
              </div>

              <div>
                <table id="tablaResumen">
                  <tr>
                    <td colspan="2" style="text-align: right;"><strong>Subtotal:</strong></td>
                    <td><span id="subtotal">0.00</span></td>
                    <input type="hidden" name="subtotalActualizado" id="subtotalActualizado" value="">
                  </tr>
                  <tr>
                    <td colspan="2" style="text-align: right;"><strong>IGV:</strong></td>
                    <td><span id="igv">0.00</span></td>
                    <input type="hidden" name="igvActualizado" id="igvActualizado" value="">
                  </tr>
                  <tr>
                    <td colspan="2" style="text-align: right;"><strong>Total General:</strong></td>
                    <td><span id="totalGeneral">0.00</span></td>
                  </tr>
                  <input type="hidden" name="totalGeneralActualizado" id="totalGeneralActualizado" value="">
                  <tr>
                    <td colspan="2">
                      <div class="input-field col s2">
                        <select id="tipoPago" name="tipoPago">
                          <option value="" disabled></option>
                          <option value="efectivo" selected>Efectivo</option>
                        </select>
                        <label for="tipoPago"></label>
                        <span class="error-message"></span>
                      </div>
                      <div class="input-field col s2">
                        <select id="FormaPago" name="FormaPago">
                          <option value="" disabled></option>
                          <option value="Soles" selected>Soles</option>
                        </select>
                        <label for="FormaPago"></label>
                        <span class="error-message"></span>
                      </div>
                    </td>
                    <input type="hidden" name="filasTabla" id="filasTabla" value="">
                    <td>
                      <button type="submit" id="emitirBtn" onclick="actualizarFilasTabla()">Emitir</button>
                    </td>
                  </tr>
                </table>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  <script>
var filasTabla = [];

function agregarSeleccion() {
  var servicioSelect = document.getElementById('productos');
  var codigo = servicioSelect.value;
  var descripcion = servicioSelect.options[servicioSelect.selectedIndex].text.split(' ').slice(0, -2).join(' ');
  var unidadMedida = servicioSelect.options[servicioSelect.selectedIndex].text.split(' ').slice(-2, -1).join(' ');
  var precio = parseFloat(servicioSelect.options[servicioSelect.selectedIndex].text.split(' ').slice(-1));
  var cantidad = 1;
  var total = precio * cantidad;

  var tablaBody = document.getElementById('tablaBody');
  var newRow = tablaBody.insertRow();

  var filaData = {
    codigo: codigo,
    descripcion: descripcion,
    unidadMedida: unidadMedida,
    precio: precio,
    cantidad: cantidad,
    total: total
  };

  // Agregar los datos al array de filas
  filasTabla.push(filaData);

  // Convertir el array de filas a una cadena JSON
  var filasTablaJson = JSON.stringify(filasTabla);

  // Actualizar el campo oculto del formulario
  document.getElementById('filasTabla').value = filasTablaJson;

  var codigoCell = newRow.insertCell(0);
  codigoCell.innerHTML = codigo;

  var descripcionCell = newRow.insertCell(1);
  descripcionCell.innerHTML = descripcion;

  var unidadMedidaCell = newRow.insertCell(2);
  unidadMedidaCell.innerHTML = unidadMedida;

  var precioCell = newRow.insertCell(3);
  precioCell.innerHTML = precio;

  var cantidadCell = newRow.insertCell(4);
  cantidadCell.innerHTML = '<input type="number" value="' + cantidad + '" onchange="actualizarCantidad(this)">';

  var totalCell = newRow.insertCell(5);
  totalCell.innerHTML = total.toFixed(2);

  var eliminarCell = newRow.insertCell(6);
  eliminarCell.innerHTML = '<button type="button" onclick="eliminarItem(this)">Quitar</button>';

  actualizarTotales();

  // Restablecer el valor del campo de productos
  servicioSelect.selectedIndex = 0;

  if (tablaBody.getElementsByTagName('tr').length > 3) {
    tablaBody.style.overflowY = 'scroll';
    tablaBody.style.maxHeight = '300px';
  }
}

function eliminarItem(button) {
  var fila = button.parentNode.parentNode;
  var filaIndex = fila.rowIndex - 1;
  fila.parentNode.removeChild(fila);

  // Eliminar la fila del array de filas
  filasTabla.splice(filaIndex, 1);

  // Convertir el array de filas a una cadena JSON
  var filasTablaJson = JSON.stringify(filasTabla);

  // Actualizar el campo oculto del formulario
  document.getElementById('filasTabla').value = filasTablaJson;

  var tablaBody = document.getElementById('tablaBody');
  if (tablaBody.getElementsByTagName('tr').length <= 3) {
    tablaBody.style.overflowY = 'initial';
    tablaBody.style.maxHeight = 'none';
  }

  actualizarTotales();
}

function actualizarCantidad(input) {
  var cantidad = parseInt(input.value);
  if (isNaN(cantidad) || cantidad <= 0) {
    cantidad = 1;
    input.value = cantidad;
  }

  var fila = input.parentNode.parentNode;
  var filaIndex = fila.rowIndex - 1;

  // Actualizar la cantidad y el total en el objeto filaData correspondiente
  filasTabla[filaIndex].cantidad = cantidad;
  filasTabla[filaIndex].total = filasTabla[filaIndex].precio * cantidad;

  var precioCell = fila.cells[3];
  var totalCell = fila.cells[5];

  var total = filasTabla[filaIndex].total;

  totalCell.innerHTML = total.toFixed(2);

  actualizarTotales();
}

function actualizarTotales() {
  var tablaBody = document.getElementById('tablaBody');
  var filas = tablaBody.getElementsByTagName('tr');

  var subtotal = 0;
  for (var i = 0; i < filas.length; i++) {
    var fila = filas[i];
    var totalCell = fila.cells[5];
    subtotal += parseFloat(totalCell.innerHTML);
  }

  var igv = subtotal * 0.18;
  var totalGeneral = subtotal + igv;

  document.getElementById('subtotal').innerHTML = subtotal.toFixed(2);
  document.getElementById('igv').innerHTML = igv.toFixed(2);
  document.getElementById('totalGeneral').innerHTML = totalGeneral.toFixed(2);

  // Actualizar los campos ocultos
  document.getElementById('subtotalActualizado').value = subtotal.toFixed(2);
  document.getElementById('igvActualizado').value = igv.toFixed(2);
  document.getElementById('totalGeneralActualizado').value = totalGeneral.toFixed(2);

  // Habilitar o deshabilitar el botón "Emitir" según el número de filas
  var emitirBtn = document.getElementById('emitirBtn');
  if (filas.length > 0) {
    emitirBtn.disabled = false;
  } else {
    emitirBtn.disabled = true;
  }
}

function actualizarFilasTabla() {
  var filasTablaJson = JSON.stringify(filasTabla);
  document.getElementById('filasTabla').value = filasTablaJson;
}
  </script>
<?php include '../extend/scripts.php'; ?>
<script src="../js/validacion.js"></script>
</body>
</html>
