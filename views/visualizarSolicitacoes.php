<?php
include("../scripts/conexao.php");
include("../scripts/protect.php");

$id_patente = $_SESSION['id_patente'];
if($id_patente == "4"){
    verificaAcesso("4");
}else{
    verificaAcesso("3");
};

$id_turma = $_SESSION['turma_id'];

$query = "SELECT u.nome AS usuario_nome, t.nome AS turma_nome, s.status, s.data_solicitacao, s.id 
          FROM solicitacoes s 
          INNER JOIN turma t ON s.turma_id = t.id
          INNER JOIN usuarios u ON s.usuario_id = u.id
          WHERE status = 'pendente' AND turma_id = '$id_turma';
          ";
$resu = mysqli_query($mysqli, $query) or die(mysqli_error($mysqli));
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

    
    <main id="mainTurma">
        <div class="containerListaTurma">
            <?php
                if(mysqli_num_rows($resu) > 0){
                    while($reg = mysqli_fetch_array($resu)){
                        echo "  <div class='listaTurmas'>
                                    <div class='containerInfoTurma'>
                                        <h2>{$reg['turma_nome']}</h2>
                                        <h3>{$reg['usuario_nome']}</h3>
                                        <p>{$reg['status']}</p>
                                    </div>
                                    <div class='containerAcoesTurma'>
                                        <a href='aceitarSolicitacao.php?id={$reg['id']}' class='buttons editar'>
                                            Aceitar
                                        </a>
                                        <a href='recusarSolicitacao.php?id={$reg['id']}' class='buttons excluir'>
                                            Recusar
                                        </a>
                                    </div>
                                </div>
                            ";
                    }
                }else{
                    echo "Nenhuma solicitação encontrada";
                }
            ?>
        </div>
    </main>
</body>
</html>
