<?php
// Inclui o arquivo de conexão e verifica se o usuário está logado
include('conexao.php');
include("protect.php");

// Obtém a patente do usuário logado
$patente = $_SESSION['patente'];

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Home - Tóra</title>
</head>
<body>
    <main id="mainHome">
        <h1>Bem-vindo, <?php echo $_SESSION['nome']; ?>!</h1>

        <!-- Exibe os botões de acordo com a patente -->
        <?php if($patente === 'Sargento' || $patente === 'Subtenente'): ?>
            <button class="buttons" onclick="window.location.href='chamada.php'">Chamada</button>
        <?php elseif($patente === 'Atirador'): ?>
            <button class="buttons" onclick="window.location.href='escala_guarda.php'">Escala de Guarda</button>
        <?php elseif($patente === 'Monitor'): ?>
            <button class="buttons" onclick="window.location.href='qtq.php'">QTQ</button>
            <?php else: ?>
            <p>Patente desconhecida.</p>
        <?php endif; ?>
    </main>

    <footer id="footerHome">
        <h3>SUPORTE</h3>
    </footer>
</body>
</html>
