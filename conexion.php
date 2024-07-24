<?php 
    # $ Este signo hace que la palabra sea una variable
    $dbhost = "localhost";
    $dbuser = "root";
    $dbclave = "";
    $db = "empresa";
    #Hace una conexion con la base llamada
    $con = mysqli_connect($dbhost, $dbuser, $dbclave, $db);
    #Una condicion si nos muestra un error
    if ($con->connect_error){
        die ('Error de Conexion ' . $con->connect_error);
    }
?>