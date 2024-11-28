<?php
include("../scripts/conexao.php");
include("../scripts/protect.php");

$id_patente = $_SESSION['id_patente'];
if ($id_patente == "4") {
    verificaAcesso("4");
} else{
    verificaAcesso("3");
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['atualizar'])) {
    $id = $_POST['id'];
    $novoNome = $_POST['nomeTurma'];
    $novoAno = $_POST['anoTurma'];

    $queryUpdate = "UPDATE turma SET nome = '$novoNome', ano = '$novoAno' WHERE id = '$id'";
    $resu = mysqli_query($mysqli, $queryUpdate);

    if ($resu) {
        echo '<div class="backPopUp"></div>
                <div class="containerPopUp">
                    <div class="popUp">
                        <ion-icon class="checkmarkPopUp" name="checkmark-circle-outline"></ion-icon>
                        <h1>Turma editada com sucesso</h1>
                        <a href="criarTurma.php" class="buttonsPopUp" name="cancelar">OK</a>
                    </div>
                </div>';
    } else {
        echo "ERRO ao atualizar os dados: " . mysqli_error($mysqli);
    }
}

if (isset($_GET["id"])) {
    $id = $_GET['id'];

    $query = "SELECT * FROM turma WHERE id = $id";
    $result = mysqli_query($mysqli, $query);
    $turma = $result->fetch_assoc();
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
            <h1>Editar Turma</h1>
            <form method="POST" class="formNovaTurma">
                <input type="hidden" name="id" value="<?php echo $id; ?>">

                <div>
                    <div class="inputBox">
                        <input type="text" name="nomeTurma" id="nomeTurma" class="inputs" value="<?php echo $turma['nome']; ?>" required>
                        <label class="labelInput">Nome</label>
                    </div>
                    <div class="inputBox">
                        <input type="number" name="anoTurma" id="anoTurma" class="inputs" value="<?php echo $turma['ano']; ?>" required>
                        <label class="labelInput">Ano</label>
                    </div>
                </div>
                <div class="buttonsAcoesTurma">
                    <input type="submit" class="buttons criarTurma" name="atualizar" value="Salvar">
                    <a href="criarTurma.php" class="buttons excluir" name="cancelar">Cancelar</a>
                </div>
            </form>
        </div>
    </main>
</body>
</html>
<?php
}
?>
