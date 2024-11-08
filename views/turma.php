<?php
    include("../scripts/conexao.php");
    include("../scripts/protect.php");

    $id_patente = $_SESSION['id_patente'];
    //verificaAcesso(['sargento']);

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
   
    <main id="mainMenu">
    <?php
        $query = "SELECT * FROM turma";
        $result = mysqli_query($mysqli, $query) or die (mysqli_connect_error());
        if(mysqli_num_rows($result)>0){
            while ($reg = mysqli_fetch_array($result)) {
                echo "<div>
                        <p>" . htmlspecialchars($reg['nome']) . " " . htmlspecialchars($reg['ano']) . "</p>
                        <a href='#' onclick='editarTurma(" . $reg['id'] . ")'>Editar</a>
                        <a href='#' onclick='excluirTurma(" . $reg['id'] . ")'>Excluir</a>
                    </div>";
            }
        }else{
            echo"Nenhuma turma cadastrada!";
        }
        
    ?>

    <div id="FormularioNovaTurma" class="hide">
        <h1>Nova turma</h1>
        <form method="POST">
            <div class="inputBox">
                <input type="text" name="nomeTurma" id="nomeTurma" class="inputs" size="20" required>
                <label class="labelInput">Nome</label>
            </div>
            <div class="inputBox">
                <input type="number" name="anoTurma" id="anoTurma" class="inputs" size="20" min="2000" max="2200" required>
                <label class="labelInput">Ano</label>
            </div>
            <button type="submit" class="buttons" id="buttonCriarTurma">Criar</button>
        </form>
    </div>
    <?php
         if($_SERVER["REQUEST_METHOD"] == "POST"){
        
            $nome = $_POST['nomeTurma'];
            $ano = $_POST['anoTurma'];
        
            $queryCheck = "SELECT * FROM turma WHERE ano = '$ano'";
            $resuCheck = $mysqli->query($queryCheck) or die("Falha na execução do código SQL: " . $mysqli->error);
        
            if($resuCheck->num_rows > 0) {
                echo 'Turma já cadastrada!';
            } else {
                // Insere uma nova turma
                $query = "INSERT INTO turma (nome, ano) VALUES ('$nome', '$ano')";
                $resu = $mysqli->query($query) or die("Falha na execução do código SQL: " . $mysqli->error);
        
                if($resu) {
                    echo '<div id="popUpTurmaCadastrada">
                            <p>Turma cadastrada com sucesso</p>
                        </div>';
                } else {
                    echo 'Falha ao cadastrar nova turma!';
                }
            }
    
        }    
    ?>


    </main>
    <footer id="footerTurma">
        <button type="button" id="novaTurma" class="buttons">Nova turma</button>
    </footer>

</body>
</html>