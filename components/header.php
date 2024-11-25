<?php
    include("../scripts/conexao.php");

    $usuario_id_header_only = $_SESSION['id'];

    $queryHeaderOnly = "SELECT * FROM usuarios WHERE id = '$usuario_id_header_only'";
    $resu_query_header_only = mysqli_query($mysqli, $queryHeaderOnly) or die(mysqli_connect_error());

    if ($resu_query_header_only) {
        $reg_resu_query_header_only_resu_query_header_only = mysqli_fetch_array($resu_query_header_only);
    }
?>



<header id="mainHeader">
        <div class="openNavMenuButton">
            <ion-icon id="buttonOpenNav" size="large" name="menu"></ion-icon>
        </div>
        <h1>TÓRA</h1>
        <div class="profileImage">
            <?php if (!empty($reg_resu_query_header_only['foto'])): ?>
                    <img src="<?php echo $reg_resu_query_header_only['foto']; ?>" alt="Foto de perfil" class="profileImageHeader">
                <?php else: ?>
                    <ion-icon name="person-circle-outline" class="profileImageHeader" style="border:none;"></ion-icon>
            <?php endif; ?>
        </div>
</header>
