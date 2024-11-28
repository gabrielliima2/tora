<?php
include('../scripts/conexao.php');

if (isset($_POST['email']) || isset($_POST['senha'])) {
    if (strlen($_POST['email']) == 0) {
        echo 'Preencha seu e-mail';
    } else if (strlen($_POST['senha']) == 0) {
        echo 'Preencha sua senha';
    } else {
        $email = $mysqli->real_escape_string($_POST['email']);
        $senha = $_POST['senha']; // Não escapamos a senha

        $query = "SELECT * FROM usuarios WHERE email = '$email'";
        $resu = $mysqli->query($query) or die("Falha na execução do código SQL: " . $mysqli->error);

        if ($resu->num_rows == 1) {
            $usuario = $resu->fetch_assoc();
            
            // Verifica se a senha informada corresponde ao hash armazenado
            if (password_verify($senha, $usuario['senha'])) {
                if (!isset($_SESSION)) {
                    session_start();
                }

                $_SESSION['id'] = $usuario['id'];
                $_SESSION['username'] = $usuario['nome'];
                $_SESSION['email'] = $usuario['email'];
                $_SESSION['senha'] = $usuario['senha'];
                $_SESSION['id_patente'] = $usuario['id_patente']; // Armazena a patente

                header('Location: ../views/home.php');
                exit();
            } else {
                echo "Falha ao logar! E-mail ou senha incorretos";
            }
        } else {
            echo "Falha ao logar! E-mail ou senha incorretos";
        }
    }
}
?>