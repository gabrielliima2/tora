<?php
include("../scripts/conexao.php");
include("../scripts/protect.php");

if (isset($_GET['id'])) {
    $solicitacao_id = $_GET['id'];

    $selectQuery = "SELECT usuario_id, turma_id FROM solicitacoes WHERE id = '$solicitacao_id'";
    $result = mysqli_query($mysqli, $selectQuery);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $usuario_id = $row['usuario_id'];
        $turma_id = $row['turma_id'];


        $deleteQuery = "DELETE FROM solicitacoes WHERE id = '$solicitacao_id' AND status = 'pendente'";
        
        if (mysqli_query($mysqli, $deleteQuery)) {

            $insertQuery = "INSERT INTO turma_usuario (id_usuario, id_turma) VALUES ('$usuario_id', '$turma_id')";

            if (mysqli_query($mysqli, $insertQuery)) {
                header("Location: visualizarSolicitacoes.php");
                exit();
            } else {
                echo "Erro ao adicionar o usuário à turma: " . mysqli_error($mysqli);
            }
        } else {
            echo "Erro ao excluir a solicitação: " . mysqli_error($mysqli);
        }
    } else {
        echo "Solicitação não encontrada!";
    }
} else {
    echo "Solicitação não especificada!";
}
?>
