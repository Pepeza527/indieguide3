<?php

include_once('config.php');

// Obtendo o ID do festival a partir da URL
$festival_id = isset($_GET['id']) ? $_GET['id'] : 0;

try {
    $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUsername, $dbPassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Erro ao conectar ao banco de dados: ' . $e->getMessage();
    exit;
}

// Obtendo informações do festival
$sql = "SELECT * FROM Festival WHERE id_festival = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id', $festival_id);
$stmt->execute();
$festival = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$festival) {
    echo "Festival não encontrado!";
    exit;
}

// // Obtendo as críticas do festival
// $sql_criticas = "SELECT c.comentario, c.data, u.first_name FROM criticas c
//                  JOIN usuarios u ON c.usuario_id = u.id
//                  WHERE c.festival_id = :id ORDER BY c.data DESC";
// $stmt_criticas = $pdo->prepare($sql_criticas);
// $stmt_criticas->bindParam(':id', $festival_id);
// $stmt_criticas->execute();
// $criticas = $stmt_criticas->fetchAll(PDO::FETCH_ASSOC);

// Processando o envio de uma nova crítica
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $comentario = $_POST['comentario'];
    $usuario_id = 1; // Substitua por um ID de usuário real (por exemplo, sessão do usuário)
    
    $sql_insert = "INSERT INTO criticas (festival_id, usuario_id, comentario, data) 
                   VALUES (:festival_id, :usuario_id, :comentario, NOW())";
    $stmt_insert = $pdo->prepare($sql_insert);
    $stmt_insert->bindParam(':festival_id', $festival_id);
    $stmt_insert->bindParam(':usuario_id', $usuario_id);
    $stmt_insert->bindParam(':comentario', $comentario);
    $stmt_insert->execute();
    
    header("Location:template_fest.php " . $_SERVER['REQUEST_URI']); 
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($festival['nome_festival']); ?></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="estilos/template_fest.css">
    
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="/">INDIE GUIDE AWARDS</a>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" href="festivais.php">Festivais</a></li>
                <li class="nav-item"><a class="nav-link" href="addfest.php">Adicionar Festival</a></li>
                <li class="nav-item"><a class="nav-link" href="perfil.php">Perfil</a></li>
                <li class="nav-item"><a class="nav-link" href="filmes.php">Filmes</a></li>
            </ul>
        </div>
    </nav>

    <div class="vinheta">
        <?php if (!empty($festival['imagem'])): ?>
            <img src="<?= htmlspecialchars($festival['imagem']); ?>" alt="<?= htmlspecialchars($festival['nome_festival']); ?>">
        <?php else: ?>
            <p>Sem imagem disponível</p>
        <?php endif; ?>
        <div class="centered-text">
            <h1><?= htmlspecialchars($festival['nome_festival']); ?></h1>
        </div>
    </div>

    <div class="poster-container">
        <h2>Sobre o Festival</h2>
        <p><?= htmlspecialchars($festival['sobre']); ?></p>
        <h3>Regulamentos</h3>
    <p>
        <?php
        if (!empty($festival['regulacoes'])) {
            echo nl2br(htmlspecialchars($festival['regulacoes']));
        } else {
            echo "Regulamentos não disponíveis.";
        }
        ?>
    </p>
        <h3>Data</h3>
        <p>
        <?php
        if (!empty($festival['data'])) {
            echo date('d/m/Y', strtotime($festival['data']));
        } else {
            echo "Data não disponível";
        }
        ?>
    </p>
        <h3>Preço de Inscrição</h3>
        <p>    <?php
    if (isset($festival['preco_inscricao'])) {
        echo 'R$' . number_format($festival['preco_inscricao'], 2, ',', '.');
    } else {
        echo 'Preço não disponível';
    }
    ?></p>
     
</div>
    </div>

<!-- 
    <div class="comments-section">
        <h4>Críticas:</h4>
        <?php if (empty($criticas)): ?>
            <p>Seja o primeiro a comentar!</p>
        <?php else: ?>
            <?php foreach ($criticas as $critica): ?>
                <div class="mb-3 p-3" style="background-color: rgba(0, 0, 0, 0.7); color: white; border-radius: 5px;">
                    <p><strong><?= htmlspecialchars($critica['first_name']); ?></strong> (<?= date('d/m/Y', strtotime($critica['data'])); ?>):</p>
                    <p><?= htmlspecialchars($critica['comentario']); ?></p>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
        
        <form method="POST">
            <textarea name="comentario" rows="4" placeholder="Escreva sua crítica aqui..." required></textarea>
            <button type="submit" class="btn btn-dark">Enviar Crítica</button>
        </form>
    </div> -->

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
