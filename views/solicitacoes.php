<?php
include("../scripts/conexao.php");
include("../scripts/protect.php");

// Verifica se o ID da turma foi enviado
if (isset($_GET['id'])) {
    $turma_id = $_GET['id'];
    $usuario_id = $_SESSION['id']; // ID do usuário logado

    // Verifica se a solicitação de acesso já foi feita
    $query = "SELECT * FROM solicitacoes WHERE usuario_id = '$usuario_id' AND turma_id = '$turma_id'";
    $result = mysqli_query($mysqli, $query);

    if (mysqli_num_rows($result) > 0) {
        header("Location: encontrarTurma.php");
    } else {
        // Insere uma nova solicitação de acesso
        $query = "INSERT INTO solicitacoes (usuario_id, turma_id, status) VALUES ('$usuario_id', '$turma_id', 'pendente')";
        if (mysqli_query($mysqli, $query)) {
            header("Location: encontrarTurma.php");
        } else {
            echo "Erro ao enviar a solicitação: " . mysqli_error($mysqli);
            header("Location: encontrarTurma.php");
        }
    }
} else {
    echo "Turma não selecionada!";
}
?>
