<?php
include("../scripts/conexao.php");
include("../scripts/protect.php");

if (isset($_GET['id'])) {
    $solicitacao_id = $_GET['id'];

    // Seleciona os dados de usuario_id e turma_id antes de excluir a solicitação
    $selectQuery = "SELECT usuario_id, turma_id FROM solicitacoes WHERE id = '$solicitacao_id'";
    $result = mysqli_query($mysqli, $selectQuery);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $usuario_id = $row['usuario_id'];
        $turma_id = $row['turma_id'];

        // Exclui a solicitação após recuperar os dados
        $deleteQuery = "DELETE FROM solicitacoes WHERE id = '$solicitacao_id' AND status = 'pendente'";
        
        if (mysqli_query($mysqli, $deleteQuery)) {
            // Insere o usuário na turma na tabela turma_usuario
            $insertQuery = "INSERT INTO turma_usuario (id_usuario, id_turma) VALUES ('$usuario_id', '$turma_id')";

            if (mysqli_query($mysqli, $insertQuery)) {
                echo "Solicitação aceita e usuário adicionado à turma com sucesso!";
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
