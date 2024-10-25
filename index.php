<?php
include('scripts/conexao.php');
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500&display=swap" rel="stylesheet">

    <link rel="shortcut icon" href="assets/military_icon.png" type="image/x-icon">
    <link rel="stylesheet" href="assets/css/style.css">

    <title>Tóra</title>

</head>
<body>
    <main id="mainLogin">
        <h1>TÓRA</h1>
        <form action="authentication/login.php" method="POST" id="formLogin">
            <div class="inputBox">
                <input type="text" name="email" id="email" class="inputs" size="30" required>
                <label class="labelInput">Email</label>
            </div>
            <div class="inputBox">
                <input type="password" name="senha" id="senha" class="inputs" size="30" required>
                <label class="labelInput">Senha</label>
            </div>
            <button type="submit" class="buttons">Entrar</button>
        </form>
        <p>Não tem uma conta? <a href="views/cadastro.php" style="color: rgb(0, 136, 255);">Cadastre-se</a></p>
    </main>
    <footer id="footerLogin">
        <h3>SUPORTE</h3>
    </footer>
</body>
</html>