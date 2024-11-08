<?php
include("../scripts/conexao.php");
include("../scripts/protect.php");

if (isset($_GET['id'])) {
    $turma_id = $_GET['id'];
    $usuario_id = $_SESSION['id']; // ID do usuário logado

    // Remover a solicitação pendente
    $query = "DELETE FROM solicitacoes WHERE usuario_id = '$usuario_id' AND turma_id = '$turma_id' AND status = 'pendente'";
    
    if (mysqli_query($mysqli, $query)) {
        echo "Solicitação cancelada com sucesso!";
        header("Location: encontrarTurma.php"); // Redireciona para a página de turmas
    } else {
        echo "Erro ao cancelar a solicitação: " . mysqli_error($mysqli);
    }
} else {
    echo "Turma não especificada!";
}
?>
