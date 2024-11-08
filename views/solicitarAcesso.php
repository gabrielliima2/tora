<?php
include("../scripts/conexao.php");
include("../scripts/protect.php");

$id_patente = $_SESSION['id_patente'];

if (isset($_GET["id"])) {
    $id = $_GET['id'];

    // Consulta a turma com o ID recebido
    $query = "SELECT * FROM turma WHERE id = $id";
    $result = mysqli_query($mysqli, $query);
    $turma = mysqli_fetch_assoc($result);
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
    <?php include("../components/menu.php"); ?>

    <main id="mainTurma">
        <div class="FormularioNovaTurma">
            <h1>Solicitar acesso</h1>
            <p>Você deseja solicitar acesso à turma "<?php echo $turma['nome']; ?>"?</p>
            <div class="buttonsAcoesTurma">
                <a href="solicitacoes.php?id=<?php echo $turma['id']; ?>" class="buttons criarTurma" name="aceitar">Sim</a>
                <a href="encontrarTurma.php" class="buttons excluir" name="cancelar">Não</a>
            </div>
        </div>
    </main>
</body>
</html>

<?php
}
?>
