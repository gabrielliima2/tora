<?php
include('../scripts/conexao.php');

    if(isset($_POST['username']) || isset($_POST['email']) || isset($_POST['senha'])) {

    if(strlen($_POST['username']) == 0) {
        echo 'Preencha seu nome';
    } else if(strlen($_POST['email']) == 0) {
        echo 'Preencha seu e-mail';
    } else if(strlen($_POST['senha']) == 0) {
        echo 'Preencha sua senha';
    } else {
        $username = $mysqli->real_escape_string($_POST['username']);
        $email = $mysqli->real_escape_string($_POST['email']);
        $senha = $mysqli->real_escape_string($_POST['senha']);
        $senha = password_hash($senha, PASSWORD_DEFAULT);

        // Verifica se já existe um usuário com este e-mail
        $queryCheck = "SELECT * FROM usuarios WHERE email = '$email'";
        $resuCheck = $mysqli->query($queryCheck) or die("Falha na execução do código SQL: " . $mysqli->error);

        if($resuCheck->num_rows > 0) {
            echo 'E-mail já cadastrado!';
        } else {
            // Insere o novo usuário
            $query = "INSERT INTO usuarios (nome, email, senha, id_patente) VALUES ('$username', '$email', '$senha', 1)";
            $resu = $mysqli->query($query) or die("Falha na execução do código SQL: " . $mysqli->error);

            if($resu) {
                echo 'Cadastro realizado com sucesso!';
                header('Location: ../index.php');
            } else {
                echo 'Falha ao cadastrar usuário!';
            }
        }
    }
    }
?>