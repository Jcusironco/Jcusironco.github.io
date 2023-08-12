<!DOCTYPE html>
<html>

<head>
  <title>Boleta Electrónica</title>
  <style>
    body {
      font-family: Arial, sans-serif;
    }

    .container {
      max-width: 600px;
      margin: 0 auto;
      padding: 20px;
    }

    .logo {
      text-align: center;
      margin-bottom: 20px;
    }

    .logo img {
      max-width: 200px;
    }

    .header {
      text-align: center;
      margin-bottom: 20px;
    }

    .header h1 {
      font-size: 24px;
      margin: 0;
    }

    .header p {
      font-size: 16px;
      margin: 5px 0;
    }

    .details {
      margin-bottom: 20px;
    }

    .details p {
      margin: 5px 0;
    }

    .footer {
      text-align: center;
      margin-top: 20px;
    }

    .footer p {
      margin: 5px 0;
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="logo">
      <img src="logo.png" alt="Logo">
    </div>
    <div class="header">
      <h1>Boleta Electrónica</h1>
      <p>Fecha: 21 de mayo de 2023</p>
    </div>
    <div class="details">
      <p>Cliente: John Doe</p>
      <p>Correo electrónico: john.doe@example.com</p>
      <p>Número de boleta: 123456789</p>
    </div>
    <table>
      <thead>
        <tr>
          <th>Descripción</th>
          <th>Cantidad</th>
          <th>Precio unitario</th>
          <th>Total</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Producto 1</td>
          <td>2</td>
          <td>$10.00</td>
          <td>$20.00</td>
        </tr>
        <tr>
          <td>Producto 2</td>
          <td>1</td>
          <td>$15.00</td>
          <td>$15.00</td>
        </tr>
      </tbody>
      <tfoot>
        <tr>
          <td colspan="3">Subtotal</td>
          <td>$35.00</td>
        </tr>
        <tr>
          <td colspan="3">Impuestos</td>
          <td>$5.25</td>
        </tr>
        <tr>
          <td colspan="3">Total</td>
          <td>$40.25</td>
        </tr>
      </tfoot>
    </table>
    <div class="footer">
      <p>Gracias por su compra</p>
    </div>
  </div>
</body>

</html>


prueba 
<body>
  <div class="row">
    <div class="col s12">
      <div class="contenedor">
          <button class="btn-abrir">Sunat</button>
          <div class="overlay">
            <div class="popu">
              <form action="ins_clientes.php" method="post" enctype="multipart/form-data" autocomplete="off" class="registro-form">
                <div class="contenedor-inputs">
                  <label for="tipo"></label>
                  <select id="tipo" name="tipo">
                    <option value="">Seleccione</option>
                    <option value="dni">DNI</option>
                    <option value="ruc">RUC</option>
                  </select>
                  <label for="numero"></label>
                  <input type="text" placeholder="Número" id="numero" name="numero">
                  <input type="submit" class="btn-submit" id="btn_almacenar" value="Guardar"> 
                </div>
              </form>
              <button class="btn-cerrar">Cerrar</button>
            </div>
          </div>
        </div>
        <script src="../js/abrirSunat.js"></script>
      <div class="card dark-mode">

        <form id="tipoPagoForm" action="generar_pdf.php" method="POST" class="" enctype="multipart/form-data" autocomplete="off">
          <div class="contenedor-inputs">
            <div class="input-field col s6">
              <label for="numeroResultado"></label>
              <input type="text" placeholder="Numero" id="numeroResultado" name="numeroResultado" required>
              <input type="hidden" id="tipoDocumento" name="tipoDocumento" value="">
              <input type="hidden" id="telefono" name="telefono" value="">
            </div>
          </div>
          <div class="contenedor-inputs">
            <div class="input-field col s6">
              <label for="nombres"></label>
              <input type="text" placeholder="Nombre" id="nombres" name="nombres" required>
            </div>
          </div>
          <div class="contenedor-inputs">
            <div class="input-field col s6">
              <label for="direccion"></label>
              <input type="text" placeholder="Dirección" id="direccion" name="direccion" required>
            </div>
          </div>
          <div class="contenedor-inputs">
            <div class="input-field col s6">
              <label for="correo"></label>
              <input type="email" placeholder="Correo" id="correo" name="correo">
            </div>
          </div>