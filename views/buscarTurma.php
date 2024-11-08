<?php
include("../scripts/conexao.php");
include("../scripts/protect.php");

if (isset($_GET['search'])) {
    $search_term = mysqli_real_escape_string($mysqli, $_GET['search']); // Protege contra SQL Injection

    // Consulta SQL para buscar turmas com base no nome
    $query = "SELECT * FROM turma WHERE nome LIKE '%$search_term%'";
    $result = mysqli_query($mysqli, $query) or die(mysqli_connect_error());

    if (mysqli_num_rows($result) > 0) {
        while ($reg = mysqli_fetch_array($result)) {
            // Verificar se o usuário já fez uma solicitação para essa turma
            $turma_id = $reg['id'];
            $usuario_id = $_SESSION['id']; // ID do usuário logado
            $check_query = "SELECT * FROM solicitacoes WHERE usuario_id = '$usuario_id' AND turma_id = '$turma_id' AND status = 'pendente'";
            $check_result = mysqli_query($mysqli, $check_query);

            // Exibe a turma com o link de solicitar acesso ou cancelar solicitação
            if (mysqli_num_rows($check_result) > 0) {
                echo "<div class='listaTurmas'>
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
                echo "<div class='listaTurmas'>
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
        echo "Nenhuma turma encontrada!";
    }
}
?>
