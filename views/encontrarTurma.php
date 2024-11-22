<?php
include("../scripts/conexao.php");
include("../scripts/protect.php");

$id_patente = $_SESSION['id_patente'];
$usuario_id = $_SESSION['id'];

$search_query = "";
if (isset($_POST['search'])) {
    $search_term = mysqli_real_escape_string($mysqli, $_POST['search']); 
    $search_query = "WHERE nome LIKE '%$search_term%' OR ano LIKE '%$search_term%'";
}


if (isset($_POST['turma_id'])) {
    $_SESSION['turma_id'] = $_POST['turma_id'];
    header("Location: abrirTurma.php");
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
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js" defer></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js" defer></script>
    <title>Tóra</title>
</head>
<body>
    <?php include("../components/header.php"); ?>
    <?php include("../components/menu.php"); ?>
    
    <main id="mainTurma">
        <div class="containerListaTurma">
            <form action="encontrarTurma.php" method="POST" class="search-form">
                <input type="text" name="search" placeholder="Pesquisar" value="<?php echo isset($search_term) ? $search_term : ''; ?>" />
                <button type="submit">Buscar</button>
            </form>

            <?php
                $query = "SELECT * FROM turma $search_query";
                $result = mysqli_query($mysqli, $query) or die(mysqli_connect_error());

                if (mysqli_num_rows($result) > 0) {
                    while ($reg = mysqli_fetch_array($result)) {
                        $turma_id = $reg['id'];

                        $check_query = "SELECT * FROM solicitacoes WHERE usuario_id = '$usuario_id' AND turma_id = '$turma_id' AND status = 'pendente'";
                        $check_result = mysqli_query($mysqli, $check_query);
                        $is_pending = mysqli_num_rows($check_result) > 0;

                        $in_turma_query = "SELECT * FROM turma_usuario WHERE id_usuario = '$usuario_id' AND id_turma = '$turma_id'";
                        $in_turma_result = mysqli_query($mysqli, $in_turma_query);
                        $is_in_turma = mysqli_num_rows($in_turma_result) > 0;
                        
                        echo "<div class='listaTurmas'>
                                <div class='containerInfoTurma'>
                                    <h3>" . htmlspecialchars($reg['nome']) . "</h3>
                                    <p>" . htmlspecialchars($reg['ano']) . "</p>
                                </div>
                                <div class='containerAcoesTurma'>";

                        if ($is_pending) {
                            echo "<a href='cancelarSolicitacao.php?id={$turma_id}' class='buttons excluir'>
                                     Cancelar
                                    <span class='tooltip' style='width: 120px;'>Cancelar solicitação</span>
                                  </a>";
                        } elseif ($is_in_turma) {
                            echo "<form action='encontrarTurma.php' method='POST'>
                                        <input type='hidden' name='turma_id' value='{$turma_id}'>
                                        <button type='submit' class='buttons'>Acessar
                                        </button>
                                  </form>";
                        } else {
                            echo "<a href='solicitarAcesso.php?id={$turma_id}' class='buttons editar'>
                                    Participar
                                    <span class='tooltip' style='width: 100px;'>Solicitar entrada</span>
                                  </a>";
                        }

                        echo "  </div>
                              </div>";
                    }
                } else {
                    echo "Nenhuma turma encontrada!";
                }
            ?>
        </div>
    </main>
</body>
</html>
