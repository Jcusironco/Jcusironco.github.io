<?php
	//conexion a nuestra base de datos
	@session_start();
	$con= new mysqli("localhost","root","","almacen");
	$con->set_charset('utf8');
?>