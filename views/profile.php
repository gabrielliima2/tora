<?php

include("../scripts/protect.php");

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
        <div id="perfilContainer">
            <div id="perfilName">
                <h3><?php echo $_SESSION['username']?></h3>
            </div>

            <div class="perfilElements">
                <h3>PRESENÇAS</h3>
                <h4><?php echo $_SESSION['username']?></h4>
            </div>
            <div class="perfilElements">
                <h3>FALTAS</h3>
                <h4><?php echo $_SESSION['username']?></h4>
            </div>

            <div class="perfilElements">
                <h3>TEMPO</h3>
                <h4><?php echo $_SESSION['username']?></h4>
            </div>
        </div>
    </main>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>