<?php
session_start();
include("../scripts/conexao.php");
include("../scripts/protect.php");

if (!isset($_SESSION['noticia_editar_id'])) {
    header("Location: abrirTurma.php");
    exit();
}

$noticia_id = $_SESSION['noticia_editar_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $descricao = $_POST['descricao'];


    $query_get_image = $mysqli->prepare("SELECT imagem FROM noticias WHERE id = ?");
    $query_get_image->bind_param("i", $noticia_id);
    $query_get_image->execute();
    $result_image = $query_get_image->get_result();
    $noticia_atual = $result_image->fetch_assoc();
    $imagem_atual = $noticia_atual['imagem'];

    $imagem_caminho = $imagem_atual;


    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
        $extensao = pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION);
        $nome_unico = uniqid('img_') . '.' . $extensao;
        $novo_caminho = "../uploads/" . $nome_unico;


        if (move_uploaded_file($_FILES['imagem']['tmp_name'], $novo_caminho)) {

            if ($imagem_atual && file_exists($imagem_atual)) {
                unlink($imagem_atual);
            }
            $imagem_caminho = $novo_caminho;
        } else {
            echo "Erro ao fazer upload da nova imagem!";
        }
    }

    $query_update = $mysqli->prepare("UPDATE noticias SET titulo = ?, descricao = ?, imagem = ? WHERE id = ?");
    $query_update->bind_param("sssi", $titulo, $descricao, $imagem_caminho, $noticia_id);

    if ($query_update->execute()) {
        unset($_SESSION['noticia_editar_id']);
        header("Location: abrirTurma.php?turma_id=" . $_SESSION['turma_id']);
        exit();
    } else {
        echo "Erro ao atualizar a notícia: " . $mysqli->error;
    }
}

$query_noticia = $mysqli->prepare("SELECT titulo, descricao FROM noticias WHERE id = ?");
$query_noticia->bind_param("i", $noticia_id);
$query_noticia->execute();
$result_noticia = $query_noticia->get_result();

if ($result_noticia->num_rows === 0) {
    echo "Notícia não encontrada!";
    exit();
}

$noticia = $result_noticia->fetch_assoc();
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
    <script src="../assets/js/scriptNoticia.js" defer></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js" defer></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js" defer></script>
    <title>Tóra</title>
</head>
<body>
    <?php include("../components/header.php"); ?>
    <?php include("../components/turmaMenu.php"); ?>
    <main id="mainNoticias">
        <div class="containerNewPost">
            <div class="containerCloseNews">
                <form action="" method="POST" enctype="multipart/form-data" class="formNewPost">
                    <div class="inputBox">
                                <input type="text" name="titulo" id="titulo" class="inputs" maxlength="150" value="<?php echo htmlspecialchars($noticia['titulo']); ?>" required>
                                <label class="labelInput">Título</label>
                            </div>
                            <div class="inputBox">
                                <textarea name="descricao" id="descricao" maxlength="300" style="resize: none" class="inputs textareas" required><?php echo htmlspecialchars($noticia['descricao']); ?></textarea>
                                <label class="labelInput">Descrição (até 300 letras)</label>
                            </div>
                    <div class="inputBox">
                        <input type="file" name="imagem" id="imagem" class="inputs">
                        <label class="labelInput">Selecione uma imagem</label>
                    </div>
                    <button type="submit" class="buttons editar">Salvar</button>
                    <a href="abrirTurma.php" class="buttons excluir">Cancelar</a>
                </form>
            </div>
        </div>
    </main>
</body>
</html>


