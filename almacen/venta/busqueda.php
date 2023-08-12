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

