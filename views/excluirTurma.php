<?php
include("../scripts/conexao.php");
include("../scripts/protect.php");

// Verifica se o ID foi enviado via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];

    // Prepara a consulta para excluir a turma
    $query = "DELETE FROM turma WHERE id = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("i", $id);

    // Executa a exclusão e verifica o resultado
    if ($stmt->execute()) {
        echo "Turma excluída com sucesso!";
    } else {
        echo "Erro ao excluir turma: " . $mysqli->error;
    }

    $stmt->close();
} else {
    echo "ID da turma não foi informado.";
}
?>
