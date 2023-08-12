<!DOCTYPE html>
<html lang="en">
<head>
  <title>Usuarios MARCELO MOTORS</title>
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
  max-height: 1000px; /* Ajusta la altura máxima según tus necesidades */
  overflow-y: auto; /* Agrega una barra de desplazamiento vertical cuando sea necesario */
}

</style>
<body>
  <div class="row">
    <div class="col s12">
      <div class="card">
        <div class="card-content blue lighten-2" style="background-color: blue; color: black;">
           <center><span class="card-title1">REGISTRO DE USUARIOS</span></center>
        </div>
      </div>
      <div class="card">
        <div class="card-content">
          <div class="contenedor">
            <article>
              <button id="btn-abrir-popup" class="btn-abrir-popup blue">+ Nuevo</button>
            </article>
            <div class="overlay" id="overlay">
              <div class="popup" id="popup">
                <a href="#" id="btn-cerrar-popup" class="btn-cerrar-popup"><i class="fas fa-times"></i></a>
                <h3>REGISTRO DE USUARIOS</h3>
                <h4>Rellene los datos</h4>
                <form action="ins_usuarios.php" method="post" enctype="multipart/form-data" autocomplete="off" class="registro-form">
                  <div class="contenedor-inputs">
                    <input type="text" placeholder="Nick" name="nick" required autofocus pattern="[A-Za-z]{8,15}" id="nick" onblur="may(this.value, this.id)">
                    <label for="nick"></label>
                  </div>
                  <div class="validacion"></div>
                  <div class="contenedor-inputs">
                    <input type="password" placeholder="Contraseña" name="pass1" pattern="[A-Za-z0-9]{8,15}" id="pass1" required>
                    <label for="pass1"></label>
                  </div>
                  <div class="contenedor-inputs">
                    <input type="password" placeholder="Verificar contraseña" pattern="[A-Za-z0-9]{8,15}" id="pass2" required>
                    <label for="pass2"></label>
                  </div>
                  <div class="contenedor-inputs">
                    <input type="text" placeholder="Nombre completo del usuario" name="nombre" id="nombre" onblur="may(this.value, this.id)" required pattern="[A-Z/s ]+">
                    <label for="nombre"></label>
                  </div>
                  <div class="contenedor-inputs">
                    <input type="email" placeholder="Correo electrónico" name="correo" id="correo">
                    <label for="correo"></label>
                  </div>
                  <div class="contenedor-inputs">
                    <input type="tel" name="telefono" placeholder="Teléfono" id="telefono" required>
                    <label for="telefono"></label>
                  </div>
                  <div class="contenedor-inputs">
                    <div class="file-field input-field">
                      <div class="btn">
                        <span>Foto:</span>
                        <input type="file" name="foto">
                      </div>
                      <div class="file-path-wrapper">
                        <input class="file-path validate" type="text">
                      </div>
                    </div>
                  </div>
                  <div class="contenedor-inputs">
                    <label for="nivel"></label>
                    <select name="nivel" required>
                      <option value="" disabled selected>ELIGE UN NIVEL DE USUARIO</option>
                      <option value="ADMINISTRADOR">ADMINISTRADOR</option>
                      <option value="EMPLEADO">EMPLEADO</option>
                    </select>
                  </div>
                  <input type="submit" class="btn-submit" id="btn_almacenar" value="Guardar">
                </form>
              </div>
            </div>
          </div>
          <script src="../js/popup.js"></script>
        </div>
        <?php
        // Establecer el número de registros por página
        $registros_por_pagina = 6;

        // Obtener el número total de registros
        $total_registros = mysqli_num_rows($con->query("SELECT * FROM usuario"));

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

        // Consultar los registros de la página actual
        $sel = $con->query("SELECT * FROM usuario LIMIT $registro_inicial, $registros_por_pagina");
        $num_rows = mysqli_num_rows($sel);
        ?>

        <div class="card-content">
          <span class="card-title">Usuarios (<?php echo $total_registros ?>)</span>
          <table>
            <thead>
              <th>Nick</th>
              <th>Nombre</th>
              <th>Correo</th>
              <th>Teléfono</th>
              <th>Nivel</th>
              <th>Foto</th>
              <th>Bloqueo</th>
              <th>Eliminar</th>
            </thead>
            <tbody>
              <?php
              $counter = 0;
              while ($f = $sel->fetch_assoc()) {
                $counter++;
              ?>
                <tr>
                  <td><?php echo $f['nick'] ?></td>
                  <td><?php echo $f['nombre'] ?></td>
                  <td><?php echo $f['correo'] ?></td>
                  <td><?php echo $f['tel'] ?></td>
                  <td>
                    <form action="up_nivel.php" method="post" style="width: 135px;">
                      <input type="hidden" name="id" value="<?php echo $f['id']; ?>">
                      <input type="hidden" name="nivel" value="<?php echo $f['nivel']; ?>">
                      <button type="submit" class="role-button tooltipped" style="background-color: <?php echo ($f['nivel'] === 'ADMINISTRADOR') ? '#4285F4' : '#34A853'; ?>;
                              color: white; padding: 8px 12px; border: none; border-radius: 4px; font-size: 14px; cursor: pointer;"
                              data-position="bottom" data-tooltip="Haz clic aquí para cambiar de nivel">
                        <?php echo ($f['nivel'] === 'ADMINISTRADOR') ? 'ADMINISTRADOR' : 'EMPLEADO'; ?>
                      </button>
                    </form>
                  </td>
                  <td><img src="<?php echo $f['foto'] ?>" width="50" class="circle"></td>
                  <td>
                    <?php if ($f['bloqueo'] == 1): ?>
                      <a href="bloqueo_manual.php?us=<?php echo $f['id'] ?>&bl=<?php echo $f['bloqueo'] ?>" class="btn-floating green tooltipped" data-position="bottom" data-tooltip="Desbloquear"><i class="material-icons">lock_open</i></a>
                    <?php else: ?>
                      <a href="bloqueo_manual.php?us=<?php echo $f['id'] ?>&bl=<?php echo $f['bloqueo'] ?>" class="btn-floating red tooltipped" data-position="bottom" data-tooltip="Bloquear"><i class="material-icons">lock_outline</i></a>
                    <?php endif; ?>
                  </td>
                  <td>
                    <a href="#" class="btn-floating red tooltipped" onclick="swal({ title: '¿Está seguro de que desea eliminar al usuario?', text: '¡Al eliminarlo no podrá recuperarlo!', type: 'warning', showCancelButton: true, confirmButtonColor: '#3085d6', cancelButtonColor: '#d33', confirmButtonText: 'Sí, eliminarlo' }).then(function () { location.href='eliminar_usuario.php?id=<?php echo $f['id'] ?>'; })" data-position="bottom" data-tooltip="Eliminar"><i class="material-icons">clear</i></a>
                  </td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        <div style="text-align: center; margin-top: -20px;">
          <?php if ($page > 1): ?>
            <a href="?page=<?php echo $page - 1; ?>" class="btn" style="width: 10px;">&lt;</a>
          <?php endif; ?>

          <?php if ($total_paginas > 1): ?>
            <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
              <?php if ($i == $page): ?>
                <a href="?page=<?php echo $i; ?>" class="btn active" style="width: 10px;"><?php echo $i; ?></a>
              <?php endif; ?>
            <?php endfor; ?>
            <a href="?page=<?php echo $total_paginas; ?>" class="btn active" style="width: 10px;"><?php echo $total_paginas; ?></a>
          <?php endif; ?>

          <?php if ($page < $total_paginas): ?>
            <a href="?page=<?php echo $page + 1; ?>" class="btn" style="width: 10px;">&gt;</a>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>

  <?php include '../extend/scripts.php'; ?>
  <script src="../js/validacion.js"></script>
</body>
</html>