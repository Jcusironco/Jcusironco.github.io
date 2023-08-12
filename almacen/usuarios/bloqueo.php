<?php
include '../conexion/conexion.php';
include '../extend/permiso.php';
$user = $_SESSION['nick'];

$up = $con->query("UPDATE usuario SET bloqueo=0 WHERE nick='$user'");
if ($up) {
    session_start();
    $_SESSION = array();
    session_destroy();
    header('location:../extend/alerta.php?msj=USO INDEBIDO DEL SISTEMA&c=salir&p=salir&t=error');
    exit;
} else {
    header('location:../extend/alerta.php?msj=Error al desbloquear el usuario&c=salir&p=salir&t=error');
    exit;
}
$con->close();
?>
