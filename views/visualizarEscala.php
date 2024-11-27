<?php
include("../scripts/conexao.php");
include("../scripts/protect.php");

date_default_timezone_set('America/Sao_Paulo');

$id_patente = $_SESSION['id_patente'];
$turma_id = $_SESSION['turma_id'];

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

        <h2>Escalas Cadastradas</h2>
        <form method="POST" class="formEscalasCadastratas" > 
            <table border="1" class="tableVisualizarEscala">
                <thead>
                    <tr>
                        <th>Data</th>
                        <th>Monitor</th>
                        <th>P1</th>
                        <th>P2</th>
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
                        <td><?= date('d/m/Y', strtotime($escala['data'])) ?></td>

                        <td>
                            <?php
                            $monitor_id = $escala['id_monitor'];
                            $queryMonitor = "SELECT nome FROM usuarios WHERE id = '$monitor_id'";
                            $resultMonitor = mysqli_query($mysqli, $queryMonitor);
                            $monitor = mysqli_fetch_assoc($resultMonitor);
                            
                            if ($monitor) {
                                echo $monitor['nome'];
                            } else {
                                echo "Nenhum monitor atribuído"; 
                            }
                            ?>
                        </td>

                        <td>
                            <?php
                            $atiradores_ids = explode(",", $escala['atiradores']);
                            $p1 = array_slice($atiradores_ids, 0, 3);
                            $p1Nomes = [];

                            foreach ($p1 as $atirador_id) {
                                $queryAtirador = "SELECT nome FROM usuarios WHERE id = '$atirador_id'";
                                $resultAtirador = mysqli_query($mysqli, $queryAtirador);
                                $atirador = mysqli_fetch_assoc($resultAtirador);
                                
                                if ($atirador) {
                                    $p1Nomes[] = $atirador['nome'];
                                }
                            }


                            if (empty($p1Nomes)) {
                                echo "Nenhum atirador atribuído";
                            } else {
                                echo implode("<br>", $p1Nomes);
                            }
                            ?>
                        </td>

                        <td>
                            <?php
                            $p2 = array_slice($atiradores_ids, 3, 3); 
                            $p2Nomes = [];

                            foreach ($p2 as $atirador_id) {
                                $queryAtirador = "SELECT nome FROM usuarios WHERE id = '$atirador_id'";
                                $resultAtirador = mysqli_query($mysqli, $queryAtirador);
                                $atirador = mysqli_fetch_assoc($resultAtirador);

                                if ($atirador) {
                                    $p2Nomes[] = $atirador['nome'];
                                }
                            }

                            if (empty($p2Nomes)) {
                                echo "Nenhum atirador atribuído";
                            } else {
                                echo implode("<br>", $p2Nomes);
                            }
                            ?>
                        </td>
                    
                    </tr>
                    <?php } ?>
                </tbody>
            </table>

        </form>
    </main>
</body>
</html>
