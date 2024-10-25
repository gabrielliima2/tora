<?php
    function verificaAcesso($patentePermitida) {
        // Verifica se a patente do usuário é permitida
        if($_SESSION['id_patente'] !== $patentePermitida) {
            echo "Acesso negado! Sua patente não tem permissão para acessar esta página.";
            exit(); // Interrompe o carregamento da página
        }
    }
?>