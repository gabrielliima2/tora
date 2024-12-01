<?php
include("../scripts/conexao.php");
include("../scripts/protect.php");


if (isset($_GET['id'])) {
    $turma_id = $_GET['id'];
    $usuario_id = $_SESSION['id']; 

    $query = "DELETE FROM solicitacoes WHERE usuario_id = '$usuario_id' AND turma_id = '$turma_id' AND status = 'pendente'";
    
    if (mysqli_query($mysqli, $query)) {
        header("Location: encontrarTurma.php"); 
    } else {
        echo "Erro ao cancelar a solicitação: " . mysqli_error($mysqli);
    }
} else {
    echo "Turma não especificada!";
}
?>
