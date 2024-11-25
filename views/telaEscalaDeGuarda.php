<?php
include("../scripts/conexao.php");
include("../scripts/protect.php");

date_default_timezone_set('America/Sao_Paulo');

$id_patente = $_SESSION['id_patente'];
$turma_id = $_SESSION['turma_id'];

if ($id_patente == "4") {
    verificaAcesso("4");
} else if ($id_patente == "3") {
    verificaAcesso("3");
} else {
    verificaAcesso("2");
}

function gerarEscalasSequenciais($mysqli, $turma_id, $data_inicio, $num_dias) {
    $dataHoje = date("Y-m-d");

    $queryMonitores = "SELECT u.id FROM usuarios u 
                       INNER JOIN turma_usuario tu ON u.id = tu.id_usuario 
                       WHERE tu.id_turma = '$turma_id' AND u.id_patente = 2";
    $resultMonitores = mysqli_query($mysqli, $queryMonitores);
    
    if (mysqli_num_rows($resultMonitores) > 0) {
        $monitores = [];
        while ($monitor = mysqli_fetch_assoc($resultMonitores)) {
            $monitores[] = $monitor['id'];
        }
        
        if (count($monitores) > 0) {
            $queryAtiradores = "SELECT u.id FROM usuarios u 
                                INNER JOIN turma_usuario tu ON u.id = tu.id_usuario 
                                WHERE tu.id_turma = '$turma_id' AND u.id_patente = 1";
            $resultAtiradores = mysqli_query($mysqli, $queryAtiradores);

            if (mysqli_num_rows($resultAtiradores) > 0) {
                $atiradores = [];
                while ($atirador = mysqli_fetch_assoc($resultAtiradores)) {
                    $atiradores[] = $atirador['id'];
                }

                $atiradorIndex = 0;
                $monitorIndex = 0;

                for ($i = 0; $i < $num_dias; $i++) {
                    $data = date("Y-m-d", strtotime("$data_inicio +$i day"));

                    $atiradoresEscolhidos = [];
                    for ($j = 0; $j < 6; $j++) {
                        $atiradoresEscolhidos[] = $atiradores[$atiradorIndex];
                        $atiradorIndex = ($atiradorIndex + 1) % count($atiradores);
                    }

                    $monitorEscolhido = $monitores[$monitorIndex];
                    $monitorIndex = ($monitorIndex + 1) % count($monitores); 

                    $atiradores_str = implode(",", $atiradoresEscolhidos);
                    $queryEscala = "INSERT INTO escala_de_guarda (id_turma, data, id_monitor, atiradores) 
                                    VALUES ('$turma_id', '$data', '$monitorEscolhido', '$atiradores_str')";
                    mysqli_query($mysqli, $queryEscala);
                }
            }
        }
    }
}

if (isset($_POST['gerar_escala'])) {
    $data_inicio = $_POST['data_inicio'];
    $num_dias = $_POST['num_dias'];

    gerarEscalasSequenciais($mysqli, $turma_id, $data_inicio, $num_dias);
    echo "Escalas geradas com sucesso!";
}


if (isset($_POST['excluir_multiplas'])) {
    if (isset($_POST['escalas_selecionadas'])) {
        $escalas_selecionadas = $_POST['escalas_selecionadas'];
        foreach ($escalas_selecionadas as $escala_id) {
            $queryExcluir = "DELETE FROM escala_de_guarda WHERE id = '$escala_id'";
            mysqli_query($mysqli, $queryExcluir);
        }
        echo "Escalas excluídas com sucesso!";
    } else {
        echo "Nenhuma escala selecionada para exclusão.";
    }
}

if (isset($_GET['excluir'])) {
    $escala_id = $_GET['excluir'];
    $queryExcluir = "DELETE FROM escala_de_guarda WHERE id = '$escala_id'";
    if (mysqli_query($mysqli, $queryExcluir)) {
        echo "Escala excluída com sucesso!";
    } else {
        echo "Erro ao excluir escala!";
    }
}

if (isset($_POST['editar_escala'])) {
    $escala_id = $_POST['escala_id'];
    $data = $_POST['data'];
    $monitor_id = $_POST['monitor_id'];
    $atiradores = $_POST['atiradores']; 
    $atiradores_str = implode(",", $atiradores);

    $queryEditar = "UPDATE escala_de_guarda 
                    SET data = '$data', id_monitor = '$monitor_id', atiradores = '$atiradores_str' 
                    WHERE id = '$escala_id'";

    if (mysqli_query($mysqli, $queryEditar)) {
        echo "Escala atualizada com sucesso!";
    } else {
        echo "Erro ao editar escala!";
    }
}



$queryEscalas = "SELECT * FROM escala_de_guarda WHERE id_turma = '$turma_id' ORDER BY data";
$escalas = mysqli_query($mysqli, $queryEscalas);
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
    <h1>Visualização, Geração e Edição de Escalas de Guarda</h1>
    
    <h2>Gerar Escalas Automáticas</h2>
    <form method="POST">
        <label for="data_inicio">Data de Início:</label>
        <input type="date" name="data_inicio" required><br>
        
        <label for="num_dias">Número de Dias:</label>
        <input type="number" name="num_dias" min="1" required><br>
        
        <button type="submit" name="gerar_escala">Gerar Escalas</button>
    </form>

    <h2>Escalas Cadastradas</h2>
    <form method="POST">
        <table border="1">
            <thead>
                <tr>
                    <th><input type="checkbox" id="selecionarTodos"> Selecionar Todos</th>
                    <th>Data</th>
                    <th>Monitor</th>
                    <th>Atiradores</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($escala = mysqli_fetch_assoc($escalas)) { ?>
                    <tr>
                        <td><input type="checkbox" name="escalas_selecionadas[]" value="<?= $escala['id'] ?>"></td>
                        <td><?= $escala['data'] ?></td>
                        <td>
                            <?php
                            // Exibe o nome do monitor
                            $monitor_id = $escala['id_monitor'];
                            $queryMonitor = "SELECT nome FROM usuarios WHERE id = '$monitor_id'";
                            $resultMonitor = mysqli_query($mysqli, $queryMonitor);
                            $monitor = mysqli_fetch_assoc($resultMonitor);
                            echo $monitor['nome'];
                            ?>
                        </td>
                        <td>
                            <?php
                            // Exibe os nomes dos atiradores
                            $atiradores_ids = explode(",", $escala['atiradores']);
                            foreach ($atiradores_ids as $atirador_id) {
                                $queryAtirador = "SELECT nome FROM usuarios WHERE id = '$atirador_id'";
                                $resultAtirador = mysqli_query($mysqli, $queryAtirador);
                                $atirador = mysqli_fetch_assoc($resultAtirador);
                                echo $atirador['nome'] . "<br>";
                            }
                            ?>
                        </td>
                        <td>

                            <a href="telaEscalaDeGuarda.php?editar=<?= $escala['id'] ?>">Editar</a> |
                            <a href="telaEscalaDeGuarda.php?excluir=<?= $escala['id'] ?>" onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <button type="submit" name="excluir_multiplas">Excluir Selecionadas</button>
    </form>

    <?php if (isset($_GET['editar'])) {
        $escala_id = $_GET['editar'];
        $queryEscalaEdit = "SELECT * FROM escala_de_guarda WHERE id = '$escala_id'";
        $resultEscalaEdit = mysqli_query($mysqli, $queryEscalaEdit);
        $escalaEdit = mysqli_fetch_assoc($resultEscalaEdit);
        ?>
        <h2>Editar Escala</h2>
        <form method="POST">
            <input type="hidden" name="escala_id" value="<?= $escalaEdit['id'] ?>">
            <label for="data">Data:</label>
            <input type="date" name="data" value="<?= $escalaEdit['data'] ?>" required><br>

            <label for="monitor_id">Monitor:</label>
            <select name="monitor_id" required>
                <?php

                $queryMonitores = "SELECT u.id, u.nome FROM usuarios u 
                                INNER JOIN turma_usuario tu ON u.id = tu.id_usuario 
                                WHERE tu.id_turma = '$turma_id' AND u.id_patente = 2";
                $resultMonitores = mysqli_query($mysqli, $queryMonitores);
                while ($monitor = mysqli_fetch_assoc($resultMonitores)) {
                    echo "<option value='" . $monitor['id'] . "' " . ($escalaEdit['id_monitor'] == $monitor['id'] ? "selected" : "") . ">" . $monitor['nome'] . "</option>";
                }
                ?>
            </select><br>

            <label for="atiradores">Atiradores:</label><br>
            <?php

            $queryAtiradores = "SELECT u.id, u.nome FROM usuarios u 
                                INNER JOIN turma_usuario tu ON u.id = tu.id_usuario 
                                WHERE tu.id_turma = '$turma_id' AND u.id_patente = 1";
            $resultAtiradores = mysqli_query($mysqli, $queryAtiradores);
            $atiradoresEdit = explode(",", $escalaEdit['atiradores']);
            while ($atirador = mysqli_fetch_assoc($resultAtiradores)) {
                echo "<input type='checkbox' name='atiradores[]' value='" . $atirador['id'] . "' " . (in_array($atirador['id'], $atiradoresEdit) ? "checked" : "") . "> " . $atirador['nome'] . "<br>";
            }
            ?>

            <button type="submit" name="editar_escala">Atualizar Escala</button>
        </form>
    <?php } ?>

    
    <script>
    document.getElementById('selecionarTodos').addEventListener('click', function() {
        const checkboxes = document.querySelectorAll('input[type="checkbox"]'); // Seleciona todos os checkboxes
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked; // Define todos como o estado do "Selecionar Todos"
        });
    });
</script>

</body>
</html>
