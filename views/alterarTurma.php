<?php
include("../scripts/conexao.php");
include("../scripts/protect.php");

// Verifica se o ID foi enviado via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];

    // Carrega os dados da turma existente
    $query = "SELECT * FROM turma WHERE id = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $turma = $result->fetch_assoc();

    // Verifica se a turma existe
    if (!$turma) {
        echo "Turma não encontrada.";
        exit;
    }

    // Atualiza os dados se o formulário for enviado
    if (isset($_POST['nomeTurma']) && isset($_POST['anoTurma'])) {
        $novoNome = $_POST['nomeTurma'];
        $novoAno = $_POST['anoTurma'];

        // Atualiza a turma no banco de dados
        $queryUpdate = "UPDATE turma SET nome = ?, ano = ? WHERE id = ?";
        $stmtUpdate = $mysqli->prepare($queryUpdate);
        $stmtUpdate->bind_param("sii", $novoNome, $novoAno, $id);
        
        if ($stmtUpdate->execute()) {
            echo "Turma atualizada com sucesso!";
            header("Location: turma.php"); // Redireciona para a lista de turmas
            exit;
        } else {
            echo "Erro ao atualizar turma: " . $mysqli->error;
        }
    }
} else {
    echo "ID da turma não foi informado.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Turma</title>
</head>
<body>
    <h1>Editar Turma</h1>
    <form method="POST">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">

        <div>
            <label>Nome:</label>
            <input type="text" name="nomeTurma" value="<?php echo htmlspecialchars($turma['nome']); ?>" required>
        </div>

        <div>
            <label>Ano:</label>
            <input type="number" name="anoTurma" value="<?php echo htmlspecialchars($turma['ano']); ?>" min="2000" max="2200" required>
        </div>

        <button type="submit">Salvar Alterações</button>
    </form>
</body>
</html>
