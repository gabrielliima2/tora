<?php
    include("../scripts/conexao.php");
    include("../scripts/protect.php");

    $id_patente = $_SESSION['id_patente'];
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

    <?php
        $query = "SELECT * FROM usuarios WHERE id = '$_SESSION[id]'";
        $resu = mysqli_query($mysqli, $query) or die(mysqli_connect_error());
        if($resu){
            $reg = mysqli_fetch_array($resu);
            echo "";
        }
    ?>
            
    <main id="mainMenu">
        <div id="perfilContainer">
            <div id="perfilName">
                <h3><?php echo $reg['nome']?></h3>

            </div>

            <div class="perfilElements">
                <h3>PRESENÇAS</h3>
                <h4><?php echo $reg['nome']?></h4>
            </div>
            <div class="perfilElements">
                <h3>FALTAS</h3>
                <h4><?php echo $reg['nome']?></h4>
            </div>

            <div class="perfilElements">
                <h3>TEMPO</h3>
                <h4><?php echo $reg['nome']?></h4>
            </div>
        </div>
        <a href='alterarPerfil.php' class='botao editar'>
            <ion-icon name='pencil-sharp'></ion-icon>
            <span class='tooltip'>Editar</span>
        </a>
    </main>
</body>
</html>