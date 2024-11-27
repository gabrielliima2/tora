<?php
include("../scripts/conexao.php");
include("../scripts/protect.php");

date_default_timezone_set('America/Sao_Paulo');

$id_turma = $_SESSION['turma_id'];
$data_chamada_id = $_GET['id'] ?? null;

if (!$data_chamada_id) {
    die("Chamada não encontrada!");
}


if (isset($_POST['excluir'])) {
    $deleteChamada = "DELETE FROM chamada WHERE id_data_chamada = '$data_chamada_id'";
    $deleteDataChamada = "DELETE FROM data_chamada WHERE id = '$data_chamada_id'";
    $mysqli->query($deleteChamada) or die("Erro ao excluir chamada: " . $mysqli->error);
    $mysqli->query($deleteDataChamada) or die("Erro ao excluir data da chamada: " . $mysqli->error);

    header("location: telaChamada.php");
    exit;
}


$queryChamada = "
    SELECT c.id AS chamada_id, u.id AS usuario_id, u.nome, c.id_status 
    FROM chamada c 
    INNER JOIN usuarios u ON c.id_usuario = u.id 
    WHERE c.id_data_chamada = '$data_chamada_id' AND c.id_turma = '$id_turma'
";
$resultChamada = $mysqli->query($queryChamada) or die($mysqli->error);

if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST['excluir'])) {
    $presencas = $_POST['presencas'] ?? [];

    while ($row = $resultChamada->fetch_assoc()) {
        $chamada_id = $row['chamada_id'];
        $status = isset($presencas[$row['usuario_id']]) ? $presencas[$row['usuario_id']] : 2;

        $updateQuery = "UPDATE chamada SET id_status = '$status' WHERE id = '$chamada_id'";
        $mysqli->query($updateQuery) or die("Erro ao atualizar chamada: " . $mysqli->error);
    }

    header("location: telaChamada.php");
    exit;
}
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
    <script src="../assets/js/scriptChamada.js" defer></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js" defer></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js" defer></script>

    <title>Tóra</title>
</head>
<body>
    <?php include("../components/header.php"); ?>
    <?php include("../components/turmaMenu.php"); ?>

    <main id="mainChamada">
        <form method="POST" class="formChamada">
            <div style="display: flex; flex-direction:column; justify-content: center; align-items: center;">
                <h1>Editar chamada</h1>
                <p>Realizada em <?php echo date("d-m-Y"); ?> as <?php echo date("H:i:s"); ?></p>
            </div>
            <div class="table-container">
                <table class="tabelaChamada">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Presente</th>
                            <th>Ausente</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($resultChamada->num_rows > 0) {
                            $resultChamada->data_seek(0); 
                            while ($row = $resultChamada->fetch_assoc()) {
                                $statusPresente = $row['id_status'] == 1 ? "checked" : "";
                                $statusAusente = $row['id_status'] == 2 ? "checked" : "";

                                echo "
                                <tr>
                                    <td>" . htmlspecialchars($row['nome'], ENT_QUOTES, 'UTF-8') . "</td>
                                    <td class='checkbox-group'>
                                        <input 
                                            type='checkbox' 
                                            name='presencas[" . $row['usuario_id'] . "]' 
                                            value='1' 
                                            $statusPresente 
                                            onclick='desmarcarOutro(this)'>
                                    </td>
                                    <td class='checkbox-group'>
                                        <input 
                                            type='checkbox' 
                                            name='presencas[" . $row['usuario_id'] . "]' 
                                            value='2' 
                                            $statusAusente 
                                            onclick='desmarcarOutro(this)'>
                                    </td>
                                </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='3'>Nenhuma chamada encontrada!</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <div>
                <button type="submit" class="buttons">Salvar Alterações</button>
                <button type="submit" class="buttons excluir" name="excluir">Excluir Chamada</button>
            </div>
            <a href="telaChamada.php" class="buttons excluir">Cancelar</a>
        </form>
    </main>

    <script>
        function desmarcarOutro(checkbox) {
            const checkboxes = document.querySelectorAll(`input[name='${checkbox.name}']`);
            checkboxes.forEach(chk => {
                if (chk !== checkbox) {
                    chk.checked = false; 
                }
            });
        }
    </script>
</body>
</html>
