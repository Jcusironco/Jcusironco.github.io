<?php
if ($_SESSION['nivel'] != 'ADMINISTRADOR') {
    header("location:bloqueo.php");
    exit();
}

if ($_SESSION['bloqueo'] == 1) {
    // User is blocked
    echo "Tu usuario está bloqueado. No tienes acceso.";
    exit();
}
?>
