<?php
    include("../scripts/conexao.php");
    include("../scripts/protect.php");

    $id_patente = $_SESSION['id_patente'];
    verificaAcesso("1");

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
                $result = mysqli_query($mysqli, $query) or die (mysqli_connect_error());
                if(mysqli_num_rows($result)>0){
                    while ($reg = mysqli_fetch_array($result)) {
                        echo "<div class='listaTurmas'>
                                <div class='containerInfoTurma'>
                                    <h3>
                                        " . $reg['nome'] . "
                                    </h3>
                                    <p>
                                        " .$reg['ano'] . "
                                    </p>
                                </div>
                                <div class='containerAcoesTurma'>
                                    <a href='#' class='botao editar' onclick='editarTurma(" . $reg['id'] . ")'>
                                        <ion-icon name='pencil-sharp'></ion-icon>
                                          <span class='tooltip'>Editar</span>
                                    </a>
                                    <a href='#' class='botao excluir' onclick='excluirTurma(" . $reg['id'] . ")'>
                                        <ion-icon name='trash-outline'></ion-icon>
                                          <span class='tooltip'>Excluir</span>
                                    </a>
                                </div>
                            </div>";
                    }
                }else{
                    echo"Nenhuma turma cadastrada!";
                }
                
            ?>
        </div>

    <div class="FormularioNovaTurma hide">
        <h1>Nova turma</h1>
        <form method="POST" class="formNovaTurma">
            <div>
                <div class="inputBox">
                    <input type="text" name="nomeTurma" id="nomeTurma" class="inputs" size="20" required>
                    <label class="labelInput">Nome</label>
                </div>
                <div class="inputBox">
                    <input type="number" name="anoTurma" id="anoTurma" class="inputs" size="20"required>
                    <label class="labelInput">Ano</label>
                </div>
            </div>
            <button type="submit" class="buttons criarTurma" id="buttonCriarTurma">
                Criar
            </button>
        </form>
    </div>
    <?php
         if($_SERVER["REQUEST_METHOD"] == "POST"){
        
            $nome = $_POST['nomeTurma'];
            $ano = $_POST['anoTurma'];
            $id_usuario = $_SESSION['id'];
        
            $query = "INSERT INTO turma (nome, ano, id_usuario) VALUES ('$nome', '$ano','$id_usuario')";
            $resu = $mysqli->query($query) or die("Falha na execução do código SQL: " . $mysqli->error);
    
            if($resu) {
                $nome = "";
                $ano = "";
                echo '  
                        <div class="backPopUp"></div>
                        <div class="popUp">
                            <ion-icon class="checkmarkPopUp" name="checkmark-circle-outline"></ion-icon>
                            <h1>Turma cadastrada com sucesso</h1>
                            <button type="button" id="fecharPopUpSucesso" class="buttonsPopUp">OK</button>
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












<?php
include("../scripts/conexao.php");
include("../scripts/protect.php");

// Verifica se o ID foi enviado via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];

    // Carrega os dados da turma existente
    $query = "SELECT * FROM turma WHERE id = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $turma = $result->fetch_assoc();

    // Verifica se a turma existe
    if (!$turma) {
        echo "Turma não encontrada.";
        exit;
    }

    // Atualiza os dados se o formulário for enviado
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['atualizar'])) {
        $id = $_POST['id'];
        $novoNome = $_POST['nomeTurma'];
        $novoAno = $_POST['anoTurma'];
    
        $queryUpdate = "UPDATE turma SET nome = ".$novoNome.", ano = ".$novoAno." WHERE id = ".$id."";
        $resu = mysqli_query($mysqli, $query);
    
        if ($resu) {
            echo "Atualização realizada com sucesso!";
        }else {
            echo "ERRO ao atualizar os dados: " . mysqli_error($con);
        }
    
        mysqli_close($con);
        header ("Location: turma.php") ;
    }elseif ($_SERVER ["REQUEST_METHOD"] == "POST" && isset($_POST ['cancelar'])) {
            header ("Location: turma.php") ;
    }
} else {
    echo "ID da turma não foi informado.";
    exit;
}


?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Turma</title>
</head>
<body>
    <h1>Editar Turma</h1>
    <form method="POST">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">

        <div class="inputBox">
            <label class="labelInput">Nome</label>
            <input type="text" name="nomeTurma" class="inputs" value="<?php echo $turma['nome']; ?>" required>
        </div>

        <div class="inputBox">
            <label class="labelInput">Ano</label>
            <input type="number" name="anoTurma" class="inputs" value="<?php echo $turma['ano']; ?>" min="2000" max="2200" required>
        </div>

        <input type="submit" class="buttons criarTurma" name="atualizar" value="Salvar">
        <input type="submit" class="buttons excluir" name="cancelar" value="Cancelar">
    </form>
</body>
</html>



