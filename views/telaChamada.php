<?php
include("../scripts/conexao.php");
include("../scripts/protect.php");

date_default_timezone_set('America/Sao_Paulo'); // Define o fuso horário para São Paulo

$id_patente = $_SESSION['id_patente'];
if ($id_patente == "4" || $id_patente == "3" || $id_patente == "2") {}

if ($id_patente == "4") {
    verificaAcesso("4");
} else if ($id_patente == "3") {
    verificaAcesso("3");
} else {
    verificaAcesso("2");
}

$turma_id = $_SESSION['turma_id'];

$data_hoje = date("d/m/Y"); // Formato dd/mm/aaaa
$hora_agora = date("H:i:s"); // Formato 24 horas

$queryVerificaData = "SELECT * FROM data_chamada WHERE data = CURDATE() AND id_turma = '$turma_id'";
$resultVerificaData = $mysqli->query($queryVerificaData);

$chamada_feita = ($resultVerificaData->num_rows > 0);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data_banco = date("Y-m-d"); // Formato para salvar no banco
    $queryDataChamada = "INSERT INTO data_chamada (data, hora, id_turma) VALUES ('$data_banco', '$hora_agora', '$turma_id')";
    $mysqli->query($queryDataChamada) or die("Erro ao inserir data da chamada: " . $mysqli->error);

    $id_data_chamada = $mysqli->insert_id;
    $presencas = isset($_POST['presencas']) ? $_POST['presencas'] : [];

    $queryUsuarios = "SELECT u.id FROM turma_usuario tu 
                      INNER JOIN usuarios u ON tu.id_usuario = u.id 
                      WHERE tu.id_turma = '$turma_id'";
    $resultUsuarios = mysqli_query($mysqli, $queryUsuarios) or die(mysqli_connect_error());

    if (mysqli_num_rows($resultUsuarios) > 0) {
        while ($usuario = mysqli_fetch_assoc($resultUsuarios)) {
            $id_usuario = $usuario['id'];
            $status = isset($presencas[$id_usuario]) ? $presencas[$id_usuario] : 2;
            $queryInsert = "INSERT INTO chamada (id_data_chamada, id_turma, id_usuario, id_status) 
                            VALUES ('$id_data_chamada', '$turma_id', '$id_usuario', '$status')";
            $mysqli->query($queryInsert) or die("Erro ao salvar chamada: " . $mysqli->error);
        }
    }

    header("location: telaChamada.php");
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
        <div  style="margin-bottom: 30px;">
            <?php if ($chamada_feita): ?>
                <p>chamada de hoje já foi realizada</p>
            <?php else: ?>
                <div class="novaChamada buttons">Realizar chamada de hoje</div>
            <?php endif; ?>
        </div>
        <div class="backFormChamada hide"></div>
        <form method="POST" class="formChamada hide">
            <div style="display: flex; flex-direction:column; justify-content: center; align-items: center;">
                <h1>Registro de Chamada</h1>
                <p>Data: <?php echo date("Y-m-d"); ?> | Hora: <?php echo date("H:i:s"); ?></p>
            </div>
            <div class="table-container">
                <table class="tabelaChamada">
                    <thead>
                        <tr>
                            <th>Nome do Participante</th>
                            <th>Presente</th>
                            <th>Ausente</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $queryUsuarios = "SELECT u.id, u.nome 
                            FROM turma_usuario tu 
                            INNER JOIN usuarios u ON tu.id_usuario = u.id 
                            WHERE tu.id_turma = '$turma_id' 
                            AND u.id NOT IN (3, 4)";
        
                        $resultUsuarios = mysqli_query($mysqli, $queryUsuarios) or die(mysqli_connect_error());

                        if (mysqli_num_rows($resultUsuarios) > 0) {
                            while ($usuario = mysqli_fetch_assoc($resultUsuarios)) {
                                echo "
                                <tr>
                                    <td>" . htmlspecialchars($usuario['nome'], ENT_QUOTES, 'UTF-8') . "</td>
                                    <td class='checkbox-group'>
                                    <input type='checkbox' name='presencas[" . $usuario['id'] . "]' value='1' onclick='desmarcarOutro(this)' id='presente_" . $usuario['id'] . "'>
                                    </td>
                                    <td class='checkbox-group'>
                                    <input type='checkbox' name='presencas[" . $usuario['id'] . "]' value='2' onclick='desmarcarOutro(this)' id='ausente_" . $usuario['id'] . "'>
                                    </td>
                                </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='3'>Nenhum participante encontrado</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <div style="display: flex; gap: 20px;">
                <button type="submit" class="buttons salvarChamada">Salvar</button>
                <div class="cancelarChamada buttons excluir">Cancelar</div>
            </div>
        </form>

        <h2>Chamadas</h2>
        <div class="containerListaTurma">
            <?php
                $query = "SELECT DISTINCT dc.id AS data_chamada_id, dc.data, dc.hora
                        FROM data_chamada dc 
                        INNER JOIN chamada c ON dc.id = c.id_data_chamada 
                        WHERE c.id_turma = '$turma_id' 
                        ORDER BY dc.data DESC, dc.hora DESC";
                $result = mysqli_query($mysqli, $query) or die(mysqli_connect_error());

                if (mysqli_num_rows($result) > 0) {
                    $last_date = null;

                    while ($reg = mysqli_fetch_array($result)) {
                        $current_date = $reg['data'];

                        if ($current_date !== $last_date) {
                            if ($last_date !== null) {
                                echo "</div>"; 
                            }

                            echo "<div class='listaTurmas' style='display:flex; gap: 30px;'>";
                            echo "<h3>Data: " . date("d/m/Y", strtotime($current_date)) . "</h3>"; // Formato brasileiro
                            echo "<p>Hora da chamada: " . date("H:i:s", strtotime($reg['hora'])) . "</p>";

                            echo "<a href='editarChamada.php?id=" . $reg['data_chamada_id'] . "' class='botao editar'>";
                            echo "<ion-icon name='pencil-sharp'></ion-icon>";
                            echo "</a>";

                            $last_date = $current_date;
                        }
                    }

                    echo "</div>"; // Fecha a última lista
                } else {
                    echo "<p>Nenhuma chamada encontrada!</p>";
                }
            ?>
        </div>



    </main>

        <!--Para nao dar erro no JS-->
        <input type="hidden" class="novaChamada">
        <input type="hidden" class="editarChamada">

    <script>
        function desmarcarOutro(checkbox) {
            const checkboxes = document.querySelectorAll(`input[name='${checkbox.name}']`);
            checkboxes.forEach(chk => {
                if (chk !== checkbox) {
                    chk.checked = false; // Desmarca o outro checkbox
                }
            });
        }
    </script>
</body>
</html>