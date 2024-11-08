<?php
include("../scripts/conexao.php");
include("../scripts/protect.php");

$id_patente = $_SESSION['id_patente'];
verificaAcesso("3");
verificaAcesso("4");
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
    
    <main id="mainTurma">
        <div id="containerListaTurma">
            <?php
                $query = "SELECT * FROM turma";
                $result = mysqli_query($mysqli, $query) or die(mysqli_connect_error());
                if(mysqli_num_rows($result) > 0) {
                    while ($reg = mysqli_fetch_array($result)) {
                        echo "<div class='listaTurmas'>
                                <div class='containerInfoTurma'>
                                    <h3>{$reg['nome']}</h3>
                                    <p>{$reg['ano']}</p>
                                </div>
                                <div class='containerAcoesTurma'>
                                    <a href='alterarTurma.php?id={$reg['id']}' class='botao editar'>
                                        <ion-icon name='pencil-sharp'></ion-icon>
                                        <span class='tooltip'>Editar</span>
                                    </a>
                                    <a href='#' class='botao excluir' onclick='excluirTurma({$reg['id']})'>
                                        <ion-icon name='trash-outline'></ion-icon>
                                        <span class='tooltip'>Excluir</span>
                                    </a>
                                </div>
                            </div>";
                    }
                } else {
                    echo "Nenhuma turma cadastrada!";
                }
            ?>
        </div>

        <div class="FormularioNovaTurma hide">
            <h1>Nova turma</h1>
            <form method="POST" class="formNovaTurma">
                <div>
                    <div class="inputBox">
                        <input type="text" name="nomeTurma" id="nomeTurma" class="inputs" required>
                        <label class="labelInput">Nome</label>
                    </div>
                    <div class="inputBox">
                        <input type="number" name="anoTurma" id="anoTurma" class="inputs" required>
                        <label class="labelInput">Ano</label>
                    </div>
                </div>
                <div class="buttonsAcoesTurma">
                    <input type="submit" class="buttons criarTurma" id="buttonCriarTurma" name="atualizar" value="Salvar">
                    <a href="turma.php" class="buttons excluir" name="cancelar">Cancelar</a>
                </div>
            </form>
        </div>

        <?php
            if($_SERVER["REQUEST_METHOD"] == "POST") {
                $nome = $_POST['nomeTurma'];
                $ano = $_POST['anoTurma'];
                $id_usuario = $_SESSION['id'];

                $query = "INSERT INTO turma (nome, ano, id_usuario) VALUES ('$nome', '$ano','$id_usuario')";
                $resu = $mysqli->query($query) or die("Falha na execução do código SQL: " . $mysqli->error);

                if($resu) {
                    echo '  <div class="backPopUp"></div>´
                            <div class="containerPopUp">

                                <div class="popUp edicao">
                                    <ion-icon class="checkmarkPopUp" name="checkmark-circle-outline"></ion-icon>
                                    <h1>Turma cadastrada com sucesso</h1>
                                    <button type="button" id="fecharPopUpSucesso" class="buttonsPopUp">OK</button>
                                </div>
                            </div>';
                } else {
                    echo 'Falha ao cadastrar nova turma!';
                }
            }
        ?>
    </main>
    <footer id="footerTurma">
        <button type="button" id="voltarTelaTurma" class="buttons hide">voltar</button>
        <button type="button" id="novaTurma" class="buttons">Nova turma</button>
    </footer>
</body>
</html>
