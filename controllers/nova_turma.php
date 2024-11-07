<?php
include('../scripts/conexao.php');


$nome = $_POST['nomeTurma'];
$ano = $_POST['anoTurma'];

$queryCheck = "SELECT * FROM turma WHERE ano = '$ano'";
$resuCheck = $mysqli->query($queryCheck) or die("Falha na execução do código SQL: " . $mysqli->error);

if($resuCheck->num_rows > 0) {
    echo 'Turma já cadastrada!';
} else {
    // Insere uma nova turma
    $query = "INSERT INTO turma (nome, ano) VALUES ('$nome', '$ano')";
    $resu = $mysqli->query($query) or die("Falha na execução do código SQL: " . $mysqli->error);

    if($resu) {
        echo 'Turma cadastrada com sucesso!';
        header('Location: ../views/home.php');
    } else {
        echo 'Falha ao cadastrar nova turma!';
    }
}

?>