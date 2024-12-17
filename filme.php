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

// Buscar todos os filmes
$sql = "SELECT * FROM filme";
$stmt = $pdo->query($sql);
$filmes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Filmes</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="estilos/filmes.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-success">
        <a class="navbar-brand" href="home.php">INDIE GUIDE AWARDS</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" href="criticas.php">Crítica</a></li>
                <li class="nav-item"><a class="nav-link text-dark" href="admin">Administração</a></li>
                <li class="nav-item"><a class="nav-link" href="addfilmes.php">Adicionar Filmes</a></li>
            </ul>
        </div>
    </nav>

    <div class="container mt-5">
        <h2 class="mb-4">Tabela de Filmes</h2>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Filme</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Diretor</th>
                    <th scope="col">Roteirista</th>
                    <!-- <th scope="col">Elenco</th>
                    <th scope="col">Imagem</th>
                    <th scope="col">Ação</th> -->
                </tr>
            </thead>
            <tbody>
                <?php foreach ($filmes as $filme): ?>
                <tr>
                    <td><?php if (!empty($filme['imagem'])): ?>
                            <img src="<?php echo htmlspecialchars($filme['imagem']); ?>" alt="<?php echo htmlspecialchars($filme['nome_filme']); ?>" class="poster-img" width="100">
                        <?php else: ?>
                            <p>Sem imagem</p>
                        <?php endif; ?></td>
                    <td><?php echo htmlspecialchars($filme['nome_filme']); ?></td>
                    <td><?php echo htmlspecialchars($filme['dir'] ?? 'N/A'); ?></td>
                    <td><?php echo htmlspecialchars($filme['roteirista'] ?? 'N/A'); ?></td>
                    <!-- <td><?php echo htmlspecialchars($filme['elenco'] ?? 'N/A'); ?></td> -->
                    <td>
                        
                    </td>
                    <td>
                        <a href="template_filme.php?id=<?php echo htmlspecialchars($filme['id_filme']); ?>" class="btn btn-primary btn-sm">Ver detalhes</a>
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
