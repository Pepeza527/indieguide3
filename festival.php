<?php
// include('navbar.php');
include_once('config.php'); 

try {
    // Usar as variáveis definidas no config.php
    $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUsername, $dbPassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Erro ao conectar ao banco de dados: ' . $e->getMessage();
    exit;
}

$sql = "SELECT * FROM festival"; // Alterando para a tabela de festivais
$stmt = $pdo->query($sql);
$festivais = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Festivais</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="estilos/festivais.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-success">
        <a class="navbar-brand" href="/">INDIE GUIDE AWARDS</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" href="template_fest.php">Festivais</a></li>
                <!-- <li class="nav-item"><a class="nav-link" href="criticas.php">Crítica</a></li> -->
                <li class="nav-item"><a class="nav-link" href="filme.php">Filmes</a></li>
                <li class="nav-item"><a class="nav-link text-dark" href="admin">Administração</a></li>
            </ul>
        </div>
    </nav>

    <div class="container mt-5">
        <h2 class="mb-4">Festivais</h2>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Festival</th>
                    <th scope="col">Sobre</th>
                    <!-- <th scope="col">Regulamentos</th>
                    <th scope="col">Imagem</th>
                    <th scope="col">Ações</th> -->
                </tr>
            </thead>
            <tbody>
                <?php foreach ($festivais as $festival): ?>
                <tr>
                <td>
                        <?php if (!empty($festival['imagem'])): ?>
                            <img src="<?php echo htmlspecialchars($festival['imagem']); ?>" alt="<?php echo htmlspecialchars($festival['nome_festival']); ?>" class="poster-img" width="100">
                        <?php else: ?>
                            <p>Sem imagem</p>
                        <?php endif; ?>
                    </td>
                    <td><?php echo htmlspecialchars($festival['nome_festival']); ?></td>
                    <!-- <td><?php echo htmlspecialchars($festival['sobre'] ?? 'N/A'); ?></td>
                    <td><?php echo htmlspecialchars($festival['regulacoes'] ?? 'N/A'); ?></td> -->
                    
                    <td>
                        <a href="template_fest.php?id=<?php echo $festival['id_festival']; ?>">Ver detalhes</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
