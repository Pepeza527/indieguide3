<?php
// Configuração do banco de dados
$host = "localhost";
$username = "root";
$password = "123456"; // Adicione sua senha aqui
$dbname = "festival_filmes";

try {
    $conexao = new PDO("mysql:host=$host", $username, $password);
    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Criar banco de dados
    $conexao->exec("CREATE DATABASE IF NOT EXISTS $dbname");
    $conexao->exec("USE $dbname");

    // Criar tabelas
    $sql = "
    -- Tabela Usuario
    CREATE TABLE IF NOT EXISTS Usuario (
        id_usuario INT AUTO_INCREMENT PRIMARY KEY,
        nome VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL UNIQUE,
        senha VARCHAR(255) NOT NULL,
        cpf VARCHAR(11) NOT NULL UNIQUE
    );

    -- Tabela Administrador (herança de Usuario)
    CREATE TABLE IF NOT EXISTS Administrador (
        id_administrador INT AUTO_INCREMENT PRIMARY KEY,
        id_usuario INT NOT NULL,
        identificacao VARCHAR(50),
        FOREIGN KEY (id_usuario) REFERENCES Usuario(id_usuario)
    );

    -- Tabela Festival
    CREATE TABLE IF NOT EXISTS Festival (
        id_festival INT AUTO_INCREMENT PRIMARY KEY,
        nome_festival VARCHAR(100) NOT NULL,
        sobre TEXT,
        regulacoes TEXT,
        premios TEXT
        ALTER TABLE Festival ADD COLUMN imagem VARCHAR(255);
    );

    -- Tabela Filme
    CREATE TABLE IF NOT EXISTS Filme (
        id_filme INT AUTO_INCREMENT PRIMARY KEY,
        nome_filme VARCHAR(100) NOT NULL,
        dir VARCHAR(100), -- Diretor
        roteirista VARCHAR(100),
        elenco TEXT,
        ALTER TABLE Filme ADD COLUMN imagem VARCHAR(255);
        id_festival INT,
        FOREIGN KEY (id_festival) REFERENCES Festival(id_festival)
    );

    -- Tabela Informacao_equipe
    CREATE TABLE IF NOT EXISTS Informacao_equipe (
        id_equipe INT AUTO_INCREMENT PRIMARY KEY,
        nome VARCHAR(100) NOT NULL,
        data_nasc DATE,
        filmes_que_trabalhou TEXT
    );

    -- Tabela Equipe_e_filme (associação)
    CREATE TABLE IF NOT EXISTS Equipe_e_filme (
        id_equipe INT NOT NULL,
        id_filme INT NOT NULL,
        PRIMARY KEY (id_equipe, id_filme),
        FOREIGN KEY (id_equipe) REFERENCES Informacao_equipe(id_equipe),
        FOREIGN KEY (id_filme) REFERENCES Filme(id_filme)
    );

    -- Tabela Critica
    CREATE TABLE IF NOT EXISTS Critica (
        id_critica INT AUTO_INCREMENT PRIMARY KEY,
        id_usuario INT NOT NULL,
        id_filme INT NOT NULL,
        data DATE NOT NULL,
        comentario TEXT,
        FOREIGN KEY (id_usuario) REFERENCES Usuario(id_usuario),
        FOREIGN KEY (id_filme) REFERENCES Filme(id_filme)
    );
    ";

    $conexao->exec($sql);

    echo "Banco de dados e tabelas criados com sucesso!";
} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}
