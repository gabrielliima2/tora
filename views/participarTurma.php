<?php
include("../scripts/conexao.php");
include("../scripts/protect.php");

$turma_id = $_GET['id'];
$usuario_id = $_SESSION['id'];

$query = "INSERT INTO turma_usuario (id_turma, id_usuario) VALUES ('$turma_id', '$usuario_id')";
if (mysqli_query($mysqli, $query)) {
    header("Location: criarTurma.php?success=participou");
} else {
    die("Erro ao participar da turma: " . mysqli_error($mysqli));
}
?>
