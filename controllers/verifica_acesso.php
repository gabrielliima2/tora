<?php
    function verificaAcesso($patentePermitida) {

        if($_SESSION['id_patente'] !== $patentePermitida) {
            echo "Acesso negado! Sua patente não tem permissão para acessar esta página.";
            exit(); 
        }
    }
?>