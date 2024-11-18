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


$query_turma = "SELECT * FROM turma WHERE id = '$turma_id'";
$result_turma = mysqli_query($mysqli, $query_turma);

if (mysqli_num_rows($result_turma) == 0) {
    echo "Turma não encontrada!";
    exit;
}

$turma = mysqli_fetch_assoc($result_turma);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    //contianuar daquiiiiii
    
    
    //ajdaiosjdopjaipjdipawjd
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
    <script src="../assets/js/scriptNoticia.js" defer></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js" defer></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js" defer></script>
    <title>Tóra</title>
</head>
<body>
    <?php include("../components/header.php"); ?>
    <?php include("../components/turmaMenu.php"); ?>
    
    <main id="mainNoticias">
        <?php
            if($id_patente == "4" || $id_patente == "3"){
        ?>        
                <button class="buttons" id="botaoNovaNoticia">Nova notícia</button>
                <div class="containerNewPost">
                    <form action="POST">
                        <div class="inputBox">
                            <input type="text" name="titulo" id="titulo" class="inputs">
                            <label class="labelInput">Título</label>
                        </div>
                        <div class="inputBox">
                            <textarea name="descricao" id="descricao" maxlength="300" class="inputs textareas"></textarea>
                            <label class="labelInput">Descricao (até 300 letras)</label>
                        </div>
                        <div class="inputBox">
                            <input type="file" id="imagem" accept="image/*" class="inputs">
                            <label class="labelInput">Selecione uma imagem</label>
                        </div>
                        <input type="submit" class="buttons" id="botaoNovaNoticia" value="Enviar">
                    </form>
                </div>
          <?php
            }else{
            }
        ?>

    </main>
</body>
</html>
