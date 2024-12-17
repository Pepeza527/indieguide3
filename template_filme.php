<?php
session_start();  // Inicia a sessão no início do código.

include_once('config.php');

// Conectar ao banco de dados
$conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

if ($conn->connect_error) {
    die('Erro ao conectar ao banco de dados: ' . $conn->connect_error);
}

// Verifique se o ID do filme foi fornecido
if (isset($_GET['id'])) {
    $filme_id = intval($_GET['id']);
} else {
    echo "ID do filme não fornecido.";
    exit;
}

// Consultar informações do filme
$sql_filme = "SELECT * FROM filme WHERE id_filme = ?";
$stmt_filme = $conn->prepare($sql_filme);
$stmt_filme->bind_param("i", $filme_id);
$stmt_filme->execute();
$result_filme = $stmt_filme->get_result();
$filme = $result_filme->fetch_assoc();

if (!$filme) {
    echo "Filme não encontrado.";
    exit;
}

// Consultar críticas do filme
$sql_criticas = "SELECT c.comentario, c.data, CONCAT(u.primeironome, ' ', u.sobrenome) AS nome, c.id_critica, c.id_usuario 
                 FROM critica c
                 JOIN Usuarios u ON c.id_usuario = u.id_usuario
                 WHERE c.id_filme = ? ORDER BY c.data DESC";

$stmt_criticas = $conn->prepare($sql_criticas);
$stmt_criticas->bind_param("i", $filme_id);
$stmt_criticas->execute();
$result_criticas = $stmt_criticas->get_result();
$criticas = $result_criticas->fetch_all(MYSQLI_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['comentario'])) {
        // Verificar se o usuário está logado
        if (!isset($_SESSION['id_usuario'])) {
            echo "Você precisa estar logado para enviar uma crítica.";
            exit;
        }

        $comentario = trim($_POST['comentario']);
        $id_usuario = $_SESSION['id_usuario']; // ID do usuário logado

        if (!empty($comentario)) {
            // Sanitizar o comentário para evitar ataques XSS
            $comentario = htmlspecialchars($comentario);

            // Query para inserir a crítica, incluindo id_usuario
            $sql_insert = "INSERT INTO critica (id_filme, id_usuario, comentario, data) VALUES (?, ?, ?, NOW())";
            $stmt_insert = $conn->prepare($sql_insert);
            $stmt_insert->bind_param("iis", $filme_id, $id_usuario, $comentario);
            $stmt_insert->execute();

            // Atualizar o array de críticas com a nova crítica
            $criticas[] = [
                'comentario' => $comentario,
                'data' => date('Y-m-d'),
                'nome' => 'Você', // Nome do próprio usuário (alternativamente, carregue da sessão)
                'id_critica' => $stmt_insert->insert_id,
                'id_usuario' => $id_usuario
            ];
        } else {
            echo "O comentário não pode estar vazio.";
        }
    }

    // Verificar se a exclusão de crítica foi solicitada
    if (isset($_POST['excluir_critica_id'])) {
        // Verificar se o usuário está logado e é o dono da crítica
        $excluir_critica_id = $_POST['excluir_critica_id'];
        if (!isset($_SESSION['id_usuario'])) {
            echo "Você precisa estar logado para excluir uma crítica.";
            exit;
        }

        // Verificar se o usuário logado é o dono da crítica
        $sql_verificar = "SELECT id_usuario FROM critica WHERE id_critica = ?";
        $stmt_verificar = $conn->prepare($sql_verificar);
        $stmt_verificar->bind_param("i", $excluir_critica_id);
        $stmt_verificar->execute();
        $result_verificar = $stmt_verificar->get_result();

        if ($result_verificar->num_rows > 0) {
            $critica = $result_verificar->fetch_assoc();

            // Se o usuário logado for o dono da crítica, ou um administrador, excluir a crítica
            if ($critica['id_usuario'] === $_SESSION['id_usuario'] || isset($_SESSION['tipo_usuario']) && $_SESSION['tipo_usuario'] === 'administrador') {
                $sql_delete = "DELETE FROM critica WHERE id_critica = ?";
                $stmt_delete = $conn->prepare($sql_delete);
                $stmt_delete->bind_param("i", $excluir_critica_id);
                $stmt_delete->execute();

                // Atualizar a lista de críticas após exclusão
                echo "Crítica excluída com sucesso.";
                header("Location: " . $_SERVER['PHP_SELF'] . "?id=" . $filme_id);
                exit;
            } else {
                echo "Você não tem permissão para excluir essa crítica.";
            }
        } else {
            echo "Crítica não encontrada.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($filme['nome_filme'] ?? 'Filme não encontrado'); ?></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="estilos/template_filme.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-success">
        <a class="navbar-brand" href="home.php">INDIE CRITICS</a>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" href="festival.php">Festivais</a></li>
                <li class="nav-item"><a class="nav-link" href="addfest.php">Adicionar Festival</a></li>
                <li class="nav-item"><a class="nav-link" href="perfil.php">Perfil</a></li>
                <li class="nav-item"><a class="nav-link" href="filmes.php">Filmes</a></li>
            </ul>
        </div>
    </nav>

    <div class="vinheta">
        <img src="<?= htmlspecialchars($filme['imagem'] ?? 'default.jpg'); ?>" alt="<?= htmlspecialchars($filme['nome_filme'] ?? 'Sem imagem'); ?>">
        <div class="centered-text">
            <h1><?= htmlspecialchars($filme['nome_filme'] ?? 'Título não disponível'); ?></h1>
            <h3><?= htmlspecialchars($filme['dir'] ?? 'Diretor não disponível'); ?></h3>
        </div>
    </div>

    <div class="poster-container">
    <img src="<?= htmlspecialchars($filme['imagem'] ?? 'default.jpg'); ?>" alt="Poster do filme">
    <div class="text">
        <h2><?= htmlspecialchars($filme['nome_filme'] ?? 'Título não disponível'); ?></h2>
        <p><strong>Sinopse:</strong> <?= htmlspecialchars($filme['sinopse'] ?? 'Sinopse não disponível'); ?></p>
        <p><strong>Diretor:</strong> <?= htmlspecialchars($filme['dir'] ?? 'Diretor não disponível'); ?></p>
        <p><strong>Roteirista:</strong> <?= htmlspecialchars($filme['roteirista'] ?? 'Roteirista não disponível'); ?></p>
    </div>
</div>

    <div class="text-center mb-3">
        <button class="btn btn-primary" data-toggle="collapse" data-target="#comentarios">Ver Críticas</button>
    </div>

    <div id="comentarios" class="collapse comments-section">
        <h4>Críticas:</h4>
        <?php if (empty($criticas)): ?>
            <p style="color: white;">Seja o primeiro a comentar!</p>
        <?php else: ?>
            <?php foreach ($criticas as $critica): ?>
                <div class="mb-3 p-3" style="background-color: rgba(0, 0, 0, 0.7); color: white; border-radius: 5px;">
                    <p><strong><?= htmlspecialchars($critica['nome']); ?></strong> (<?= date('d/m/Y', strtotime($critica['data'])); ?>):</p>
                    <p><?= htmlspecialchars($critica['comentario']); ?></p>

                    <!-- Excluir crítica -->
                    <?php if ($_SESSION['id_usuario'] == $critica['id_usuario'] || (isset($_SESSION['tipo_usuario']) && $_SESSION['tipo_usuario'] == 'administrador')): ?>
                        <form method="POST">
                            <input type="hidden" name="excluir_critica_id" value="<?= $critica['id_critica']; ?>">
                            <button type="submit" class="btn btn-danger">Excluir Crítica</button>
                        </form>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['id_usuario'])): ?>
            <form method="POST">
                <textarea name="comentario" rows="4" placeholder="Escreva sua crítica aqui..." required></textarea>
                <button type="submit" class="btn btn-dark">Enviar Crítica</button>
            </form>
        <?php else: ?>
            <p style="color: white;">Você precisa estar logado para deixar uma crítica. <a href="login.php" style="color: #0d6efd;">Faça login aqui</a>.</p>
        <?php endif; ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
