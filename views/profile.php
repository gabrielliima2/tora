<?php
    include("../scripts/conexao.php");
    include("../scripts/protect.php");

    $id_patente = $_SESSION['id_patente'];
    $usuario_id = $_SESSION['id']; // O ID do usuário logado

    $query = "SELECT * FROM usuarios WHERE id = '$usuario_id'";
    $resu = mysqli_query($mysqli, $query) or die(mysqli_connect_error());
    if ($resu) {
        $reg = mysqli_fetch_array($resu);
    }
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

    <main id="mainMenu">
        <div class="containerPerfil">
            <div id="perfilContainer">
                <div id="perfilName">
                    <?php if (!empty($reg['foto'])): ?>
                        <img src="<?php echo $reg['foto']; ?>" alt="Foto de perfil" class="fotoPerfil">
                    <?php else: ?>
                            <ion-icon class="fotoPerfil" name="person-circle-outline" style="border:none;"></ion-icon>
                    <?php endif; ?>
                    <h3><?php echo htmlspecialchars($reg['nome']); ?></h3>
                </div>

                <div class="perfilElements">
                    <h3>Nascimento</h3>
                    <div class="perfilInfoBanco">
                        <b><?php echo htmlspecialchars($reg['nascimento'] ); ?></b>
                    </div>
                </div>

                <div class="perfilElements">
                    <h3>Endereco</h3>
                    <div class="perfilInfoBanco">
                        <b><?php echo htmlspecialchars($reg['endereco'] ); ?></b>
                    </div>
                </div>

                <div class="perfilElements">
                    <h3>Bairro</h3>
                    <div class="perfilInfoBanco">
                        <b><?php echo htmlspecialchars($reg['bairro']); ?></b>
                    </div>
                </div>

                <div class="perfilElements">
                    <h3>Cidade</h3>
                    <div class="perfilInfoBanco">
                        <b><?php echo htmlspecialchars($reg['cidade'] ); ?></b>
                    </div>
                </div>

                <div class="perfilElements">
                    <h3>Estado</h3>
                    <div class="perfilInfoBanco">
                        <b><?php echo htmlspecialchars($reg['estado']); ?></b>
                    </div>
                </div>

                <div class="perfilElements">
                    <h3>Telefone</h3>
                    <div class="perfilInfoBanco">
                        <b><?php echo htmlspecialchars($reg['telefone']); ?></b>
                    </div>
                </div>
            </div>
        </div>
        <a href='alterarPerfil.php' class='botao editar'>
            <ion-icon name='pencil-sharp'></ion-icon>
            <span class='tooltip'>Editar</span>
        </a>
    </main>

</body>
</html>
