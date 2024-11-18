<?php

if(!isset($_SESSION)) {
    session_start();
}

if(!isset($_SESSION["id"])) {
    header("Location: ../index.php");
    die();
}

function verificaAcesso($patentePermitida) {

    if($_SESSION['id_patente'] !== $patentePermitida) {
        header("Location: ../views/home.php");
        exit();
    }
}

?>
