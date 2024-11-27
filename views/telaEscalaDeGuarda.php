<?php
include("../scripts/conexao.php");
include("../scripts/protect.php");

date_default_timezone_set('America/Sao_Paulo');

$id_patente = $_SESSION['id_patente'];
$turma_id = $_SESSION['turma_id'];

if ($id_patente == "4") {
    verificaAcesso("4");
} else{
    verificaAcesso("3");
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
    header("Location: telaEscalaDeGuarda.php");
}


if (isset($_POST['excluir_multiplas'])) {
    if (isset($_POST['escalas_selecionadas'])) {
        $escalas_selecionadas = $_POST['escalas_selecionadas'];
        foreach ($escalas_selecionadas as $escala_id) {
            $queryExcluir = "DELETE FROM escala_de_guarda WHERE id = '$escala_id'";
            mysqli_query($mysqli, $queryExcluir);
        }
        echo "Escalas excluídas com sucesso!";
        header("Location: telaEscalaDeGuarda.php");

    }
}

if (isset($_GET['excluir'])) {
    $escala_id = $_GET['excluir'];
    $queryExcluir = "DELETE FROM escala_de_guarda WHERE id = '$escala_id'";
    if (mysqli_query($mysqli, $queryExcluir)) {
        echo "Escala excluída com sucesso!";
        header("Location: telaEscalaDeGuarda.php");

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
        header("Location: telaEscalaDeGuarda.php");

    } else {
        echo "Erro ao editar escala!";
    }
}


function isFeriado($data) {
    // Lista de feriados fixos e móveis
    $feriadosFixos = [
        date('Y') . '-01-01', // Ano Novo
        date('Y') . '-09-07', // Independência do Brasil
        date('Y') . '-12-25', // Natal
    ];

    // Adicione feriados móveis aqui, se necessário
    // Exemplo: Páscoa (usando cálculo ou banco de dados)

    return in_array($data, $feriadosFixos);
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
    <script src="../assets/js/scriptEscala.js" defer></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js" defer></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js" defer></script>

    <style>
        table {
            width: 80%;
            border-collapse: collapse;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            border-radius: 10px;
            overflow: hidden;
            margin-left: 200px;
        }

        /* Cabeçalho da tabela */
        th {
            background-color: #4CAF50;
            color: white;
            text-align: left;
            padding: 12px;
            font-weight: bold;
        }

        th input[type="checkbox"] {
            margin: 0;
        }

        /* Linhas da tabela */
        td {
            text-align: left;
            padding: 12px;
            border-bottom: 1px solid #ddd;
            vertical-align: top;
        }

        /* Estilo das linhas alternadas */
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        /* Estilos para as colunas P1 e P2 */
        td:nth-child(4), td:nth-child(5) {
            white-space: nowrap;
        }

        td input[type="checkbox"] {
            margin: 0;
        }


        /* Estilo para os campos especiais (final de semana e feriado) */
        .finalSemanaFeriado {
            background-color: #ffcccc !important;
        }

        .thSelecionarTudo{
            max-width: 100px;
        }

    </style>

    <title>Tóra</title>
</head>
<body>
    <?php include("../components/header.php"); ?>
    <?php include("../components/turmaMenu.php"); ?>
    
    <main class="mainGerarEscala">
        <div id="botaoAparecerGerarEscala" class="buttons" style="margin-bottom: 30px;">Gerar Escala</div>
        <div class="backFormEscala hide"></div>
        <form method="POST" class="formGerarEscala hide">
            <h2>Gerar Escala</h2>
            <p>se nenhuma data for escolhida, uma escala será gerada a partir de hoje.</p>
            <div class="inputBox">
                <input type="date" name="data_inicio" class="inputs" ><br>
                <label for="data_inicio" class="labelInput">Data de Início</label>
            </div>

            <div class="inputBox">
                <input type="number" name="num_dias" min="1" class="inputs" required><br>
                <label for="num_dias"  class="labelInput">Número de Dias</label>
            </div>

            
            <button type="submit" name="gerar_escala" class="buttons">Gerar Escalas</button>
            <a href="telaEscalaDeGuarda.php" class="buttons excluir">Cancelar</a>
        </form>

        <h2>Escalas Cadastradas</h2>
        <form method="POST" class="formEscalasCadastratas">
            <button type="submit" name="excluir_multiplas" class="buttons excluir" style="margin: 20px;">Excluir Selecionadas</button>    
            <table border="1">
                <thead>
                    <tr>
                        <th class="thSelecionarTudo">Selecionar Todos</br><input type="checkbox" id="selecionarTodos"></th>
                        <th>Data</th>
                        <th>Monitor</th>
                        <th>P1</th>
                        <th>P2</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($escala = mysqli_fetch_assoc($escalas)) {
                        $classeEspecial = '';
                        $dataEscala = $escala['data'];
                        $diaSemana = date('w', strtotime($dataEscala));

                        if ($diaSemana == 0 || $diaSemana == 6 || isFeriado($dataEscala)) {
                            $classeEspecial = 'finalSemanaFeriado';
                        }
                    ?>
                    <tr class="<?= $classeEspecial ?>">
                        <td><input type="checkbox" name="escalas_selecionadas[]" value="<?= $escala['id'] ?>"></td>
                        <td><?= $escala['data'] ?></td>
                        <td>
                            <?php
                            $monitor_id = $escala['id_monitor'];
                            $queryMonitor = "SELECT nome FROM usuarios WHERE id = '$monitor_id'";
                            $resultMonitor = mysqli_query($mysqli, $queryMonitor);
                            $monitor = mysqli_fetch_assoc($resultMonitor);
                            echo $monitor['nome'];
                            ?>
                        </td>
                        <td>
                            <?php
                            $atiradores_ids = explode(",", $escala['atiradores']);
                            $p1 = array_slice($atiradores_ids, 0, 3);
                            foreach ($p1 as $atirador_id) {
                                $queryAtirador = "SELECT nome FROM usuarios WHERE id = '$atirador_id'";
                                $resultAtirador = mysqli_query($mysqli, $queryAtirador);
                                $atirador = mysqli_fetch_assoc($resultAtirador);
                                echo $atirador['nome'] . "<br>";
                            }
                            ?>
                        </td>
                        <td>
                            <?php
                            $p2 = array_slice($atiradores_ids, 3, 3); 
                            foreach ($p2 as $atirador_id) {
                                $queryAtirador = "SELECT nome FROM usuarios WHERE id = '$atirador_id'";
                                $resultAtirador = mysqli_query($mysqli, $queryAtirador);
                                $atirador = mysqli_fetch_assoc($resultAtirador);
                                echo $atirador['nome'] . "<br>";
                            }
                            ?>
                        </td>
                        <td>
                            <a href="telaEscalaDeGuarda.php?editar=<?= $escala['id'] ?>" class='botao editar'>
                                <ion-icon name='pencil-sharp'></ion-icon>
                                <span class='tooltip'>Editar</span>
                            </a> |
                            <a href="telaEscalaDeGuarda.php?excluir=<?= $escala['id'] ?>" class='botao excluir' onclick="return confirm('Tem certeza que deseja excluir?')">
                                <ion-icon name='trash-outline'></ion-icon>
                                <span class='tooltip'>Excluir</span>
                            </a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>

        </form>

        <?php if (isset($_GET['editar'])) {
            $escala_id = $_GET['editar'];
            $queryEscalaEdit = "SELECT * FROM escala_de_guarda WHERE id = '$escala_id'";
            $resultEscalaEdit = mysqli_query($mysqli, $queryEscalaEdit);
            $escalaEdit = mysqli_fetch_assoc($resultEscalaEdit);
            ?>

            <div class="backFormEditarEscala"></div>
            <div class="formEditarEscala">
                <h2>Editar Escala</h2>
                <form method="POST">
                    <input type="hidden" name="escala_id" value="<?= $escalaEdit['id'] ?>">
                    <label for="data">Data</label>
                    <input type="date" name="data" value="<?= $escalaEdit['data'] ?>" required><br>

                    <label for="monitor_id">Monitor</label>
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

                    <label for="atiradores">Atiradores</label><br>
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

                    <button type="submit" name="editar_escala" class="buttons">Atualizar Escala</button>
                    <a href="telaEscalaDeGuarda.php" class="buttons excluir">Cancelar</a>
                </form>
            </div>
            <?php } ?>
    </main>

    <script>
        document.getElementById('selecionarTodos').addEventListener('click', function() {
            const checkboxes = document.querySelectorAll('input[type="checkbox"]'); 
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked; 
            });
        });
    </script>

</body>
</html>
