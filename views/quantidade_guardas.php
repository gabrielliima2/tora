<?php
include("../scripts/conexao.php");
include("../scripts/protect.php");

date_default_timezone_set('America/Sao_Paulo');

$userId = $_SESSION['id'];
$id_patente = $_SESSION['id_patente'];
$turma_id = $_SESSION['turma_id'];


if ($id_patente == "4") {
    verificaAcesso("4");
} else{
    verificaAcesso("3");
}

$queryAtiradores = "SELECT u.id, u.nome 
                    FROM usuarios u
                    INNER JOIN turma_usuario tu ON u.id = tu.id_usuario
                    WHERE tu.id_turma = '$turma_id' AND u.id_patente = 1";
$resultAtiradores = mysqli_query($mysqli, $queryAtiradores);

$atiradoresQuantidades = [];

while ($atirador = mysqli_fetch_assoc($resultAtiradores)) {
    $atirador_id = $atirador['id'];

    // Conta quantas vezes o atirador aparece nas escalas
    $queryContagemEscalas = "SELECT COUNT(*) as quantidade FROM escala_de_guarda 
                             WHERE FIND_IN_SET('$atirador_id', atiradores) > 0 AND id_turma = '$turma_id'";
    $resultContagem = mysqli_query($mysqli, $queryContagemEscalas);
    $contagem = mysqli_fetch_assoc($resultContagem);

    $atiradoresQuantidades[] = [
        'nome' => $atirador['nome'],
        'quantidade' => $contagem['quantidade']
    ];
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/style.css">
    <script src="../assets/js/script.js" defer></script>
    <script src="../assets/js/scriptEscala.js" defer></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js" defer></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js" defer></script>
    <style>
       
    </style>

    <title>Tóra</title>
</head>
<body>
    <?php include("../components/header.php"); ?>
    <?php include("../components/turmaMenu.php"); ?>

    <main class="mainQuantidadesGuardas">
        <table class="tableContagemEscalas">
            <thead>
                <tr>
                    <th>Atirador</th>
                    <th>Quantidade de Guardas</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($atiradoresQuantidades as $item) { ?>
                    <tr>
                        <td><?php echo $item['nome']; ?></td>
                        <td><?php echo $item['quantidade']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <a href="telaEscalaDeGuarda.php" class="buttons">Voltar</a>
    </main>
</body>
</html>
