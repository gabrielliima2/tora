<?php
session_start();
include("../scripts/conexao.php");
include("../scripts/protect.php");
$id_patente = $_SESSION['id_patente'];
 
if (!isset($_SESSION['id'])) {
    echo "<script>alert('Usuário não está logado.'); window.location='login.php';</script>";
    exit();
}
 
$id = $_SESSION['id'];  
 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['confirmar'])) {
        $query = "DELETE FROM usuarios WHERE id = '$id'";
        if (mysqli_query($mysqli, $query)) {
 
            session_destroy();
            echo "<script>alert('Conta deletada com sucesso!'); window.location='../index.php';</script>";
        } else {
            echo "<script>alert('Erro ao excluir a conta.');</script>";
        }
    }
 
    if (isset($_POST['cancelar'])) {
        header("Location: alterarPerfil.php");
        exit();
    }
}
?>
 
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/style.css">
    <script src="../assets/js/script.js" defer></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js" defer></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js" defer></script>
 
    <title>Excluir Conta</title>
</head>
<body>
    <?php include("../components/header.php"); ?>
    <?php include("../components/menu.php"); ?>
 
    <main id="mainPerfil">
        <div class="FormularioNovaTurma">
            <h1>Deseja excluir sua conta?</h1>
            <p>Essa ação não podera ser desfeita</p>
 
            <form method="POST">
                <div class="buttonsAcoesTurma" style="gap:30px;">
                    <input type="submit" class="buttons criarTurma" name="confirmar" value="Sim">
                    <a href="alterarPerfil.php" class="buttons excluir" name="cancelar">Cancelar</a>
                </div>
            </form>
        </div>
    </main>
</body>
</html>