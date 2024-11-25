<?php
include("../scripts/conexao.php");
include("../scripts/protect.php");

date_default_timezone_set('America/Sao_Paulo');

$id_usuario = $_SESSION['id']; 

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_GET['editar'])) {
    $titulo = $_POST['titulo'];
    $descricao = $_POST['descricao'];
    $data = $_POST['data'];

    $queryInserir = "INSERT INTO qtq (titulo, descricao, data, id_usuario) VALUES ('$titulo', '$descricao', '$data', '$id_usuario')";
    if ($mysqli->query($queryInserir)) {
        echo "Quadro de Trabalho Quinzenal criado com sucesso!";
        header("Location: telaQtq.php");
        exit;
    } else {
        echo "Erro ao criar o quadro: " . $mysqli->error;
    }
}


if (isset($_GET['excluir'])) {
    $id_quadro = $_GET['excluir'];

    $queryExcluir = "DELETE FROM qtq WHERE id = '$id_quadro'";
    if ($mysqli->query($queryExcluir)) {
        echo "Quadro de Trabalho Quinzenal excluído com sucesso!";
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

        $queryEditar = "UPDATE qtq SET titulo = '$titulo', descricao = '$descricao', data = '$data' WHERE id = '$id_quadro'";
        if ($mysqli->query($queryEditar)) {
            echo "Quadro de Trabalho Quinzenal atualizado com sucesso!";
            header("Location: telaQtq.php"); 
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
        
        <h1>Quadro de Trabalho Quinzenal</h1>
        <div class="buttons" id="botaoCriarQTQ">Criar QTQ</div>
        <div class="backFormCriarNovoQuadro hide"></div>
        <form method="POST" action="telaQtq.php" class="formCriarNovoQuadro hide">
                <h2>Criar Novo Quadro</h2>
                <div class="inputBox">
                    <input type="text" name="titulo" id="titulo" class="inputs" required>
                    <label for="titulo" class="labelInput">Título</label>
                </div>

                <div class="inputBox">
                    <textarea name="descricao" id="descricao" maxlength="300" style="resize: none" class="inputs" required></textarea>
                    <label for="descricao" class="labelInput">Descrição (até 300 letras)</label>
                </div>
                
                <div class="inputBox">
                    <input type="date" name="data" id="data" class="inputs" >
                    <label for="data" class="labelInput">Data</label>
                </div>
                <div style="margin: 20px;">
                    <button type="submit" class="buttons">Criar Quadro</button>
                    <a href="telaQTQ.php" class="buttons excluir">Cancelar</a>
                </div>
            </form>
        </div>
        <?php if (isset($qtq)): ?>
        <div class="backFormEditarQTQ"></div>

        <form method="POST" action="telaQtq.php?editar=<?= $qtq['id'] ?>" class="formEditarQTQ">
            <h2>Editar Quadro de Trabalho Quinzenal</h2>
            <div class="inputBox">
                <input type="text" name="titulo" id="titulo" class="inputs"  value="<?= $qtq['titulo'] ?>" required>
                <label for="titulo" class="labelInput">Título</label>
            </div>

            <div class="inputBox">
                <textarea name="descricao" id="descricao" maxlength="300" style="resize: none" class="inputs" required><?= $qtq['descricao'] ?></textarea>
                <label for="descricao" class="labelInput">Descrição (até 300 letras)</label>
            </div>
            
            <div class="inputBox">
                <input type="date" name="data" id="data" class="inputs" >
                <label for="data" class="labelInput" value="<?= $qtq['data'] ?>">Data</label>
            </div>
            <div style="margin: 20px;">
                <button type="submit" class="buttons">Atualizar Quadro</button>
                <a href="telaQTQ.php" class="buttons excluir">Cancelar</a>
            </div>
        </form>
        
        <?php endif; ?>
        
        <div class="tabelaQuadrosCriados">
            <h2>Quadros Criados</h2>
            <table border="1" >
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Descrição</th>
                        <th>Data do QTQ</th>
                        <th>Autor</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($resultQtq->num_rows > 0) {
                        while ($qtq = $resultQtq->fetch_assoc()) {

                            $id_usuario_criador = $qtq['id_usuario'];
                            $queryUsuario = "SELECT nome FROM usuarios WHERE id = '$id_usuario_criador'";
                            $resultUsuario = $mysqli->query($queryUsuario);
                            $usuario = $resultUsuario->fetch_assoc();

                            echo "<tr>";
                            echo "<td>" . $qtq['titulo'] . "</td>";
                            echo "<td>" . $qtq['descricao'] . "</td>";
                            echo "<td>" . date("d/m/Y", strtotime($qtq['data'])) . "</td>";
                            echo "<td>" . $usuario['nome'] . "</td>";
                            echo "<td>
                                    <a href='telaQtq.php?editar=" . $qtq['id'] . "'>Editar</a> |
                                    <a href='telaQtq.php?excluir=" . $qtq['id'] . "' onclick='return confirm(\"Tem certeza que deseja excluir?\")'>Excluir</a>
                                </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>Nenhum quadro de trabalho quinzenal encontrado.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </main>

</body>
</html>
