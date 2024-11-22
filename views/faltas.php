<?php
    include("../scripts/conexao.php");
    include("../scripts/protect.php");

    $usuario_id = $_SESSION['id']; // ID do usuário logado
    $turma_id = $_SESSION['turma_id'];

    // Consultar as datas de falta
    $queryFaltas = "SELECT dc.data FROM chamada c
                    INNER JOIN data_chamada dc ON c.id_data_chamada = dc.id
                    WHERE c.id_usuario = '$usuario_id' AND c.id_status = 2 AND c.id_turma = '$turma_id'";
    $resultFaltas = mysqli_query($mysqli, $queryFaltas);
    if (!$resultFaltas) {
        die("Erro ao consultar faltas: " . mysqli_error($mysqli));
    }

    $faltas = [];
    while ($row = mysqli_fetch_assoc($resultFaltas)) {
        $faltas[] = date("d/m/Y", strtotime($row['data'])); // Adiciona as datas
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

    <main id="mainPerfil">
        <a href="suaFrequencia.php" class="buttons" style="margin-bottom:30px">Voltar</a>
        <div id="faltasContainer">
            <h3>Datas das suas faltas</h3>
            <?php
                if (count($faltas) > 0) {
                    foreach ($faltas as $data) {
                        echo "<p>$data</p>";
                    }
                } else {
                    echo "<p>Nenhuma falta registrada.</p>";
                }
            ?>
        </div>
    </main>
</body>
</html>
