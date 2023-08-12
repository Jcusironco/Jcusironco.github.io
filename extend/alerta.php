<!DOCTYPE html>
<html lang ="en">
<head>
    <title>Mensaje MARCELO MOTORS</title>
    <link rel="shortcut icon" type="image/x-icon" href="../img/logis.ico">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<?php
    include '../conexion/conexion.php';
?>
<!DOCTYPE html>
  <html>
    <head>
          <!--Import Google Icon Font-->
          <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
          <!--Import materialize.css-->
          <link type="text/css" rel="stylesheet" href="../css/materialize.min.css"  media="screen,projection"/>
            <link rel="stylesheet" href="../css/sweetalert2.css">
          <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.3.2/sweetalert2.css">
          <!--Let browser know website is optimized for mobile-->
          <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    </head>
   <body>
        <?php
                $mensaje=htmlentities($_GET['msj']);
                $c=htmlentities($_GET['c']);
                $p=htmlentities($_GET['p']);
                $t=htmlentities($_GET['t']);

                switch ($c) 
                {
                    case 'us':
                        $carpeta='../usuarios/';
                        break;
                    case 'home':
                      $carpeta='../inicio/';
                      break;
                    case 'salir':
                      $carpeta='../';
                      break;
                    case 'pe':
                      $carpeta='../perfil/';
                      break;
                    case 'comp':
                      $carpeta='../compra/';
                      break;
                    case 'inv':
                      $carpeta='../inventario/';
                      break;
                    case 'ven':
                      $carpeta='../venta/';
                      break;
                    case 'dev':
                      $carpeta='../devolucion/';
                      break;
                    case 'hora':
                      $carpeta='../horario/';
                      break;
                    case 'permi':
                      $carpeta='../permisosEmpleados/';
                      break;
                }
                switch ($p) 
                {
                    case 'in':
                        $pagina='index.php';
                        break;
                    case 'home':
                      $pagina='index.php';
                      break;
                    case 'salir':
                      $pagina='';
                      break;
                    case 'perfil':
                      $pagina='perfil.php';
                      break;
                    case 'comp':
                      $pagina='index.php';
                      break;
                    case 'inv':
                      $pagina='index.php';
                      break;
                    case 'ven':
                      $pagina='index.php';
                      break;
                    case 'dev':
                      $pagina='index.php';
                      break;
                    case 'hora':
                      $pagina='index.php';
                      break;
                    case 'permi':
                      $pagina='index.php';
                      break;
                        }

                $dir = $carpeta.$pagina;

                if($t == 'error')
                {
                    $titulo="Oppss...";
                }
                else
                {
                    $titulo="Ok...good";
                }
        ?>
        <script type="text/javascript" src="../js/jquery-3.2.1.min.js"></script>
        <script type="text/javascript" src="../js/sweetalert2.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.3.2/sweetalert2.js"></script>
    <script type="text/javascript" src="../js/materialize.min.js"></script>
    <script>
          swal({
               title: '<?php echo $titulo ?>',
               text: '<?php echo $mensaje ?>',
               type: '<?php echo $t ?>',
               confirmButtonColor: '#3085d6',
               confirmButtonText: 'Ok'
               }).then(function()
                  {
                    location.href='<?php echo $dir ?>';
                  });
         $(document).click(function()
                {
                    location.href='<?php echo $dir ?>';
                });
         $(document).keyup(function(e)
                {
                   if (e.which==27)
                        {
                          location.href='<?php echo $dir ?>';       
                        }
                });  
    </script>
  </body>
</html>