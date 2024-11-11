<?php
include("../scripts/conexao.php");
include("../scripts/protect.php");

$id_patente = $_SESSION['id_patente'];
$usuario_id = $_SESSION['id']; // ID do usuário logado

// Verifica se existe uma busca e ajusta a consulta SQL
$search_query = "";
if (isset($_POST['search'])) {
    $search_term = mysqli_real_escape_string($mysqli, $_POST['search']); // Protege contra SQL Injection
    $search_query = "WHERE nome LIKE '%$search_term%' OR ano LIKE '%$search_term%'";
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
            <!-- Formulário de busca -->
            <form action="encontrarTurma.php" method="POST" class="search-form">
                <input type="text" name="search" placeholder="Pesquisar" value="<?php echo isset($search_term) ? $search_term : ''; ?>" />
                <button type="submit">Buscar</button>
            </form>

            <?php
                // Consultando as turmas com base na pesquisa (se houver)
                $query = "SELECT * FROM turma $search_query";
                $result = mysqli_query($mysqli, $query) or die(mysqli_connect_error());

                if(mysqli_num_rows($result) > 0) {
                    while ($reg = mysqli_fetch_array($result)) {
                        // Verificar se o usuário já fez uma solicitação para essa turma
                        $turma_id = $reg['id'];
                        $check_query = "SELECT * FROM solicitacoes WHERE usuario_id = '$usuario_id' AND turma_id = '$turma_id' AND status = 'pendente'";
                        $check_result = mysqli_query($mysqli, $check_query);
                        
                        if (mysqli_num_rows($check_result) > 0) {
                            // O usuário já fez a solicitação
                            echo "<div class='listaTurmas'>
                                    <div class='containerInfoTurma'>
                                        <h3>{$reg['nome']}</h3>
                                        <p>{$reg['ano']}</p>
                                    </div>
                                    <div class='containerAcoesTurma'>
                                        <a href='cancelarSolicitacao.php?id={$reg['id']}' class='buttons excluir'>
                                            Cancelar
                                        </a>
                                    </div>
                                  </div>";
                        } else {
                            // O usuário ainda não fez a solicitação
                            echo "<div class='listaTurmas'>
                                    <div class='containerInfoTurma'>
                                        <h3>{$reg['nome']}</h3>
                                        <p>{$reg['ano']}</p>
                                    </div>
                                    <div class='containerAcoesTurma'>
                                        <a href='solicitarAcesso.php?id={$reg['id']}' class='buttons'>
                                            Participar
                                        </a>
                                    </div>
                                  </div>";
                        }
                    }
                } else {
                    echo "Nenhuma turma encontrada!";
                }
            ?>
        </div>
    </main>
</body>
</html>
