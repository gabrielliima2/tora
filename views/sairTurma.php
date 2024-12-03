<?php
include("../scripts/conexao.php");
include("../scripts/protect.php");

$turma_id = $_GET['id'];
$usuario_id = $_SESSION['id'];

$query = "DELETE FROM turma_usuario WHERE id_turma = '$turma_id' AND id_usuario = '$usuario_id'";
if (mysqli_query($mysqli, $query)) {
    header("Location: criarTurma.php?success=removeu");
} else {
    die("Erro ao sair da turma: " . mysqli_error($mysqli));
}
?>
