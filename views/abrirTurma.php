<?php
session_start();
include("../scripts/conexao.php");
include("../scripts/protect.php");

// Captura turma_id da URL e armazena na sessão
if (isset($_GET['turma_id'])) {
    $_SESSION['turma_id'] = $_GET['turma_id'];
}

if (!isset($_SESSION['turma_id'])) {
    echo "Turma não especificada!";
    exit;
}

$turma_id = $_SESSION['turma_id'];

// Consulta para buscar detalhes da turma
$query_turma = "SELECT * FROM turma WHERE id = '$turma_id'";
$result_turma = mysqli_query($mysqli, $query_turma);

if (mysqli_num_rows($result_turma) == 0) {
    echo "Turma não encontrada!";
    exit;
}

$turma = mysqli_fetch_assoc($result_turma);

$query_usuarios = "SELECT u.nome AS usuario_nome 
                   FROM turma_usuario tu
                   INNER JOIN usuarios u ON tu.id_usuario = u.id
                   WHERE tu.id_turma = '$turma_id'";
$result_usuarios = mysqli_query($mysqli, $query_usuarios);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@500&display=swap" rel="stylesheet">    
    <link rel="stylesheet" href="../assets/css/style.css">
    <script src="../assets/js/script.js" defer></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js" defer></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js" defer></script>
    <title>Tóra</title>
</head>
<body>
    <?php include("../components/header.php"); ?>
    <?php include("../components/turmaMenu.php"); ?>
    
    <main id="mainTurma">
        <div class="containerTurmaDetalhes">
            <h1>Turma: <?php echo htmlspecialchars($turma['nome']); ?></h1>
            <p>Ano: <?php echo htmlspecialchars($turma['ano']); ?></p>
            <h2><?php $turma_id?></h2>
            <h2>Participantes</h2>
            <?php
            if (mysqli_num_rows($result_usuarios) > 0) {
                echo "<ul>";
                while ($usuario = mysqli_fetch_assoc($result_usuarios)) {
                    echo "<li>" . htmlspecialchars($usuario['usuario_nome']) . "</li>";
                }
                echo "</ul>";
            } else {
                echo "<p>Nenhum participante nesta turma.</p>";
            }
            ?>
        </div>
    </main>
</body>
</html>
