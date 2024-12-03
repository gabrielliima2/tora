<?php
include("../scripts/conexao.php");
include("../scripts/protect.php");

date_default_timezone_set('America/Sao_Paulo');

$id_usuario = $_SESSION['id']; 
$id_patente = $_SESSION['id_patente']; 
$turma_id = $_SESSION['turma_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_GET['editar'])) {
    $titulo = $_POST['titulo'];
    $descricao = $_POST['descricao'];
    $data = $_POST['data'];
    $id_superior = $_POST['id_superior'];
    $turma_id = $_SESSION['turma_id']; 

    $queryInserir = "INSERT INTO qtq (titulo, descricao, data, id_superior, id_turma) 
                     VALUES ('$titulo', '$descricao', '$data', '$id_superior', '$turma_id')";
    if ($mysqli->query($queryInserir)) {
        header("Location: telaQTQ.php");
        exit;
    } else {
        echo "Erro ao criar o quadro: " . $mysqli->error;
    }
}



if (isset($_GET['excluir'])) {
    $id_quadro = $_GET['excluir'];

    $queryExcluir = "DELETE FROM qtq WHERE id = '$id_quadro'";
    if ($mysqli->query($queryExcluir)) {
        header("Location: telaQTQ.php");

    } else {
        echo "Erro ao excluir o quadro: " . $mysqli->error;
    }
}


if (isset($_GET['editar'])) {
    $id_quadro = $_GET['editar'];

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $titulo = $_POST['titulo'];
        $descricao = $_POST['descricao'];
        $data = $_POST['data'];
        $id_superior = $_POST['id_superior'];
        $turma_id = $_SESSION['turma_id'];

        $queryEditar = "UPDATE qtq SET titulo = '$titulo', descricao = '$descricao', data = '$data', 
                    id_superior = '$id_superior', id_turma = '$turma_id' 
                    WHERE id = '$id_quadro'";

        if ($mysqli->query($queryEditar)) {
            header("Location: telaQTQ.php"); 
            exit;
        } else {
            echo "Erro ao editar o quadro: " . $mysqli->error;
        }
    }

    $queryConsultar = "SELECT * FROM qtq WHERE id = '$id_quadro'";
    $resultConsultar = $mysqli->query($queryConsultar);
    $qtq = $resultConsultar->fetch_assoc();
}

$queryQtq = "SELECT * FROM qtq ORDER BY data DESC";
$resultQtq = $mysqli->query($queryQtq);
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
    <script src="../assets/js/scriptChamada.js" defer></script>
    <script src="../assets/js/scriptQTQ.js" defer></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js" defer></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js" defer></script>


    <title>Tóra</title>
</head>
<body>
    <?php include("../components/header.php"); ?>
    <?php include("../components/turmaMenu.php"); ?>

    <main class="mainGerarEscala">
        <?php
            if($id_patente== 4 || $id_patente==3){
                echo "<div class='buttons' id='botaoCriarQTQ'>Criar QTQ</div>";
            }
        ?>

        <div class="backFormCriarNovoQuadro hide"></div>
        <form method="POST" action="telaQTQ.php" class="formCriarNovoQuadro hide">
                <h2>Criar Novo QTQ</h2>
                <div class="inputBox">
                    <input type="text" name="titulo" id="titulo" class="inputs" required>
                    <label for="titulo" class="labelInput">Título</label>
                </div>

                <div class="inputBox">
                    <textarea name="descricao" id="descricao" maxlength="300" style="resize: none" class="inputs" required></textarea>
                    <label for="descricao" class="labelInput">Descrição (até 300 letras)</label>
                </div>
                
                <div class="inputBox">
                    <input type="date" name="data" id="data" class="inputs" required>
                    <label for="data" class="labelInput">Data</label>
                </div>
                <div class="inputBox"> 
                    <select name="id_superior" id="id_superior" class="inputs" required>
                        <option value="">Selecione o Superior</option>
                        <?php
                        $querySuperiores = "SELECT u.id, u.nome FROM usuarios u INNER JOIN turma_usuario tu ON tu.id_usuario = u.id WHERE u.id_patente = 4 AND tu.id_turma = '$turma_id' ";
                        $resultSuperiores = $mysqli->query($querySuperiores);

                        while ($superior = $resultSuperiores->fetch_assoc()) {
                            echo "<option value='" . $superior['id'] . "'>" . $superior['nome'] . "</option>";
                        }
                        ?>
                    </select>
                    <label for="id_superior" class="labelInput">Superior</label>
                </div>


                <div class="inputBox">
                    <input type="hidden" name="id_turma" id="id_turma" value="<?php echo $turma_id; ?>" class="inputs" required >
                </div>

                <div style="margin: 20px;">
                    <button type="submit" class="buttons">Criar Quadro</button>
                    <a href="telaQTQ.php" class="buttons excluir">Cancelar</a>
                </div>
            </form>
        </div>
        <?php if (isset($qtq)): ?>
        <div class="backFormEditarQTQ"></div>

        <form method="POST" action="telaQTQ.php?editar=<?= $qtq['id'] ?>" class="formEditarQTQ">
            <h2>Editar QTQ</h2>
            <div class="inputBox">
                <input type="text" name="titulo" id="titulo" class="inputs"  value="<?= $qtq['titulo'] ?>" required>
                <label for="titulo" class="labelInput">Título</label>
            </div>

            <div class="inputBox">
                <textarea name="descricao" id="descricao" maxlength="300" style="resize: none" class="inputs" required><?= $qtq['descricao'] ?></textarea>
                <label for="descricao" class="labelInput">Descrição (até 300 letras)</label>
            </div>
            
            <div class="inputBox">
                <input type="date" name="data" id="data" class="inputs" value="<?= $qtq['data'] ?>" required>
                <label for="data" class="labelInput" >Data</label>
            </div>
            <div class="inputBox"> 
                <select name="id_superior" id="id_superior" class="inputs" required >
                    <option value="">Selecione o Superior</option>
                    <?php
                    $id_superior_atual = $qtq['id_superior'];

                    $querySuperiores = "SELECT u.id, u.nome FROM usuarios u INNER JOIN turma_usuario tu ON tu.id_usuario = u.id WHERE u.id_patente = 4 AND tu.id_turma = '$turma_id' ";
                    $resultSuperiores = $mysqli->query($querySuperiores);

                    while ($superior = $resultSuperiores->fetch_assoc()) {
                        $selected = ($superior['id'] == $id_superior_atual) ? 'selected' : '';
                        echo "<option value='" . $superior['id'] . "' $selected>" . $superior['nome'] . "</option>";
                    }
                    ?>
                </select>
                <label for="id_superior" class="labelInput">Superior</label>
            </div>
            
            <div class="inputBox">
                    <input type="hidden" name="id_turma" id="id_turma" value="<?php echo $turma_id; ?>" class="inputs" required >
            </div>
            <div style="margin: 20px;">
                <button type="submit" class="buttons">Atualizar Quadro</button>
                <a href="telaQTQ.php" class="buttons excluir">Cancelar</a>
            </div>

        </form>
        
        <?php endif; ?>
        
            <h2 style="padding:20px;">Quadros de Trabalho</h2>
            <div class="containerQuadro">
                <table class="tableContagemQuadro" >
                    <thead>
                        <tr>
                            <th>Data do QTQ</th>
                            <th>Título</th>
                            <th>Descrição</th>
                            <th>Superior</th>
                            <?php if($id_patente== 4 || $id_patente==3){
                                echo "<th>Ações</th>";
                            }
                            ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $queryQtq = "SELECT qtq.*, usuarios.nome AS autor_nome, turma.nome AS turma_nome 
                            FROM qtq
                            JOIN usuarios ON qtq.id_superior = usuarios.id
                            JOIN turma ON qtq.id_turma = turma.id
                            WHERE qtq.id_turma = '$turma_id' 
                            ORDER BY qtq.data ASC ";
        
                            $resultQtq = $mysqli->query($queryQtq);
                            
                            if ($resultQtq->num_rows > 0) {
                                while ($qtq = $resultQtq->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . date("d/m/Y", strtotime($qtq['data'])) . "</td>";
                                    echo "<td>" . $qtq['titulo'] . "</td>";
                                    echo "<td>" . $qtq['descricao'] . "</td>";
                                    echo "<td>" . $qtq['autor_nome'] . "</td>";
                                    if($id_patente== 4 || $id_patente==3){
                                        echo "  <td>
                                                    <a href='telaQTQ.php?editar=" . $qtq['id'] . "'  class='botao editar'>
                                                        <ion-icon name='pencil-sharp'></ion-icon>
                                                        </a> |
                                                    <a href='telaQTQ.php?excluir=" . $qtq['id'] . "'  class='botao excluir' onclick='return confirm(\"Tem certeza que deseja excluir?\")'>
                                                        <ion-icon name='trash-outline'></ion-icon>
                                                        
                                                    </a>
                                                </td>";
                                    }
                                    
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='6'>Nenhum quadro de trabalho quinzenal encontrado.</td></tr>";
                            }
        
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

</body>
</html>
