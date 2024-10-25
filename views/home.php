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
        <div class="posts">
            <h1>Seja bem-vindo, <?php echo $_SESSION['username']?>!</h1>
            <p>
            Tóra é um sistema desenvolvido especificamente para o Tiro de Guerra, projetado para otimizar e facilitar o gerenciamento de dados dos atiradores. 
            <br><br>Ele visa automatizar processos administrativos, como o controle de presença, faltas, quadros de trabalhos, e escalas de guarda, proporcionando maior eficiência e precisão nas operações diárias. 
            <br><br>Com uma interface intuitiva e funcionalidades voltadas para todos membros da organização, atiradores, monitores e superiores, o Tóra garante uma visão abrangente de todas as atividades, permitindo uma gestão mais eficaz e organizada, além de melhorar o fluxo de informações entre os envolvidos.</p>
        </div>
    </main>


</body>
</html>