<?php
include("../scripts/conexao.php");
include("../scripts/protect.php");

$id_patente = $_SESSION['id_patente'];
if ($id_patente == "4") {
    verificaAcesso("4");
} else{
    verificaAcesso("3");
}


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
