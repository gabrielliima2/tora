<?php
include("../scripts/conexao.php");
include("../scripts/protect.php");

$id_patente = $_SESSION['id_patente'];
if($id_patente == "4"){
    verificaAcesso("4");
} else {
    verificaAcesso("3");
}

$turma_id = $_SESSION['turma_id'];

if (isset($_GET["id"])) {
    $id_usuario = $_GET["id"];
    $query_patente = "SELECT p.nome AS patente, u.* FROM usuarios u INNER JOIN patente p ON u.id_patente = p.id WHERE u.id = '$id_usuario'";
    $result_patente = mysqli_query($mysqli, $query_patente) or die(mysqli_error($mysqli));

    if ($result_patente) {
        $row = mysqli_fetch_assoc($result_patente);

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nova_patente'])) {
            $nova_patente = $_POST['nova_patente'];
            $query_update = "UPDATE usuarios SET id_patente = '$nova_patente' WHERE id = '$id_usuario'";
            if (mysqli_query($mysqli, $query_update)) {
                echo "Patente alterada com sucesso!";

                header("Location: participantes.php");
                exit;
            } else {
                echo "Erro ao alterar a patente: " . mysqli_error($mysqli);
            }
        }

        // Buscar todas as patentes para exibir no formulário de seleção
        $query_todas_patentes = "SELECT * FROM patente";
        $result_todas_patentes = mysqli_query($mysqli, $query_todas_patentes);
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
        <div class="containerListaTurma">
            <div class="containerAlterarParticipante">
                <?php
                    echo "<h2>" . $row['nome'] . "</h2>";
                    echo "<p>Patente atual: " . $row['patente'] . "</p>";
                ?>
                <form method="post" class="formAlterarPatenteParticipante">
                    <label for="nova_patente">Selecionar patente </label>
                    <div style="display: flex; flex-direction: column; justify-content:center; align-items: center; gap: 15px;">
                        <select name="nova_patente" id="nova_patente">
                            <?php
                            while ($patente = mysqli_fetch_assoc($result_todas_patentes)) {
                                echo "<option value='" . $patente['id'] . "'";
                                if ($patente['id'] == $row['id_patente']) echo " selected";
                                echo ">" . $patente['nome'] . "</option>";
                            }
                            ?>
                        </select>
                        <div>
                            <button type="submit" class="buttons">Salvar</button>
                            <a href="participantes.php" class="buttons excluir" style="margin-top:20px;">Cancelar</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>
</body>
</html>

<?php
    } else {
        echo "Usuário não localizado";
    }
} else {
    echo "Usuário não identificado";
}
?>
