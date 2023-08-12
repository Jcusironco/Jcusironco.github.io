<?php
session_start();
include '../conexion/conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = $con->real_escape_string(htmlentities($_POST['usuario']));
    $pass = $con->real_escape_string(htmlentities($_POST['contra']));
    $candado = '';
    $str_u = strpos($user, $candado);
    $str_p = strpos($pass, $candado);

    if (is_int($str_u)) {
        $user = '';
    } else {
        $usuario = $user;
    }

    if (is_int($str_p)) {
        $pass = '';
    } else {
        $pass2 = sha1($pass);
    }

    if ($user == null && $pass == null) {
        header("location:../extend/alerta.php?msj=El formato no es correcto&c=salir&p=salir&t=error");
    } else {
        $sel = $con->query("SELECT nick,nombre,nivel,correo,foto,pass,bloqueo FROM usuario WHERE nick='$usuario' AND pass='$pass2'");
        $fila = mysqli_num_rows($sel);

        if ($fila == 1) {
            if ($var = $sel->fetch_assoc()) {
                $nick = $var['nick'];
                $contra = $var['pass'];
                $nivel = $var['nivel'];
                $correo = $var['correo'];
                $foto = $var['foto'];
                $nombre = $var['nombre'];
                $bloqueo = $var['bloqueo'];
            }

            if ($bloqueo == 1) {
                /* Validation of session names */
                if ($nick == $usuario && $contra == $pass2 && $nivel == 'ADMINISTRADOR') {
                    $_SESSION['nick'] = $nick;
                    $_SESSION['nombre'] = $nombre;
                    $_SESSION['nivel'] = $nivel;
                    $_SESSION['correo'] = $correo;
                    $_SESSION['foto'] = $foto;
                    header("location:../extend/alerta.php?msj=Bienvenido&c=home&p=home&t=success");
                } elseif ($nick == $usuario && $contra == $pass2 && $nivel == 'EMPLEADO') {
                    $_SESSION['nick'] = $nick;
                    $_SESSION['nombre'] = $nombre;
                    $_SESSION['nivel'] = $nivel;
                    $_SESSION['correo'] = $correo;
                    $_SESSION['foto'] = $foto;
                    header("location:../extend/alerta.php?msj=Bienvenido&c=home&p=home&t=success");
                } else {
                    header("location:../extend/alerta.php?msj=Nombre o contraseña de usuario incorrecta&c=salir&p=salir&t=error");
                }
            } else {
                header("location:../extend/alerta.php?msj=El usuario está bloqueado&c=salir&p=salir&t=error");
            }
        } else {
            header("location:../extend/alerta.php?msj=Nombre o contraseña de usuario incorrecta&c=salir&p=salir&t=error");
        }
    }
} else {
    header("location:../extend/alerta.php?msj=Utiliza el formulario&c=salir&p=salir&t=error");
}
?>
