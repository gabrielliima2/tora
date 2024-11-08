<?php

if(!isset($_SESSION)) {
    session_start();
}

if(!isset($_SESSION["id"])) {
    header("Location: ../index.php");
    die();
}

function verificaAcesso($patentePermitida) {
    // Verifica se a patente do usuário é permitida
    if($_SESSION['id_patente'] !== $patentePermitida) {
        header("Location: ../views/home.php");
        exit(); // Interrompe o carregamento da página
    }
}

?>
