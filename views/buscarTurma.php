<?php
include("../scripts/conexao.php");
include("../scripts/protect.php");

$usuario_id = $_SESSION['id']; // ID do usuário logado
$output = "";

// Verifica se o termo de busca foi enviado
$search_term = isset($_POST['search']) ? mysqli_real_escape_string($mysqli, $_POST['search']) : "";

$query = "SELECT * FROM turma";
if ($search_term !== "") {
    $query .= " WHERE nome LIKE '%$search_term%' OR ano LIKE '%$search_term%'";
}
$result = mysqli_query($mysqli, $query);

if (mysqli_num_rows($result) > 0) {
    while ($reg = mysqli_fetch_array($result)) {
        $turma_id = $reg['id'];
        $check_query = "SELECT * FROM solicitacoes WHERE usuario_id = '$usuario_id' AND turma_id = '$turma_id' AND status = 'pendente'";
        $check_result = mysqli_query($mysqli, $check_query);

        if (mysqli_num_rows($check_result) > 0) {
            $output .= "<div class='listaTurmas'>
                            <div class='containerInfoTurma'>
                                <h3>{$reg['nome']}</h3>
                                <p>{$reg['ano']}</p>
                            </div>
                            <div class='containerAcoesTurma'>
                                <a href='cancelarSolicitacao.php?id={$reg['id']}' class='buttons excluir'>
                                    Cancelar
                                </a>
                            </div>
                        </div>";
        } else {
            $output .= "<div class='listaTurmas'>
                            <div class='containerInfoTurma'>
                                <h3>{$reg['nome']}</h3>
                                <p>{$reg['ano']}</p>
                            </div>
                            <div class='containerAcoesTurma'>
                                <a href='solicitarAcesso.php?id={$reg['id']}' class='buttons'>
                                    Participar
                                </a>
                            </div>
                        </div>";
        }
    }
} else {
    $output = "Nenhuma turma encontrada!";
}

echo $output;
?>
