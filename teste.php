<?php
session_start();  // Inicia a sessão, deve ser a primeira coisa no arquivo PHP

include_once('config.php');  // Conecta ao banco de dados com as credenciais definidas em config.php

// Verifica se os campos foram preenchidos
if (isset($_POST['email']) && isset($_POST['senha'])) {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Sanitização do email e da senha (importante para evitar injeção de SQL)
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    $senha = trim($senha);

    // Verificar se o email e senha não estão vazios
    if (empty($email) || empty($senha)) {
        echo "Por favor, preencha todos os campos.";
        exit();
    }

    // Conectar ao banco de dados
    $conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);
    if ($conn->connect_error) {
        die('Erro ao conectar ao banco de dados: ' . $conn->connect_error);
    }

    // Consultar se o usuário existe e se a senha corresponde (Usando hash de senha)
    $sql = "SELECT id_usuario, tipo_usuario, senha FROM Usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die('Erro na preparação da consulta SQL: ' . $conn->error);
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $usuario = $result->fetch_assoc();

        // Verificar se a senha fornecida corresponde ao hash armazenado
        if (password_verify($senha, $usuario['senha'])) {
            // Salvar informações do usuário na sessão
            $_SESSION['id_usuario'] = $usuario['id_usuario'];
            $_SESSION['tipo_usuario'] = $usuario['tipo_usuario']; // 'normal' ou 'administrador'
            $_SESSION['email'] = $email; // Salva o email também, caso necessário

            // Redireciona de acordo com o tipo de usuário
            if ($usuario['tipo_usuario'] == 'administrador') {
                echo "Bem-vindo, Administrador!";
                header("Location: home.php");  // Redirecionar para a página principal ou outra
            } else {
                echo "Bem-vindo, Usuário Normal!";
                header("Location: home.php");  // Redireciona para a página principal de usuários normais
            }
            exit();
        } else {
            // Senha incorreta
            echo "Credenciais inválidas.";
        }
    } else {
        // Usuário não encontrado
        echo "Usuário não encontrado.";
    }

    // Fechar conexão
    $conn->close();
} else {
    // Redireciona se o formulário não foi preenchido corretamente
    echo "Por favor, preencha todos os campos de login.";
}


?>
