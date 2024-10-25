<div id="backNavMenu" class="backNavMunu hide"></div>
<nav id="navMenu" class="navMunu hide">
    <div id="navLayout">
        <div id="titleNavMenu">
            <h3>TÓRA</h3>
            <ion-icon id="buttonCloseNav" size="large" name="close-outline"></ion-icon>
        </div>
        <div id="mainNavItem">
            
            <?php if($id_patente === '1'): ?>
                <a href="home.php">MENU</a>
                <a href="">ESCALA DE GUARDA</a>
                <a href="">QTQ</a>
                <a href="profile.php">PERFIL</a>
            <?php elseif($id_patente === '2'): ?>
                <a href="home.php">MENU</a>
                <a href="">ESCALA DE GUARDA</a>
                <a href="">QTQ</a>
                <a href="profile.php">PERFIL</a>
                <a href="home.php">MENU</a>
                <a href="">ESCALA DE GUARDA</a>
                <a href="">QTQ</a>
                <a href="profile.php">PERFIL</a>

            <?php else: ?>
                <p>Insira o nome da turma</p>
            <?php endif; ?>

        </div>
        <div id="logoutNavItem">
            <a href="../authentication/logout.php"><ion-icon name="log-out-outline"></ion-icon>Sair</a>
        </div>
    </div>
</nav>