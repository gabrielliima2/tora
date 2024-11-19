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

// Buscar as notícias da turma
$query_noticias = "SELECT u.nome, n.* FROM noticias n INNER JOIN usuarios u ON n.id_usuario = u.id WHERE id_turma = ? ORDER BY data_hora DESC ";
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
                            <input type="text" name="titulo" id="titulo" class="inputs" required>
                            <label class="labelInput">Título</label>
                        </div>
                        <div class="inputBox">
                            <textarea name="descricao" id="descricao" maxlength="300" class="inputs textareas" required></textarea>
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
                            <h2><?php echo htmlspecialchars($noticia['nome']); ?></h2>
                            <h2><?php echo htmlspecialchars($noticia['titulo']); ?></h2>
                            <div class="imagemNoticia">
                                <?php if ($noticia['imagem']): ?>
                                    <img src="<?php echo htmlspecialchars($noticia['imagem']); ?>" alt="Imagem da notícia">
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
    </main>
</body>
</html>
