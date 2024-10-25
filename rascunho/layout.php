<?php

include("protect.php");

?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@500&display=swap" rel="stylesheet">    

    <link rel="stylesheet" href="style.css">
    <script src="script.js" defer></script>

    <title>Tóra</title>

</head>
<body>
    <header id="mainHeader">
        <!-- <h3><?php //echo $_SESSION['nome']?></h3> -->
        <h1>TÓRA</h1>
        <div class="openNavMenuButton">
            <ion-icon id="buttonOpenNav" size="large" name="menu"></ion-icon>
        </div>
    </header>

    <div id="backNavMenu" class="backNavMunu hide"></div>
        <nav id="navMenu" class="navMunu hide">
            <div class="navLayout">
                <div class="titleNavMenu">
                    <h3>TÓRA</h3>
                    <ion-icon id="buttonCloseNav" size="large" name="close-outline"></ion-icon>
                </div>
                <div class="mainNavItem">
                    <a href="home.php">MENU</a>
                    <a href="">ESCALA DE GUARDA</a>
                    <a href="">QTQ</a>
                    <a href="">PERFIL</a>
                </div>
                <div class="logoutNavItem">
                    <a href="logout.php"><ion-icon name="log-out-outline"></ion-icon>Sair</a>
                </div>
            </div>
        </nav>

    <main id="mainMenu">

    </main>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>