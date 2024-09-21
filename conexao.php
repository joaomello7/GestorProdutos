<?php 
$host = "localhost";
$user = "root";
$pass = "";
$db = "gerenciadordb";

$mysqli = new mysqli($host, $user, $pass, $db);
//CHECA A CONEXÃO

if($mysqli ->connect_errno){ //verifica o numero do erro caso ocorra e imprime na tela oq houve.
    echo("Conexão Falhou!: " . $mysqli->connect_error); 
    die();
}


?>