<?php
    include("../scripts/conexao.php");
    include("../scripts/protect.php");

    $id_patente = $_SESSION['id_patente'];
    //verificaAcesso(['sargento']);
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
   

    <main id="mainMenu">
    <button type="button" id="novaTurma" class="buttons">Nova turma</button>
    <div id="FormularioNovaTurma" class="hide">
        <h1>Nova turma</h1>
        <form action="../controllers/nova_turma.php" method="POST">
            <div class="inputBox">
                <input type="text" name="nomeTurma" id="nomeTurma" class="inputs" size="20" required>
                <label class="labelInput">Nome</label>
            </div>
            <div class="inputBox">
                <input type="number" name="anoTurma" id="anoTurma" class="inputs" size="20" min="2000" max="2200" required>
                <label class="labelInput">Ano</label>
            </div>
            <button type="submit" class="buttons">Entrar</button>
        </form>
    </div>
    <div>
        
    </div>

    </main>


</body>
</html>