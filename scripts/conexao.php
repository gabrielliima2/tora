<?php
$usuario = 'root';
$senha = '';
$database = 'tora';
$host = 'localhost';

$mysqli = new mysqli($host, $usuario, $senha, $database);

if($mysqli->error){
    die('Falha ao se conectar com o banco de dados: '. $mysqli->error);
}

?>