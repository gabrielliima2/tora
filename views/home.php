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

    <title>Tóra</title>
</head>
<body>
    <header id="mainHeader">
        <div class="openNavMenuButton">
            <ion-icon id="buttonOpenNav" size="large" name="menu"></ion-icon>
        </div>
        <h1>TÓRA</h1>
        <div class="profileImage">
            <a href="profile.php"><ion-icon name="person-circle-outline"></ion-icon></a>
        </div>
    </header>
    <div id="backNavMenu" class="backNavMunu hide"></div>
        <nav id="navMenu" class="navMunu hide">
            <div id="navLayout">
                <div id="titleNavMenu">
                    <h3>TÓRA</h3>
                    <ion-icon id="buttonCloseNav" size="large" name="close-outline"></ion-icon>
                </div>
                <div id="mainNavItem">
                    <a href="home.php">MENU</a>
                    <a href="">ESCALA DE GUARDA</a>
                    <a href="">QTQ</a>
                    <a href="profile.php">PERFIL</a>
                </div>
                <div id="logoutNavItem">
                    <a href="../authentication/logout.php"><ion-icon name="log-out-outline"></ion-icon>Sair</a>
                </div>
            </div>
        </nav>

    <main id="mainMenu">
        <div class="posts">
            <h1>Seja bem-vindo, <?php echo $_SESSION['username']?>!</h1>
            <p>
            Tóra é um sistema desenvolvido especificamente para o Tiro de Guerra, projetado para otimizar e facilitar o gerenciamento de dados dos atiradores. 
            <br><br>Ele visa automatizar processos administrativos, como o controle de presença, faltas, quadros de trabalhos, e escalas de guarda, proporcionando maior eficiência e precisão nas operações diárias. 
            <br><br>Com uma interface intuitiva e funcionalidades voltadas para todos membros da organização, atiradores, monitores e superiores, o Tóra garante uma visão abrangente de todas as atividades, permitindo uma gestão mais eficaz e organizada, além de melhorar o fluxo de informações entre os envolvidos.</p>
        </div>
        <?php if($id_patente === '1'): ?>
            <button class="buttons" onclick="window.location.href='chamada.php'">Chamada</button>
        <?php elseif($id_patente === '2'): ?>
            <button class="buttons" onclick="window.location.href='escala_guarda.php'">Escala de Guarda</button>

        <?php elseif($id_patente === '3'): ?>
            <button class="buttons" onclick="window.location.href='qtq.php'">QTQ</button>
            <?php else: ?>
            <p>Insira o nome da turma</p>
            <form action="" method="POST">
                <label for="nome_turma">Insira o nome da turma</label>
                <input type="text" id="nome_turma">
            </form>
        <?php endif; ?>
    </main>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>