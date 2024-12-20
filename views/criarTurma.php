<?php
include("../scripts/conexao.php");
include("../scripts/protect.php");

$id_patente = $_SESSION['id_patente'];
if($id_patente == "4"){
    verificaAcesso("4");
}else{
    verificaAcesso("3");
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
    
    <main id="mainTurma">
        <div class="containerListaTurma">
        <?php
            $query = "SELECT * FROM turma";
            $result = mysqli_query($mysqli, $query) or die(mysqli_connect_error());
            if(mysqli_num_rows($result) > 0) {
                while ($reg = mysqli_fetch_array($result)) {
                    $turma_id = $reg['id'];

                    // Verifica se o administrador já participa da turma
                    $admin_in_turma_query = "SELECT * FROM turma_usuario WHERE id_usuario = '{$_SESSION['id']}' AND id_turma = '$turma_id'";
                    $admin_in_turma_result = mysqli_query($mysqli, $admin_in_turma_query);
                    $is_admin_in_turma = mysqli_num_rows($admin_in_turma_result) > 0;

                    echo "  
                    <div class='listaTurmas'>";

                    if ($is_admin_in_turma) {
                        echo "
            
                        <div class='containerInfoTurma'>
                            <a href='#' onclick='abrirTurma({$turma_id})' class='linkAbrir'></a>
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
                           
                            <a href='sairTurma.php?id={$turma_id}' class='botao excluir'>
                                <ion-icon name='log-out-outline'></ion-icon>
                                <span class='tooltip'>Sair</span>
                            </a>
                        </div>
                            
                            ";

                    } else {
                        echo "
                            <div class='containerInfoTurma'>
                                <h3>{$reg['nome']}</h3>
                                <p>{$reg['ano']}</p>
                            </div>
                            <div class='containerAcoesTurma'>
                                <a href='participarTurma.php?id={$turma_id}' class='botao editar'>
                                    <ion-icon name='log-in-outline'></ion-icon>
                                    <span class='tooltip'>Fazer parte</span>
                                </a>
                            </div>
                            ";
                    }

                    echo "  
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
                    <a href="criarTurma.php" class="buttons excluir" name="cancelar">Cancelar</a>
                </div>
            </form>
        </div>

        <?php
            if($_SERVER["REQUEST_METHOD"] == "POST") {
                $nome = $_POST['nomeTurma'];
                $ano = $_POST['anoTurma'];
                $id_usuario = $_SESSION['id'];

                $query = "INSERT INTO turma (nome, ano) VALUES ('$nome', '$ano')";
                $resu = $mysqli->query($query) or die("Falha na execução do código SQL: " . $mysqli->error);


                if($resu) {
                    $id_turma = $mysqli->insert_id;

                    // Insere o superior na tabela turma_usuario
                    $queryTurmaUsuario = "INSERT INTO turma_usuario (id_turma, id_usuario) VALUES ('$id_turma', '$id_usuario')";
                    $resuTurmaUsuario = $mysqli->query($queryTurmaUsuario) or die("Falha ao associar o superior à turma: " . $mysqli->error);
            
                    if ($resuTurmaUsuario) {
                        ?>
                        <div class="backPopUp"></div>
                        <div class="containerPopUp">
                            <div class="popUp edicao">
                                <ion-icon class="checkmarkPopUp" name="checkmark-circle-outline"></ion-icon>
                                <h1>Turma cadastrada com sucesso</h1>
                                <a href="criarTurma.php" class="buttonsPopUp"> OK</a>
                            </div>
                        </div>
                        <?php
                    } else {
                        echo 'Falha ao associar o superior à turma!';
                    }
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

    <script>
        function abrirTurma(turmaId) {
            fetch(`abrirTurma.php?turma_id=${turmaId}`)
                .then(() => window.location.href = 'abrirTurma.php');
        }
    </script>
</body>
</html>
