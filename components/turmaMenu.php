<?php
$id_patente = $_SESSION['id_patente'];
?>

<div id="backNavMenu" class="backNavMunu hide"></div>
<nav id="navMenu" class="navMunu hide">
    <div id="navLayout">
        <div id="titleNavMenu">
            <h3>TÓRA</h3>
            <ion-icon id="buttonCloseNav" size="large" name="close-outline"></ion-icon>
        </div>
        <div id="mainNavItem">
            <?php if($id_patente === '4'): ?>
                <a href="criarTurma.php">TURMAS</a>
                <a href="abrirTurma.php">NOTÍCIAS</a>
                <a href="">ESCALAS DE GUARDA</a>
                <a href="">CHAMADAS</a>
                <a href="">QTQ</a>
                <a href="profile.php">PERFIL</a>

            <?php elseif($id_patente === '3'): ?>
                <a href="criarTurma.php">TURMAS</a>
                <a href="abrirTurma.php">NOTÍCIAS</a>
                <a href="">ESCALAS DE GUARDA</a>
                <a href="">CHAMADAS</a>
                <a href="">QTQ</a>
                <a href="profile.php">PERFIL</a>

            <?php elseif($id_patente === '2'): ?>
                <a href="usuarioTurma.php">TURMAS</a>
                <a href="abrirTurma.php">NOTÍCIAS</a>
                <a href="">ESCALAS DE GUARDA</a>
                <a href="">CHAMADAS</a>
                <a href="">QTQ</a>
                <a href="profile.php">PERFIL</a>

            <?php else: ?>
                <a href="usuarioTurma.php">TURMAS</a>
                <a href="abrirTurma.php">NOTÍCIAS</a>
                <a href="">ESCALAS DE GUARDA</a>
                <a href="">CHAMADAS</a>
                <a href="">QTQ</a>
                <a href="profile.php">PERFIL</a>
            <?php endif; ?>

        </div>
        <div id="logoutNavItem">
            <a href="../authentication/logout.php"><ion-icon name="log-out-outline"></ion-icon>Sair</a>
        </div>
    </div>
</nav>