<?php
include("../scripts/conexao.php");
include("../scripts/protect.php");

$user_id = $_SESSION['id']; 
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
            <h2>Suas turmas</h2>
            <?php
                $query = "
                    SELECT t.*
                    FROM turma t
                    INNER JOIN turma_usuario u ON t.id = u.id_turma
                    WHERE u.id_usuario = '$user_id';
                ";
                
                $result = mysqli_query($mysqli, $query) or die(mysqli_connect_error());

                if(mysqli_num_rows($result) > 0) {
                    while ($reg = mysqli_fetch_array($result)) {
                        $turma_id = $reg['id'];
                        echo "  
                        <div class='listaTurmas'>
                            <div class='containerInfoTurma'>
                                <a href='#' onclick='abrirTurma({$turma_id})' class='linkAbrir'></a>
                                    <h3>{$reg['nome']}</h3>
                                    <p>{$reg['ano']}</p>
                            </div>
                        </div>";
                    }
                } else {
                    echo "Nenhuma turma cadastrada!";
                }
            ?>
        </div>
    </main>

    <script>
        function abrirTurma(turmaId) {
            fetch(`abrirTurma.php?turma_id=${turmaId}`)
                .then(() => window.location.href = 'abrirTurma.php');
        }
    </script>
</body>
</html>
