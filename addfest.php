<?php 
require 'config.php';

try {
    // Aqui, apenas certifique-se de que as variáveis $host, $dbname, $user e $password estão definidas corretamente em 'config.php'
    $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUsername, $dbPassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Erro ao conectar ao banco de dados: ' . $e->getMessage();
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome_festival = htmlspecialchars(trim($_POST['nome_festival']));
    $sobre = htmlspecialchars(trim($_POST['sobre']));
    $regulacoes = htmlspecialchars(trim($_POST['regulacoes']));
    $imagem = htmlspecialchars(trim($_POST['imagem']));

    if (!empty($nome_festival) && !empty($sobre) && !empty($regulacoes) && !empty($imagem)) {
        $sql = "INSERT INTO Festival (nome_festival, sobre, regulacoes, imagem) 
                VALUES (:nome_festival, :sobre, :regulacoes, :imagem)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nome_festival', $nome_festival);
        $stmt->bindParam(':sobre', $sobre);
        $stmt->bindParam(':regulacoes', $regulacoes);
        $stmt->bindParam(':imagem', $imagem);

        if ($stmt->execute()) {
            $new_festival_id = $pdo->lastInsertId(); 
            header("Location: template_fest.php?id=$new_festival_id"); 
            exit;
        } else {
            echo "<p>Erro ao adicionar o festival.</p>";
        }
    } else {
        echo "<p>Por favor, preencha todos os campos corretamente.</p>";
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
    <link rel="stylesheet" href="estilos/addfest.css"> 
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="/">INDIE GUIDE AWARDS</a>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" href="festivais.php">Festivais</a></li>
                <li class="nav-item"><a class="nav-link" href="addfest.php">Adicionar Festival</a></li>
                <li class="nav-item"><a class="nav-link" href="editar_fest.php">Editar Festival</a></li>
                <li class="nav-item"><a class="nav-link" href="listar_fest.php">Listar Festival</a></li> 
                <li class="nav-item"><a class="nav-link" href="delete_fest.php">Deletar Festival</a></li>
                <li class="nav-item"><a class="nav-link" href="admin.php">Administração</a></li> 

                <li class="nav-item"><a class="nav-link" href="editar_user.php">Editar Usuário</a></li>
                <li class="nav-item"><a class="nav-link" href="listar_user.php">Listar Usuário</a></li> 
                <li class="nav-item"><a class="nav-link" href="delete_user.php">Deletar Usuário</a></li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <h3 class="section-title" style="color: #C8BA97; margin-top: 40px;">Adicionar Festival</h3>
        <form action="addfest.php" method="POST">
            <div class="form-group">
                <label for="nome_festival">Nome do Festival</label>
                <input type="text" class="form-control" id="nome_festival" name="nome_festival" required>
            </div>
            <div class="form-group">
                <label for="sobre">Sobre</label>
                <textarea class="form-control" id="sobre" name="sobre" rows="3" required></textarea>
            </div>
            <div class="form-group">
                <label for="regulacoes">Regulamentos</label>
                <textarea class="form-control" id="regulacoes" name="regulacoes" rows="3" required></textarea>
            </div>
            <div class="form-group">
                <label for="preco_inscricao">Preço de Inscrição</label>
                <input type="number" class="form-control" id="preco_inscricao" name="preco_inscricao" step="0.01" required>
            </div>
            <div class="form-group">
                <label for="date">Data</label>
                <input type="date" class="form-control" id="date" name="date" required>
            </div>
            <div class="form-group">
                <label for="imagem">Imagem</label>
                <input type="file" class="form-control" id="imagem" name="imagem" required>
            </div>
            <button type="submit" class="btn btn-primary">Adicionar Festival</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>