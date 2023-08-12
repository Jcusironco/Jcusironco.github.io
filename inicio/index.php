
<!DOCTYPE html>
<html lang ="en">
<head>
    <title>Inicio CAR WASH</title>
    <link rel="shortcut icon" type="image/x-icon" href="../img/logis.ico">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<?php include "../extend/header.php"; ?>
</head>
<style>
  /* Estilos comunes */
  body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
  }

  h1 {
    text-align: center;
  }

  nav ul {
    list-style-type: none;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    background-color: #f0f0f0;
  }

  nav ul li {
    margin: 0 10px;
  }

  nav ul li a {
    text-decoration: none;
    color: #333;
    padding: 5px 10px;
    border-radius: 5px;
  }

  .contenedor {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    flex-direction: column;
  }

  .widget {
    background-color: #f0f0f0;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    display: flex;
    flex-direction: column;
    align-items: center;
  }

  .fecha p {
    margin: 0;
  }

  .reloj {
    display: flex;
    align-items: center;
    font-size: 24px;
    margin-top: 10px;
  }

  .reloj p {
    margin: 0 5px;
  }

  .cajaSegundos {
    display: flex;
    align-items: baseline;
  }

  /* Estilos para el modo oscuro */
  body.dark-mode {
    background-color: #333;
    color: #fff;
  }

  body.dark-mode h1 {
    color: #fff;
  }

  body.dark-mode nav ul {
    background-color: #333;
  }

  body.dark-mode nav ul li a {
    color: #fff;
  }

  body.dark-mode .widget {
    background-color: #333;
    box-shadow: 0 0 10px rgba(255, 255, 255, 0.1);
  }

  body.dark-mode .widget .fecha p {
    color: #fff;
  }

  body.dark-mode .widget .reloj p {
    color: #fff;
  }

  body.dark-mode .widget .cajaSegundos p {
    color: #fff;
  }
</style>

<body>
  <h1><center>Bienvenido</center></h1>
  <nav>
    <ul>
  <li><a href="../inicio"><i class="material-icons">home</i>Inicio</a></li>
  <li><a href="../usuarios"><i class="material-icons">person</i>Usuarios</a></li>
  <li><a href="../inventario"><i class="material-icons">storage</i>Inventario</a></li>
  <li><a href="../compra"><i class="material-icons">shopping_cart</i>Compras</a></li>
  <li><a href="../devolucion"><i class="material-icons">arrow_back</i>Devolución</a></li>
  <li><a href="../venta"><i class="material-icons">shopping_basket</i>Venta</a></li>
  <li><a href="../caja"><i class="material-icons">attach_money</i>Caja</a></li>
  <li><a href="../dashboard"><i class="material-icons">dashboard</i>Dashboard</a></li>
  <li><a href="../login/salir.php"><i class="material-icons">power_settings_new</i>Salir</a></li>
    </ul>
  </nav>

<?php include '../extend/scripts.php'; ?>
<script src="../js/validacion.js"></script>
</body>
</html>
