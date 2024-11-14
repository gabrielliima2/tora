<?php
include("../scripts/conexao.php");
include("../scripts/protect.php");

$id_patente = $_SESSION['id_patente'];
if($id_patente == "4"){
    verificaAcesso("4");
}else{
    verificaAcesso("3");
};

$turma_id = $_SESSION['turma_id'];

if(isset($_GET["id"])){
    $id_usuario = $_GET["id"];
    $query_usuarios = "SELECT * FROM usuarios WHERE id = '$id_usuario'";
    $result_usuarios = mysqli_query($mysqli, $query_usuarios) or die(mysqli_error($mysqli));;
    if($result_usuarios){
        $row = mysqli_fetch_assoc($result_usuarios);
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
            <div class="formNovaTurma">
                <div class="containerVisualizarParticipante">

                    <div class="inputBox">
                        <input type="text" name="nomeUsuario" id="nomeUsuario" class="inputs" value="<?php echo !empty($row['nome']) ? $row['nome'] : ''; ?>" readonly>
                        <label class="labelInput">Nome</label>
                    </div>

                    <div class="inputBox">
                        <input type="date" name="dataNascimento" id="dataNascimento" class="inputs" value="<?php echo !empty($row['nascimento']) ? $row['nascimento'] : ''; ?>" readonly><!--Se o valor nascimento for vazio ele retorna uma string vazia ("")-->
                        <label class="labelInput">Data de Nascimento</label>
                    </div>

                    <div class="inputBox">
                        <input type="text" name="endereco" id="endereco" class="inputs" value="<?php echo !empty($row['endereco']) ? $row['endereco'] : ''; ?>" readonly>
                        <label class="labelInput">Endereço</label>
                    </div>

                    <div class="inputBox">
                        <input type="text" name="bairro" id="bairro" class="inputs" value="<?php echo !empty($row['bairro']) ? $row['bairro'] : ''; ?>" readonly>
                        <label class="labelInput">Bairro</label>
                    </div>

                    <div class="inputBox">
                        <input type="text" name="cidade" id="cidade" class="inputs" value="<?php echo !empty($row['cidade']) ? $row['cidade'] : ''; ?>" readonly>
                        <label class="labelInput">Cidade</label>
                    </div>

                    <div class="inputBox">
                        <input type="text" name="estado" id="estado" class="inputs" value="<?php echo !empty($row['estado']) ? $row['estado'] : ''; ?>" readonly>
                        <label class="labelInput">Estado</label>
                    </div>

                    <div class="inputBox">
                        <input type="text" name="telefone" id="telefone" class="inputs" value="<?php echo !empty($row['telefone']) ? $row['telefone'] : ''; ?>" readonly>
                        <label class="labelInput">Telefone</label>
                    </div>

                </div>              
            </div>
        </div>
    </main>
</body>
</html>
<?php
    }else{
            echo "Usuário não localizado";
        }
    }else{
        echo"Usuário não identificado";
    }
?>