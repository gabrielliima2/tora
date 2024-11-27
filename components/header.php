<?php
    include("../scripts/conexao.php");


    $usuario_id_header = $_SESSION['id']; 

    $query_header = "SELECT * FROM usuarios WHERE id = '$usuario_id_header'";
    $resu_header = mysqli_query($mysqli, $query_header) or die(mysqli_connect_error());
    if ($resu_header) {
        $reg_header = mysqli_fetch_array($resu_header);
    }
?>



<header id="mainHeader">
        <div class="openNavMenuButton">
            <ion-icon id="buttonOpenNav" size="large" name="menu"></ion-icon>
        </div>
        <h1>TÓRA</h1>
        <div class="profileImage">
                    <?php if (!empty($reg_header['foto'])): ?>
                        <img src="<?php echo $reg_header['foto']; ?>" alt="Foto de perfil" class="profileImageHeader">
                    <?php else: ?>
                        <ion-icon name="person-circle-outline" class="profileImageHeader" style="border:none;"></ion-icon>
                    <?php endif; ?>
        </div>
</header>



