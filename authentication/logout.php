<?php

if(!isset($_SESSION)){
    session_start();
}

//se exitir login ele vai apagar as variaveis SESSION fazendo com que você tenha que fazer login novamente
session_destroy();

header("Location: ../index.php");
?>