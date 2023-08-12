<?php include '../extend/header.php';
//include '../extend/permiso.php';
 ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Vehiculo CAR WASH</title>
  <link rel="shortcut icon" type="image/x-icon" href="../img/logis.ico">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,600|Open+Sans" rel="stylesheet">
</head>

<body>
  <div class="row">
    <div class="col s12">
      <div class="card">
        <div class="card-content">
          <div class="row">
            <form id="consultaForm" action="#" method="POST">
              <div class="col s12 m4">
                <div class="contenedor-inputs">
                  <label for="tipo">Tipo:</label>
                  <select id="tipo" name="tipo">
                    <option value="">Seleccione</option>
                    <option value="dni">DNI</option>
                    <option value="ruc">RUC</option>
                  </select>
                </div>
              </div>
              <div class="col s12 m4">
                <label for="numero">Número:</label>
                <input type="text" placeholder="Número" id="numero" name="numero">
              </div>
              <div class="col s12 m4">
                <input type="submit" value="Consultar">
              </div>
            </form>
          </div>
          <div class="row">
            <form id="consultaResultadoForm" action="#" method="POST">
              <div class="col s12 m6">
                <div class="contenedor-inputs">
                  <div class="input-field col s12">
                    <label for="numeroResultado">Número:</label>
                    <input type="text" placeholder="Número" id="numeroResultado" name="numeroResultado">
                  </div>
                </div>
              </div>
              <div class="col s12 m6">
                <div class="contenedor-inputs">
                  <div class="input-field col s12">
                    <label for="nombres">Nombre:</label>
                    <input type="text" placeholder="Nombre" id="nombres" name="nombres">
                  </div>
                </div>
              </div>
            </form>
          </div>
          <div class="row">
            <form id="consultaResultadoForm2" action="#" method="POST">
              <div class="col s12 m6">
                <div class="contenedor-inputs">
                  <div class="input-field col s12">
                    <label for="direccion">Dirección:</label>
                    <input type="text" placeholder="Dirección" id="direccion" name="direccion">
                  </div>
                </div>
              </div>
              <div class="col s12 m6">
                <div class="contenedor-inputs">
                  <div class="input-field col s12">
                    <label for="correo">Correo:</label>
                    <input type="email" placeholder="Correo" id="correo" name="correo">
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
<div class="card-content">
  <div class="row">
    <div class="col s12 m6">
      <form method="POST">
        <p>Aquí puedes buscar los servicios:</p>
        <input type="search" id="buscar" name="search" autocomplete="off" oninput="buscarSugerencias()" onkeydown="seleccionarConEnter(event)">
        <div id="sugerenciasContainer"></div> <!-- Aquí se mostrarán las sugerencias -->
      </form>
    </div>
  </div>
  <div class="row">
    <div class="col s12">
      <table id="tablaServicio">
        <thead>
          <button onclick="agregarSeleccion()">Agregar Selección</button>
          <tr>
            <th>Descripción</th>
            <th>Precio</th>
            <th>Cantidad</th>
            <th>Total</th>
          </tr>
        </thead>
        <tbody>
          <tr id="filaSeleccionada">
            <td><input type="text" id="descripcion" readonly></td>
            <td><input type="text" id="precio" readonly></td>
            <td><input type="number" id="cantidad" oninput="calcularTotal()"></td>
            <td><input type="text" id="total" readonly></td>
          </tr>
        </tbody>
      </table>
      <div>
        <table id="tablaResumen">
          <tr>
            <td colspan="3" style="text-align: right;"><strong>Subtotal:</strong></td>
            <td><span id="subtotal">0.00</span></td>
          </tr>
          <tr>
            <td colspan="3" style="text-align: right;"><strong>IGV:</strong></td>
            <td><span id="igv">0.00</span></td>
          </tr>
          <tr>
            <td colspan="3" style="text-align: right;"><strong>Total General:</strong></td>
            <td><span id="totalGeneral">0.00</span></td>
          </tr>
        </table>
      </div>
    </div>
  </div>
</div>

<script>
function agregarSeleccion() {
  var totalGeneral = 0;
  var tablaServicio = document.getElementById("tablaServicio");
  var descripcion = document.getElementById("descripcion").value;
  var precio = parseFloat(document.getElementById("precio").value);
  var cantidad = parseInt(document.getElementById("cantidad").value);
  var total = precio * cantidad;

  // Crear una nueva fila
  var fila = document.createElement("tr");

  // Agregar las celdas con los valores ingresados
  var celdaDescripcion = document.createElement("td");
  celdaDescripcion.textContent = descripcion;
  fila.appendChild(celdaDescripcion);

  var celdaPrecio = document.createElement("td");
  celdaPrecio.textContent = precio.toFixed(2);
  fila.appendChild(celdaPrecio);

  var celdaCantidad = document.createElement("td");
  celdaCantidad.textContent = cantidad;
  fila.appendChild(celdaCantidad);

  var celdaTotal = document.createElement("td");
  celdaTotal.textContent = total.toFixed(2);
  fila.appendChild(celdaTotal);

  // Agregar la fila a la tabla
  tablaServicio.appendChild(fila);

  // Llamar a la función para recalcular el total general y el IGV
  calcularTotalGeneral();

  // Limpiar los campos de entrada y resaltar la fila seleccionada
  document.getElementById("descripcion").value = "";
  document.getElementById("precio").value = "";
  document.getElementById("cantidad").value = "";
  document.getElementById("total").value = "";
  document.getElementById("filaSeleccionada").style.backgroundColor = "";
}

function calcularTotalGeneral() {
  var subtotal = 0;

  // Obtener todas las filas de la tabla, excepto la primera (encabezados)
  var filas = document.querySelectorAll("#tablaServicio tbody tr:not(:first-child)");

  filas.forEach(function(fila) {
    // Obtener el total de cada fila y sumarlo al subtotal
    var totalFila = parseFloat(fila.querySelector("td:nth-child(4)").textContent);
    subtotal += totalFila;
  });

  var igv = subtotal * 0.18; // Calcular el IGV (18%)
  var totalGeneral = subtotal + igv; // Calcular el total general

  // Mostrar los resultados en la tabla de resumen
  document.getElementById("subtotal").textContent = subtotal.toFixed(2);
  document.getElementById("igv").textContent = igv.toFixed(2);
  document.getElementById("totalGeneral").textContent = totalGeneral.toFixed(2);
}

function buscarSugerencias() {
  var input = document.getElementById("buscar").value;
  var sugerenciasContainer = document.getElementById("sugerenciasContainer");

  // Verificar que el campo de búsqueda no esté vacío
  if (input === "") {
    sugerenciasContainer.innerHTML = "";
    return;
  }

  // Realizar la consulta AJAX para obtener las sugerencias
  var xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      sugerenciasContainer.innerHTML = this.responseText;
    }
  };
  xmlhttp.open("POST", "busqueda.php", true);
  xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xmlhttp.send("input=" + input);
}

function seleccionarSugerencia(sugerencia) {
  var datos = sugerencia.split(" - ");
  document.getElementById("descripcion").value = datos[0]; // Descripción
  document.getElementById("precio").value = datos[1].replace("Precio: $", ""); // Precio
  document.getElementById("cantidad").value = "1"; // Cantidad por defecto

  calcularTotal(); // Calcular el total automáticamente

  // Resaltar la fila seleccionada
  document.getElementById("filaSeleccionada").style.backgroundColor = "#f0f0f0";
}

function calcularTotal() {
  var precio = parseFloat(document.getElementById("precio").value);
  var cantidad = parseInt(document.getElementById("cantidad").value);
  var total = precio * cantidad;

  // Actualizar el campo de total
  document.getElementById("total").value = total.toFixed(2); // Asegurarse de que el total tenga 2 decimales
}
</script>

  <script src="../js/rucDni.js"></script>
  <?php include '../extend/scripts.php'; ?>
  <script src="../js/validacion.js"></script>
</body>
</html>
<?php
$conexion = mysqli_connect("localhost", "root", "", "sistemans");
if (!$conexion) {
  die("Connection failed: " . mysqli_connect_error());
}

$input = $_POST["input"];
$query = "SELECT Descripcion, Precio FROM servicios WHERE Descripcion LIKE '%$input%'";

$resultado = mysqli_query($conexion, $query);

// Mostrar las sugerencias encontradas
if (mysqli_num_rows($resultado) > 0) {
  while ($fila = mysqli_fetch_assoc($resultado)) {
    echo "<div onclick='seleccionarSugerencia(\"" . $fila["Descripcion"] . " - " . $fila["Precio"] . "\")'>" . $fila["Descripcion"] . " - " . $fila["Precio"] . "</div>";
  }
} else {
  echo "No se encontraron sugerencias.";
}
?>

