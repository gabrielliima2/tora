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
    $telefone = mysqli_real_escape_string($mysqli, $_POST['telefone']);
    
    $fotoPath = $reg['foto']; // Caminho atual da foto
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $foto = $_FILES['foto'];
        $fotoName = uniqid() . "_" . basename($foto['name']);
        $novoFotoPath = "../perfilPicture/" . $fotoName;

        // Movendo o arquivo para a pasta de uploads
        if (move_uploaded_file($foto['tmp_name'], $novoFotoPath)) {
            // Excluindo a foto antiga, se existir
            if (!empty($fotoPath) && file_exists($fotoPath)) {
                unlink($fotoPath);
            }
            $fotoPath = $novoFotoPath;
        } else {
            echo "<script>alert('Erro ao fazer upload da imagem.');</script>";
        }
    }

    $updateQuery = "UPDATE usuarios 
                    SET foto = '$fotoPath' 
                    WHERE id = '$id'";

    if (mysqli_query($mysqli, $updateQuery)) {
        header("location: profile.php");
    } else {
        echo "<script>alert('Erro ao atualizar o perfil.');</script>";
    }
}

// Excluir foto de perfil
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['excluirFoto'])) {
    if (!empty($reg['foto']) && file_exists($reg['foto'])) {
        unlink($reg['foto']); // Exclui a foto atual
    }

    $updateQuery = "UPDATE usuarios SET foto = NULL WHERE id = '$id'";
    if (mysqli_query($mysqli, $updateQuery)) {
        header("location: profile.php");
    } else {
        echo "<script>alert('Erro ao excluir a foto de perfil.');</script>";
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
    <?php include("../components/menu.php"); ?>

    <main id="mainPerfil">
        <div class="FormularioEditarFotoPerfil">
            <h1>Alterar foto</h1>
            <form method="POST" enctype="multipart/form-data" class="formNovaTurma">
                <input type="hidden" name="id" value="<?php echo $id; ?>">

                <div class="inputBox" style="display: flex; flex-direction: column; margin-bottom:30px">
                        <?php if (!empty($reg['foto'])): ?>
                            <label for="foto" class="fotoPerfilContainer">
                                <img src="<?php echo $reg['foto']; ?>" alt="Foto de perfil" class="fotoPerfil">
                                <span class="trocarFotoTexto">Trocar Foto</span>
                            </label>
                        <?php else: ?>
                            <label for="foto" class="fotoPerfilContainer">
                                <ion-icon class="fotoPerfil" name="person-circle-outline"></ion-icon>
                                <span class="trocarFotoTexto">Adicionar foto</span>
                            </label>
                        <?php endif; ?>
                        
                        <input type="file" name="foto" id="foto" class="inputs hide">
                       
                    </div>  
                <div class="buttonsAcoesTurma" style="gap:20px;">
                    <input type="submit" class="buttons criarTurma" name="atualizar" value="Salvar">
                    <a href="profile.php" class="buttons excluir" name="cancelar">Cancelar</a>
                </div>
            </form>
        </div>
        <?php if (!empty($reg['foto'])): ?>

            <form method="POST" class="formExcluirFoto" style="margin-top: 10px;">
                <input type="hidden" name="excluirFoto" value="1">
                <button type="submit" class="buttons excluir">Remover Foto</button>
            </form>      
        <?php endif; ?>
    </main>
</body>
</html>
