<!DOCTYPE html>
<html>
<head>
  <link id="darkModeStylesheet" rel="stylesheet" href="../css/modoOscuro.css">
  <!-- Resto de tus etiquetas <head> -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <style>
    /* Estilos para los iconos */
    .fas.fa-sun {
      color: #FDB813;
    }

    .fas.fa-moon {
      color: #586994;
    }

    /* Estilos para la pastilla deslizante */
    .toggle-container {
      width: 60px;
      height: 34px;
      background-color: #bdbdbd;
      border-radius: 17px;
      position: relative;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .toggle-ball {
      width: 28px;
      height: 28px;
      background-color: #ffffff;
      border-radius: 50%;
      position: absolute;
      transition: transform 0.2s ease;
    }

    .toggle-container.dark-mode {
      background-color: #586994;
    }

    .toggle-container.dark-mode .toggle-ball {
      transform: translateX(26px);
    }
        .side-nav li {
      border-bottom: 1px solid #ddd;
    }
    .side-nav li a i {
      font-size: 24px;
      margin-right: 10px;
    }
     a {
    font-size: 30px;
    font-family: Arial, sans-serif;
    color: #FF0000; /* Código de color en formato hexadecimal */
   }
  </style>
</head>
<body>
  <!-- barra roja -->
  <nav class="purple darken-4">
     <a href="" data-activates="menu" class="button-collpase"><i class="material-icons">menu</i></a>      
  </nav>
  <!-- slidenavar -->
  <ul id="menu" class="side-nav fixed white-text">
  <div style="text-align: center; margin: 0 auto;">
    <li>
      <div class="userView">
        <div style="display: flex; justify-content: center; align-items: center; flex-direction: column;">
          <a href="" style="margin-left: 20px;"><img src="../usuarios/<?php echo $_SESSION['foto'] ?>" class="circle" alt="" style="width: 150px; height: 150px; /*este es para filtro sombreado*/ filter:drop-shadow(10px 8px 6px #ff0055);"></a>
        </div>
        <div style="display: flex; justify-content: center; align-items: center; flex-direction: column; margin-top: 110px;">
          <a href="" style="font-size: 20px;"><?php echo $_SESSION['nombre'] ?></a>
        </div>
      </div>
    </li>
  </div>
  <table>
  </table>
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

  <script>
    const darkModeToggle = document.querySelector('#darkModeToggle');
    const darkModeStylesheet = document.querySelector('#darkModeStylesheet');
    const body = document.body;

    // Check if dark mode preference is saved
    let isDarkMode = localStorage.getItem('darkMode') === 'true';

    // Set initial dark mode based on preference
    if (isDarkMode) {
      enableDarkMode();
    } else {
      disableDarkMode();
    }

    // Toggle dark mode
    darkModeToggle.addEventListener('click', () => {
      if (isDarkMode) {
        disableDarkMode();
      } else {
        enableDarkMode();
      }
    });

    function enableDarkMode() {
      body.classList.add('dark-mode');
      darkModeStylesheet.setAttribute('href', '../css/modoOscuro.css');
      darkModeToggle.classList.add('dark-mode');
      localStorage.setItem('darkMode', 'true');
      isDarkMode = true;
    }

    function disableDarkMode() {
      body.classList.remove('dark-mode');
      darkModeStylesheet.setAttribute('href', '');
      darkModeToggle.classList.remove('dark-mode');
      localStorage.setItem('darkMode', 'false');
      isDarkMode = false;
    }
  </script>
</body>
</html>










