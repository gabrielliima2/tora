<?php
session_start();
include("../scripts/conexao.php");
include("../scripts/protect.php");

$id_patente = $_SESSION['id_patente'];

if (isset($_GET['turma_id'])) {
    $_SESSION['turma_id'] = $_GET['turma_id'];
}

if (!isset($_SESSION['turma_id'])) {
    echo "Turma não especificada!";
    exit;
}

$turma_id = $_SESSION['turma_id'];
$id_usuario = $_SESSION['id'];

date_default_timezone_set('America/Sao_Paulo');
$data_hora = (new DateTime())->format('Y-m-d H:i:s');

$query_turma = "SELECT * FROM turma WHERE id = ?";
$stmt_turma = $mysqli->prepare($query_turma);
$stmt_turma->bind_param("i", $turma_id);
$stmt_turma->execute();
$result_turma = $stmt_turma->get_result();

if ($result_turma->num_rows === 0) {
    echo "Turma não encontrada!";
    exit;
}

$turma = $result_turma->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['titulo'])) {
    $titulo = $_POST['titulo'];
    $descricao = $_POST['descricao'];

    $imagem_caminho = null;
    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
        $extensao = pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION);
        $nome_unico = uniqid('img_') . '.' . $extensao;
        $imagem_caminho = "../uploads/" . $nome_unico;

        if (!move_uploaded_file($_FILES['imagem']['tmp_name'], $imagem_caminho)) {
            echo "Erro ao fazer upload da imagem!";
            $imagem_caminho = null;
        }
    }

    $query = $mysqli->prepare("INSERT INTO noticias (titulo, descricao, imagem, id_usuario, id_turma, data_hora) VALUES (?, ?, ?, ?, ?, ?)");
    $query->bind_param("sssiss", $titulo, $descricao, $imagem_caminho, $id_usuario, $turma_id, $data_hora);

    if ($query->execute()) {
        header('Location: abrirTurma.php');
        exit();
    } else {
        echo "Erro ao inserir notícia: " . $mysqli->error;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['acao'])) {
    $acao = $_POST['acao'];
    $noticia_id = $_POST['noticia_id'];

    if ($acao === 'excluir') {

        $query_delete = $mysqli->prepare("DELETE FROM noticias WHERE id = ?");
        $query_delete->bind_param("i", $noticia_id);

        if ($query_delete->execute()) {
            header("Location: abrirTurma.php?turma_id=" . $turma_id);
            exit();
        } else {
            echo "Erro ao excluir a notícia: " . $mysqli->error;
        }

    } elseif ($acao === 'editar') {
 
        $_SESSION['noticia_editar_id'] = $noticia_id;
        header("Location: editarNoticia.php");
        exit();
    }
}


// Buscar as notícias da turma
$query_noticias = "SELECT u.nome AS username, u.id AS userId, n.* FROM noticias n INNER JOIN usuarios u ON n.id_usuario = u.id WHERE id_turma = ? ORDER BY data_hora DESC ";
$stmt_noticias = $mysqli->prepare($query_noticias);
$stmt_noticias->bind_param("i", $turma_id);
$stmt_noticias->execute();
$result_noticias = $stmt_noticias->get_result();
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
        <?php if ($id_patente == "4" || $id_patente == "3") { ?>        
            <button class="buttons" id="botaoNovaNoticia" >Nova notícia</button>
            <div class="backContainerNewPost hide"></div>
            <div class="containerNewPost hide">
                <div class="containerCloseNews">
                    <ion-icon class="btnCloseNews" size="large" name="close-outline"></ion-icon>
                    <form action="" method="POST" enctype="multipart/form-data" class="formNewPost">
                        <div class="inputBox">
                            <input type="text" name="titulo" id="titulo" class="inputs" maxlength="150" required>
                            <label class="labelInput">Título</label>
                        </div>
                        <div class="inputBox">
                            <textarea name="descricao" id="descricao" maxlength="300" style="resize: none" class="inputs textareas" required></textarea>
                            <label class="labelInput">Descrição (até 300 letras)</label>
                        </div>
                        <div class="inputBox">
                            <input type="file" name="imagem" id="imagem" class="inputs">
                            <label class="labelInput">Selecione uma imagem</label>
                        </div>
                        <input type="submit" class="buttons" id="enviar" value="Enviar">
                    </form>
                </div>
            </div>
        <?php } ?>

        <section id="noticias">
            <?php if ($result_noticias->num_rows > 0): ?>
                <?php while ($noticia = $result_noticias->fetch_assoc()): ?>
                    <article class="noticia">

                        <div class="containerNoticia">
                            <div class="userInfo">
                                <h2><?php echo htmlspecialchars($noticia['username']); ?></h2>
                                <?php 
                                    if($_SESSION['id'] == $noticia['userId']){
                                ?>
                                    <ion-icon name="ellipsis-horizontal-sharp" class="menu-toggle"></ion-icon>
                                <?php
                                    }
                                ?>
                               
                                <div class="menu-options hide">
                                    <form method="POST" action="">
                                        <input type="hidden" name="acao" value="editar">
                                        <input type="hidden" name="noticia_id" value="<?php echo $noticia['id']; ?>">
                                        <button type="submit" class="menu-item">Editar</button>
                                    </form>
                                    <form method="POST" action="" class="delete-form">
                                        <input type="hidden" name="acao" value="excluir">
                                        <input type="hidden" name="noticia_id" value="<?php echo $noticia['id']; ?>">
                                        <button type="button" class="menu-item delete-confirm">Excluir</button>
                                    </form>

                                    <button type="button" class="menu-item menu-cancel">Cancelar</button>
                                </div>
                            </div>

                            <h2><?php echo htmlspecialchars($noticia['titulo']); ?></h2>
                            <div class="imagemNoticia">
                                <?php if ($noticia['imagem']): ?>
                                    <img 
                                        src="<?php echo htmlspecialchars($noticia['imagem']); ?>" 
                                        alt="Imagem da notícia" 
                                        class="img-clickable"
                                    >
                                <?php endif; ?>
                            </div>
                                <p><?php echo htmlspecialchars($noticia['descricao']); ?></p>
                                
                                <small 
                                    class="data-publicacao" 
                                    title="<?php 
                                        $data_publicacao = new DateTime($noticia['data_hora']);
                                        echo $data_publicacao->format('d/m/Y H:i:s'); 
                                    ?>">
                                    <?php 
                                    $agora = new DateTime();
                                    $intervalo = $agora->diff($data_publicacao);

                                    if ($intervalo->y > 0) {
                                        echo $intervalo->y . " anos atrás";
                                    } elseif ($intervalo->m > 0) {
                                        echo $intervalo->m . " meses atrás";
                                    } elseif ($intervalo->d > 0) {
                                        echo $intervalo->d . " dias atrás";
                                    } elseif ($intervalo->h > 0) {
                                        echo $intervalo->h . " horas atrás";
                                    } elseif ($intervalo->i > 0) {
                                        echo $intervalo->i . " minutos atrás";
                                    } else {
                                        echo "Agora mesmo";
                                    }
                                    ?>
                                </small>


                        </div>
                    </article>
                <?php endwhile; ?>
            <?php else: ?>
                <p>Não há notícias disponíveis para esta turma.</p>
            <?php endif; ?>
        </section>
        
        <div id="imageModal" class="modal hide">
            <span class="close-modal">&times;</span>
            <img class="modal-content" id="modalImage">
        </div>

    </main>
</body>
</html>
