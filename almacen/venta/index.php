<!DOCTYPE html>
<html lang="en">
<head>
  <title>Ventas MARCELO MOTORS</title>
  <link rel="shortcut icon" type="image/x-icon" href="../img/logis.ico">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,600|Open+Sans" rel="stylesheet">
  <?php
include '../extend/header.php';
//include '../extend/permiso.php';
?>

</head>
<head>
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
      color: #333;
      padding: 10px;
      border-radius: 5px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
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
      padding: 8px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }

    button {
      padding: 8px 12px;
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
  </style>
<body>
  <div class="row">
    <div class="col s12">
      <div class="card">
        <div class="card-content blue lighten-2">
          <center><span class="card-title">VENTAS</span></center>
        </div>
      </div>
    <div class="card">
      <form id="tipoPagoForm" action="generar_pdf.php" method="POST" class="" enctype="multipart/form-data" autocomplete="off">
        <div class="card-content">
          <div class="row">
            <div class="input-field col s6">
              <label for="nombres"></label>
              <input type="text" placeholder="Ingrese el nombre del cliente" id="nombres" name="nombres" required>
            </div>
            <div class="input-field col s6" style="position: relative;">
              <div style="width: 180px; height: 70px; position: absolute; top:0; right: 0; border: 1px solid #ccc; border-radius: 0px; overflow: hidden;">
                <?php
                  date_default_timezone_set('America/Lima');
                  $fechaHoraActual = date('Y-m-d\TH:i');
                ?>
                <input type="datetime-local" id="fechaHora" name="fechaHora" value="<?php echo $fechaHoraActual; ?>" readonly style="width: 100%; height: 100% ; border: none; padding: 2px;">
              </div>
            </div>
          </div>

          <input type="hidden" id="productoId" name="productoId" value="">
          <div class="row">
            <div class="input-field col s6">
              <label for="producto"></label>
              <input list="productos-list" placeholder="Busque el producto" id="producto" name="producto" oninput="showOptions()">
              <datalist id="productos-list">
                <?php
                $conexion = mysqli_connect("localhost", "root", "", "almacen");
                if (!$conexion) {
                  die("Connection failed: " . mysqli_connect_error());
                }
                $sel = mysqli_query($conexion, "SELECT id, codigo, nombre, unidad_medida, precio_venta FROM productos");
                while ($f_productos = mysqli_fetch_assoc($sel)) {
                  echo '<option value="' . $f_productos['id'] . ' ' . $f_productos['codigo'] . ' ' . $f_productos['nombre'] . ' ' . $f_productos['unidad_medida'] . ' ' . $f_productos['precio_venta'] . '">' . $f_productos['codigo'] . '</option>';
                }
                ?>
              </datalist>
            </div>
            <div class="input-field col s6">
              <button type="button" onclick="agregarFila()">Agregar fila</button>
            </div>
          </div>
          <div class="row">
            <div class="col s12">
              <div style="max-height: 300px; overflow-y: auto;">
                <table id="tablaServicio">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Código</th>
                      <th>Nombre</th>
                      <th>Unidad Medida</th>
                      <th>Precio</th>
                      <th>Cantidad</th>
                      <th>Total</th>
                      <th>Acciones</th>
                    </tr>
                  </thead>
                  <tbody id="tablaBody">

                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div>
            <table id="tablaResumen">
              <tr>
                <td colspan="2" style="text-align: right;"><strong>Subtotal:</strong></td>
                <td><span id="subtotal">0.00</span></td>
                <input type="hidden" name="subtotalActualizado" id="subtotalActualizado" value="">
              </tr>
              <tr>
                <input type="hidden" name="filasTabla" id="filasTabla" value="">
                <td>
                  <button type="submit" id="emitirBtn" onclick="actualizarFilasTabla()">Emitir</button>
                </td>
              </tr>
            </table>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<script>
  function agregarFila() {
    // Obtener el valor seleccionado del input producto
    var productoInput = document.getElementById("producto");
    var productoSeleccionado = productoInput.value;

    // Verificar si se ha seleccionado un producto
    if (productoSeleccionado.trim() === "") {
      alert("Debe buscar y seleccionar un producto antes de agregar una fila.");
      return;
    }

    // Obtener los valores de código, nombre, unidad de medida y precio
    var id = productoSeleccionado.split(" ")[0];
    var codigo = productoSeleccionado.split(" ")[1];
    var nombre = productoSeleccionado.split(" ").slice(2).join(" ");
    var unidadMedida = productoSeleccionado.split(" ")[productoSeleccionado.split(" ").length - 2];
    var precio = parseFloat(productoSeleccionado.split(" ")[productoSeleccionado.split(" ").length - 1]);

    // Set the value of the hidden input field
    document.getElementById("productoId").value = id;

    // Crear una nueva fila en la tabla
    var tablaBody = document.getElementById("tablaBody");
    var fila = tablaBody.insertRow();

    // Insertar celdas en la fila
    var celdaId = fila.insertCell();
    var celdaCodigo = fila.insertCell();
    var celdaNombre = fila.insertCell();
    var celdaUM = fila.insertCell();
    var celdaPrecio = fila.insertCell();
    var celdaCantidad = fila.insertCell();
    var celdaTotal = fila.insertCell();
    var celdaAcciones = fila.insertCell();

    // Establecer el contenido de las celdas
    celdaId.innerHTML = id;
    celdaCodigo.innerHTML = codigo;
    celdaNombre.innerHTML = nombre;
    celdaUM.innerHTML = unidadMedida;
    celdaPrecio.innerHTML = '<input type="number" min="0" step="0.01" value="' + precio.toFixed(2) + '" onchange="calcularTotal(this.parentNode.parentNode)">';
    celdaCantidad.innerHTML = '<input type="number" min="0" value="1" onchange="calcularTotal(this.parentNode.parentNode)">';
    celdaTotal.innerHTML = precio.toFixed(2);
    celdaAcciones.innerHTML = '<button onclick="eliminarFila(this.parentNode.parentNode)">Eliminar</button>';

    // Limpiar el valor del input producto
    productoInput.value = "";

    // Calcular el subtotal
    calcularSubtotal();
  }

  function calcularTotal(fila) {
    var cantidadInput = fila.cells[5].getElementsByTagName("input")[0];
    var precioInput = fila.cells[4].getElementsByTagName("input")[0];

    var cantidad = parseFloat(cantidadInput.value);
    var precio = parseFloat(precioInput.value);
    var total = cantidad * precio;

    fila.cells[6].innerHTML = total.toFixed(2);

    // Calcular el subtotal
    calcularSubtotal();
  }

  function eliminarFila(fila) {
    var tablaBody = document.getElementById("tablaBody");
    tablaBody.removeChild(fila);

    // Calcular el subtotal
    calcularSubtotal();
  }

  function calcularSubtotal() {
    var subtotal = 0.00;
    var tablaBody = document.getElementById("tablaBody");
    var filas = tablaBody.rows;
    for (var i = 0; i < filas.length; i++) {
      var filaActual = filas[i];
      var totalFila = parseFloat(filaActual.cells[6].innerHTML);
      subtotal += totalFila;
    }

    var subtotalElement = document.getElementById("subtotal");
    subtotalElement.innerHTML = subtotal.toFixed(2);
  }

  function actualizarFilasTabla() {
    // Calcular el subtotal
    calcularSubtotal();
    // Crear un array para almacenar las filas
    var filasTabla = [];

    // Obtener la tabla
    var tablaBody = document.getElementById("tablaBody");

    // Recorrer todas las filas de la tabla
    for (var i = 0; i < tablaBody.rows.length; i++) {
      var fila = tablaBody.rows[i];

      // Obtener los valores de la fila
      var id = fila.cells[0].innerText;
      var codigo = fila.cells[1].innerText;
      var nombre = fila.cells[2].innerText;
      var unidadMedida = fila.cells[3].innerText;
      var precio = parseFloat(fila.cells[4].getElementsByTagName("input")[0].value);
      var cantidad = parseFloat(fila.cells[5].getElementsByTagName("input")[0].value);
      var total = parseFloat(fila.cells[6].innerText);

      // Crear un objeto con los datos de la fila
      var filaTabla = {
        id: id,
        codigo: codigo,
        nombre: nombre,
        unidadMedida: unidadMedida,
        precio: precio,
        cantidad: cantidad,
        total: total
      };

      // Agregar la fila al array
      filasTabla.push(filaTabla);
    }

    // Convertir el array en una cadena JSON para enviarlo en el formulario
    var filasTablaJSON = JSON.stringify(filasTabla);

    // Asignar el valor al campo oculto
    document.getElementById("filasTabla").value = filasTablaJSON;
  }
</script>

<?php include '../extend/scripts.php'; ?>
<script src="../js/validacion.js"></script>
</body>
</html>
