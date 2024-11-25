<?php
    include("../scripts/conexao.php");
    include("../scripts/protect.php");

    $id_patente = $_SESSION['id_patente'];
    $usuario_id = $_SESSION['id']; 
    $turma_id = $_SESSION['turma_id'];

    $query = "SELECT * FROM usuarios WHERE id = '$usuario_id'";
    $resu = mysqli_query($mysqli, $query) or die(mysqli_connect_error());
    if ($resu) {
        $reg = mysqli_fetch_array($resu);
    }


    $queryPresencas = "SELECT COUNT(*) AS total_presencas FROM chamada WHERE id_usuario = '$usuario_id' AND id_status = 1 AND id_turma = '$turma_id' ";
    $resultPresencas = mysqli_query($mysqli, $queryPresencas);
    $presencas = mysqli_fetch_assoc($resultPresencas)['total_presencas'];

    $queryFaltas = "SELECT COUNT(*) AS total_faltas FROM chamada WHERE id_usuario = '$usuario_id' AND id_status = 2 AND id_turma = '$turma_id' ";
    $resultFaltas = mysqli_query($mysqli, $queryFaltas);
    $faltas = mysqli_fetch_assoc($resultFaltas)['total_faltas'];
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

    <main id="mainMenu">
        <div id="perfilContainer">
            <div id="perfilName" style="justify-content: center;">
                <h3><?php echo htmlspecialchars($reg['nome'], ENT_QUOTES, 'UTF-8'); ?></h3>
            </div>

            <a href="presencas.php" class="perfilElements">
                <h3>PRESENÇAS</h3>
                <div class="frequenciaInfoBanco">
                    <h4><?php echo $presencas; ?></h4>
                </div>
            </a>
            <a href="faltas.php" class="perfilElements">
                <h3>FALTAS</h3> 
                <div class="frequenciaInfoBanco">
                    <h4><?php echo $faltas; ?></h4>
                </div>
            </a>
        </div>
    </main>

</body>
</html>
