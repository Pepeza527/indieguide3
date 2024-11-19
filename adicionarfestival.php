<?php
// Conexão com o banco de dados
$host = 'localhost';
$dbname = 'festival_filmes';
$username = 'root';
$password = '123456';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Erro ao conectar ao banco de dados: ' . $e->getMessage();
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Captura os dados do formulário
    $nome = $_POST['nome'];
    $data = $_POST['data'];
    $preco_inscricao = $_POST['preco_inscricao'];
    $descricao = $_POST['descricao'];
    $imagem_url = $_POST['imagem_url'];

    // Insere os dados no banco de dados
    $sql = "INSERT INTO festivais (nome, data, preco_inscricao, descricao, imagem_url) 
            VALUES (:nome, :data, :preco_inscricao, :descricao, :imagem_url)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':data', $data);
    $stmt->bindParam(':preco_inscricao', $preco_inscricao);
    $stmt->bindParam(':descricao', $descricao);
    $stmt->bindParam(':imagem_url', $imagem_url);
    
    if ($stmt->execute()) {
        echo "<p>Festival adicionado com sucesso!</p>";
    } else {
        echo "<p>Erro ao adicionar o festival.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Festival</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Estilos para o cabeçalho */
        .navbar {
            background-color: #1c1c1c;
            display: flex;
            justify-content: flex-start;  /* Alinhando os itens à esquerda */
            align-items: center;
            padding: 10px 20px;
        }

        .navbar-brand {
            color: #C8BA97;
            font-weight: bold;
            font-size: 2rem;  /* Aumentando o tamanho do nome */
            text-decoration: none;
            margin-right: 30px; /* Espaço entre o nome e o menu */
        }

        .navbar-nav {
            list-style: none;
            display: flex;
            margin: 0;
            padding: 0;
        }

        .nav-item {
            margin-right: 15px;
        }

        .nav-link {
            color: #C8BA97;
            text-decoration: none;
            font-size: 1.1rem;
            transition: color 0.3s ease, transform 0.2s ease;
        }

        .nav-link:hover {
            color: #ffffff;
            transform: scale(1.1);
        }

        .nav-link:active {
            color: #FFD700;
        }

        /* Estilo do corpo */
        body {
            background-color: #0E1928;
            font-family: Arial, sans-serif;
            color: white;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            margin: 20px 0;
        }

        form {
            width: 90%;
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background: #1c1c1c;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
        }

        form h2 {
            color: #C8BA97;
        }

        label {
            display: block;
            margin: 10px 0;
            font-weight: bold;
        }

        input, textarea, button {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1rem;
        }

        button {
            background-color: #C8BA97;
            color: white;
            font-weight: bold;
            cursor: pointer;
            border: none;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #FFD700;
        }

        /* Estilo responsivo */
        @media (max-width: 768px) {
            .navbar {
                flex-direction: column;
                align-items: flex-start;
            }

            .navbar-nav {
                flex-direction: column;
                width: 100%;
            }

            .nav-item {
                margin-bottom: 10px;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="/">INDIE GUIDE AWARDS</a>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" href="festivais.html">Festivais</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Destaques da Temporada</a></li>
                <li class="nav-item"><a class="nav-link" href="/critica/">Crítica</a></li>
                <li class="nav-item"><a class="nav-link" href="/usuario/">Usuário</a></li>
                <li class="nav-item"><a class="nav-link" href="/admin/">Administração</a></li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <h3 class="section-title" style="color: #C8BA97; margin-top: 40px;">Adicionar Festival</h3>
        <form action="adicionar_festival.php" method="POST">
            <div class="form-group">
                <label for="nome">Nome do Festival</label>
                <input type="text" class="form-control" id="nome" name="nome" required>
            </div>
            <div class="form-group">
                <label for="data">Data</label>
                <input type="date" class="form-control" id="data" name="data" required>
            </div>
            <div class="form-group">
                <label for="preco_inscricao">Preço de Inscrição</label>
                <input type="number" class="form-control" id="preco_inscricao" name="preco_inscricao" step="0.01" required>
            </div>
            <div class="form-group">
                <label for="descricao">Descrição</label>
                <textarea class="form-control" id="descricao" name="descricao" rows="3" required></textarea>
            </div>
            <div class="form-group">
                <label for="imagem_url">URL da Imagem</label>
                <input type="text" class="form-control" id="imagem_url" name="imagem_url" required>
            </div>
            <button type="submit" class="btn btn-primary">Adicionar Festival</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
