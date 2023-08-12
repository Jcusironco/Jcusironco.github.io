
var filasTabla = [];

function agregarSeleccion() {
  var servicioSelect = document.getElementsByName('servicio')[0];
  var descripcion = servicioSelect.options[servicioSelect.selectedIndex].text;
  var precio = parseFloat(servicioSelect.value);
  var cantidad = 1;
  var total = precio * cantidad;

  var tablaBody = document.getElementById('tablaBody');
  var newRow = tablaBody.insertRow();

  var filaData = {
    descripcion: descripcion,
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

  var descripcionCell = newRow.insertCell(0);
  descripcionCell.innerHTML = descripcion;

  var precioCell = newRow.insertCell(1);
  precioCell.innerHTML = precio;

  var cantidadCell = newRow.insertCell(2);
  cantidadCell.innerHTML = '<input type="number" value="' + cantidad + '" onchange="actualizarCantidad(this)">';

  var totalCell = newRow.insertCell(3);
  totalCell.innerHTML = total.toFixed(2);

  var eliminarCell = newRow.insertCell(4);
  eliminarCell.innerHTML = '<button type="button" onclick="eliminarItem(this)">Quitar</button>';

  actualizarTotales();

  // Restablecer el valor del campo de cantidad
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

  var precioCell = fila.cells[1];
  var totalCell = fila.cells[3];

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
    var totalCell = fila.cells[3];
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


















const form = document.getElementById('consultaForm');
const tipoInput = document.getElementById('tipo');
const numeroInput = document.getElementById('numero');
const numeroResultadoInput = document.getElementById('numeroResultado');
const nombresInput = document.getElementById('nombres');
const direccionInput = document.getElementById('direccion');
const correoInput = document.getElementById('correo');

form.addEventListener('submit', function (event) {
  event.preventDefault(); // Evitar envío del formulario

  const tipo = tipoInput.value;
  const numero = numeroInput.value;

  let apiUrl = '';
  if (tipo === 'dni') {
    apiUrl = `https://dniruc.apisperu.com/api/v1/dni/${numero}?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6ImpjdXNpcm9uY29AZ21haWwuY29tIn0.g0M_RI5u99KKb_q5WgO39Ir_S2RcRTlD_AGfv6QNDX0`;
  } else if (tipo === 'ruc') {
    apiUrl = `https://dniruc.apisperu.com/api/v1/ruc/${numero}?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6ImpjdXNpcm9uY29AZ21haWwuY29tIn0.g0M_RI5u99KKb_q5WgO39Ir_S2RcRTlD_AGfv6QNDX0`;
  } else {
    console.log('Tipo de documento no válido');
    return;
  }

  fetch(apiUrl)
    .then(response => response.json())
    .then(data => {
      if (tipo === 'dni') {
        numeroResultadoInput.value = numero;
        nombresInput.value = `${data.nombres} ${data.apellidoPaterno} ${data.apellidoMaterno}` || '';
        direccionInput.value = data.direccion || 'car-Ns';
        correoInput.value = data.correo || 'car@gmail.com';
      } else if (tipo === 'ruc') {
        numeroResultadoInput.value = numero;
        nombresInput.value = data.razonSocial || '';
        direccionInput.value = data.direccion || '';
        correoInput.value = data.correo || 'car@gmail.com';
      }
    })
    .catch(error => {
      console.log(error);
    });
});

