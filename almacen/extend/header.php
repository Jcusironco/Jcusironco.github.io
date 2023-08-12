<?php 
    include "../conexion/conexion.php";
    if (!isset($_SESSION['nick']))
    {
        header('location:../');
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/materialize.min.css">
    <link rel="stylesheet" type="text/css" href="../css/estilos.css">
    <script type="../js/materialize.min.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- configuración adicional -->
    <meta http-equiv="X-UA-Compatible" content="ie-edge">
    <link rel="stylesheet" href="../css/sweetalert2.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.15.0/sweetalert2.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.3.2/sweetalert2.css">
    <style type="text/css">
            header, main, footer {padding-left: 300px;}
            .button-collpase{display: none;}
         @media only screen and (max-width : 992px) 
         {
            header, main, footer {padding-left: 0;}
            .button-collpase{display: inherit;}
         }
    </style>
        <title>Document</title>
</head>
<body>
    <main>
    <?php
      if ($_SESSION['nivel'] == 'ADMINISTRADOR') {
        include 'menu_admin.php';
      }
      if  ($_SESSION['nivel'] == 'EMPLEADO') {
        include 'menu_empleado.php';
      }
    ?>