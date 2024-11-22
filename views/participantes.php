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

$query_usuarios = "SELECT u.nome AS usuario_nome, u.foto, p.nome AS patente, id_usuario
                   FROM turma_usuario tu
                   INNER JOIN usuarios u ON tu.id_usuario = u.id
                   INNER JOIN patente p ON u.id_patente = p.id
                   WHERE tu.id_turma = '$turma_id'";
$result_usuarios = mysqli_query($mysqli, $query_usuarios) or die(mysqli_error($mysqli));;

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
            if (mysqli_num_rows($result_usuarios) > 0) {
                while ($usuario = mysqli_fetch_assoc($result_usuarios)) {
                ?>
                    <div class='listaTurmas'>
                        <a href='perfilParticipante.php?id=<?php echo $usuario['id_usuario']?>' class='linkAbrir'></a>
                        <div class="fotoPerfilParticipante">
                            <?php if (!empty($usuario['foto']) && file_exists($usuario['foto'])): ?>
                                    <img src="<?php echo $usuario['foto']; ?>" alt="Foto de perfil" class="profileImageParticipante">
                            <?php else: ?>
                                    <ion-icon name="person-circle-outline" class="profileImageParticipante" style="border:none;"></ion-icon>
                            <?php endif; ?>
                        </div>
                        <div class='containerInfoParticipante'>
                                <h3><?php echo $usuario['usuario_nome'];?></h3>
                                <p><?php echo $usuario['patente'];?></p>
                        </div>
                        <div class='containerAcoesTurma'>
                                <a href='patenteParticipante.php?id=<?php echo $usuario['id_usuario']?>' class='botao editar'>
                                    Patente
                                    <span class='tooltip'>Alterar patente</span>
                                </a>
                                <a href='removerParticipante.php?id=<?php echo $usuario['id_usuario']?>' class='botao excluir'>
                                        Remover
                                    <span class='tooltip'>Remover usuário</span>
                                </a>
                        </div>
                    </div>
                <?php
                }
            } else {
                echo "<p>Nenhum participante nesta turma.</p>";
            }
            ?>
            </div>
        </div>
    </main>
</body>
</html>
