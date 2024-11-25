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
                <a href="home.php">INÍCIO</a>
                <a href="abrirTurma.php">NOTÍCIAS</a>
                <a href="participantes.php">PARTICIPANTES</a>
                <a href="visualizarSolicitacoes.php">SOLICITAÇÕES</a>
                <a href="telaChamada.php">CHAMADAS</a>
                <a href="suaFrequencia.php">FREQUENCIAS</a>
                <a href="telaEscalaDeGuarda.php">ESCALAS</a>
                <a href="">QTQ</a>
                <a href="turmaPerfil.php">PERFIL</a>

            <?php elseif($id_patente === '3'): ?>
                <a href="home.php">INÍCIO</a>
                <a href="criarTurma.php">TURMAS</a>
                <a href="telaChamada.php">CHAMADAS</a>
                <a href="suaFrequencia.php">FREQUENCIAS</a>
                <a href="telaEscalaDeGuarda.php">ESCALAS</a>
                <a href="">QTQ</a>
                <a href="turmaPerfil.php">PERFIL</a>

            <?php elseif($id_patente === '2'): ?>
                <a href="home.php">INÍCIO</a>
                <a href="abrirTurma.php">NOTÍCIAS</a>
                <a href="telaChamada.php">CHAMADAS</a>
                <a href="suaFrequencia.php">FREQUENCIAS</a>
                <a href="telaEscalaDeGuarda.php">ESCALAS</a>
                <a href="">QTQ</a>
                <a href="turmaPerfil.php">PERFIL</a>

            <?php else: ?>
                <a href="home.php">INÍCIO</a>
                <a href="abrirTurma.php">NOTÍCIAS</a>
                <a href="suaFrequencia.php">FREQUENCIAS</a>
                <a href="telaEscalaDeGuarda.php">ESCALAS</a>
                <a href="">QTQ</a>
                <a href="turmaPerfil.php">PERFIL</a>
            <?php endif; ?>

        </div>
        <div id="logoutNavItem">
            <a href="../authentication/logout.php"><ion-icon name="log-out-outline"></ion-icon>Sair</a>
        </div>
    </div>
</nav>