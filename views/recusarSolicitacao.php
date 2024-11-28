<?php
include("../scripts/conexao.php");
include("../scripts/protect.php");
$id_patente = $_SESSION['id_patente'];
if($id_patente == "4"){
    verificaAcesso("4");
}else{
    verificaAcesso("3");
};

if (isset($_GET['id'])) {
    $solicitacao_id = $_GET['id'];

    $query = "DELETE FROM solicitacoes WHERE id = '$solicitacao_id' AND status = 'pendente'";

    if (mysqli_query($mysqli, $query)) {
        header("Location: visualizarSolicitacoes.php");
    } else {
        echo "Erro ao recusar a solicitação: " . mysqli_error($mysqli);
    }
} else {
    echo "Solicitação não especificada!";
}
?>
