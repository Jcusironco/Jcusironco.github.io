          <label for="ice-cream-choice">Clientes</label>
          <input list="ice-cream-choice-flavors" id="ice-cream-choice" name="ice-cream-choice" oninput="showOptions()">
          <datalist id="ice-cream-choice-flavors">
              <?php
              $conexion = mysqli_connect("localhost", "root", "", "sistemans");
              if (!$conexion) {
                  die("Connection failed: " . mysqli_connect_error());
              }
              $sel = mysqli_query($conexion, "SELECT NumeroIdentificacion, Nombre FROM clientes");
              while ($cliente = mysqli_fetch_assoc($sel)) {
                  ?>
                  <option value="<?php echo $cliente['NumeroIdentificacion'] . ' - ' . $cliente['Nombre']; ?>"></option>
                  <?php
              }
              mysqli_close($conexion);
              ?>
          </datalist>