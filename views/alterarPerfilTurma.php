<?php
include("../scripts/conexao.php");
include("../scripts/protect.php");
$id_patente = $_SESSION['id_patente'];


$id = $_SESSION['id'];  

$query = "SELECT * FROM usuarios WHERE id = '$id'";
$resu = mysqli_query($mysqli, $query) or die(mysqli_connect_error());
if ($resu) {
    $reg = mysqli_fetch_array($resu);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['atualizar'])) {
    $nome = mysqli_real_escape_string($mysqli, $_POST['nomeUsuario']);
    $dataNascimento = mysqli_real_escape_string($mysqli, $_POST['dataNascimento']);
    $endereco = mysqli_real_escape_string($mysqli, $_POST['endereco']);
    $bairro = mysqli_real_escape_string($mysqli, $_POST['bairro']);
    $cidade = mysqli_real_escape_string($mysqli, $_POST['cidade']);
    $estado = mysqli_real_escape_string($mysqli, $_POST['estado']);
    $telefone = mysqli_real_escape_string($mysqli, $_POST['telefone']);
    
    

    $updateQuery = "UPDATE usuarios 
                    SET nome = '$nome', nascimento = '$dataNascimento', endereco = '$endereco', 
                        bairro = '$bairro', cidade = '$cidade', estado = '$estado', telefone = '$telefone'
                    WHERE id = '$id'";

    if (mysqli_query($mysqli, $updateQuery)) {
        header("location: turmaPerfil.php");
    } else {
        echo "<script>alert('Erro ao atualizar o perfil.');</script>";
    }
}

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
    <?php include("../components/turmaMenu.php"); ?>

    <main id="mainPerfil">
        <div class="FormularioNovaTurma">
            <h1>Editar Perfil</h1>
            <form method="POST" enctype="multipart/form-data" class="formNovaTurma">
                <input type="hidden" name="id" value="<?php echo $id; ?>">

                <div class="containerEditarPerfil">
                <div class="inputBox" style="display: flex; flex-direction: column; margin-bottom:30px">

                        <?php if (!empty($reg['foto'])): ?>
                            <a href="alterarFotoPerfilTurma.php" class="fotoPerfilContainer">
                                <img src="<?php echo $reg['foto']; ?>" alt="Foto de perfil" class="fotoPerfil">
                                <span class="trocarFotoTexto">Trocar Foto</span>
                            </a>
                        <?php else: ?>
                            <a href="alterarFotoPerfilTurma.php" class="fotoPerfilContainer">
                                <ion-icon class="fotoPerfil" name="person-circle-outline"></ion-icon>
                                <span class="trocarFotoTexto">Adicionar foto</span>
                            </a>
                        <?php endif; ?>

                    </div>
                    <div class="inputBox">
                        <input type="text" name="nomeUsuario" id="nomeUsuario" class="inputs" value="<?php echo !empty($reg['nome']) ? $reg['nome'] : ''; ?>" required>
                        <label class="labelInput">Nome</label>
                    </div>
                    <div class="inputBox">
                        <input type="date" name="dataNascimento" id="dataNascimento" class="inputs" value="<?php echo !empty($reg['nascimento']) ? $reg['nascimento'] : ''; ?>">
                        <label class="labelInput">Data de Nascimento</label>
                    </div>
                    <div class="inputBox">
                        <input type="text" name="endereco" id="endereco" class="inputs" value="<?php echo !empty($reg['endereco']) ? $reg['endereco'] : ''; ?>">
                        <label class="labelInput">Endereço</label>
                    </div>
                    <div class="inputBox">
                        <input type="text" name="bairro" id="bairro" class="inputs" value="<?php echo !empty($reg['bairro']) ? $reg['bairro'] : ''; ?>">
                        <label class="labelInput">Bairro</label>
                    </div>
                    <div class="inputBox">
                        <input type="text" name="cidade" id="cidade" class="inputs" value="<?php echo !empty($reg['cidade']) ? $reg['cidade'] : ''; ?>">
                        <label class="labelInput">Cidade</label>
                    </div>
                    <div class="inputBox">
                        <input type="text" name="estado" id="estado" class="inputs" value="<?php echo !empty($reg['estado']) ? $reg['estado'] : ''; ?>">
                        <label class="labelInput">Estado</label>
                    </div>
                    <div class="inputBox">
                        <input type="text" name="telefone" id="telefone" class="inputs" value="<?php echo !empty($reg['telefone']) ? $reg['telefone'] : ''; ?>">
                        <label class="labelInput">Telefone</label>
                    </div>
                    <div class="inputBox">
                       
                    </div>
                    
                </div>
                <div class="buttonsAcoesTurma">
                    <input type="submit" class="buttons criarTurma" name="atualizar" value="Salvar">
                    <a href="turmaPerfil.php" class="buttons excluir" name="cancelar">Cancelar</a>
                </div>
            </form>
        </div>
        <a href="excluirContaTurma.php" style="margin-top: 20px;" class="buttons excluir" name="cancelar">Deletar conta</a>
    </main>
</body>
</html>
