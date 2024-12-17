<!-- <?php
include_once('config.php');

// Iniciar a sessão no início do script para garantir que a variável de sessão esteja disponível
session_start();

try {
    // Usar as variáveis definidas no config.php
    $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUsername, $dbPassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Erro ao conectar ao banco de dados: ' . $e->getMessage();
    exit;
}

// Verifique se o ID do filme foi passado e é válido
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $filme_id = (int)$_GET['id'];
} else {
    echo "ID do filme inválido ou não fornecido.";
    exit;
}

// Consulta para verificar se o filme existe
$sql_check_filme = "SELECT * FROM filme WHERE id_filme = ?";
$stmt_check_filme = $pdo->prepare($sql_check_filme);
$stmt_check_filme->bindParam(1, $filme_id, PDO::PARAM_INT);
$stmt_check_filme->execute();
$filme = $stmt_check_filme->fetch(PDO::FETCH_ASSOC);

if (!$filme) {
    echo "Filme não encontrado.";
    exit;
}

// Consulta para buscar todas as críticas
$sql = "SELECT c.id_critica AS id, c.comentario, c.data, u.nome AS usuario, u.id_usuario, f.nome_filme 
        FROM critica c
        JOIN usuario u ON c.id_usuario = u.id_usuario
        JOIN filme f ON c.id_filme = f.id_filme
        WHERE c.id_filme = ?
        ORDER BY c.data DESC";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(1, $filme_id, PDO::PARAM_INT);
$stmt->execute();
$criticas = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Editar crítica
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['editar_comentario'])) {
    // Certifique-se de que a variável de sessão foi iniciada corretamente
    if (!isset($_SESSION['id_usuario'])) {
        echo "Sessão não iniciada corretamente.";
        exit;
    }

    $id_critica = $_POST['id_critica'];
    $novo_comentario = $_POST['comentario'];

    $sql_update = "UPDATE critica SET comentario = ? WHERE id_critica = ? AND id_usuario = ?";
    $stmt_update = $pdo->prepare($sql_update);
    $stmt_update->bindParam(1, $novo_comentario);
    $stmt_update->bindParam(2, $id_critica);
    $stmt_update->bindParam(3, $_SESSION['id_usuario']);
    $stmt_update->execute();

    // Redireciona para a página de críticas do filme
    header("Location: criticas.php?id=" . $filme_id);
    exit;
}

// Deletar crítica
if (isset($_GET['deletar_critica'])) {
    // Certifique-se de que a variável de sessão foi iniciada corretamente
    if (!isset($_SESSION['id_usuario'])) {
        echo "Sessão não iniciada corretamente.";
        exit;
    }

    $id_critica = $_GET['deletar_critica'];

    $sql_delete = "DELETE FROM critica WHERE id_critica = ? AND id_usuario = ?";
    $stmt_delete = $pdo->prepare($sql_delete);
    $stmt_delete->bindParam(1, $id_critica);
    $stmt_delete->bindParam(2, $_SESSION['id_usuario']);
    $stmt_delete->execute();

    // Redireciona para a página de críticas do filme
    header("Location: criticas.php?id=" . $filme_id);
    exit;
}
?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Críticas de Filmes</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="estilos/criticas.css">
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
                <li class="nav-item"><a class="nav-link" href="criticas.php">Críticas</a></li>
                <li class="nav-item"><a class="nav-link" href="filme.php">Filmes</a></li>
                <li class="nav-item"><a class="nav-link text-dark" href="admin">Administração</a></li>
            </ul>
        </div>
    </nav>

    <div class="container mt-5">
        <h2>Críticas de <?php echo htmlspecialchars($filme['nome_filme']); ?></h2>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Usuário</th>
                    <th scope="col">Comentário</th>
                    <th scope="col">Data</th>
                    <th scope="col">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($criticas as $critica): ?>
                <tr>
                    <td><?php echo htmlspecialchars($critica['usuario']); ?></td>
                    <td><?php echo nl2br(htmlspecialchars($critica['comentario'])); ?></td>
                    <td><?php echo date('d/m/Y', strtotime($critica['data'])); ?></td>
                    <td>
                        <?php if ($_SESSION['id_usuario'] === $critica['id_usuario']): ?>
                            <a href="?deletar_critica=<?php echo $critica['id']; ?>" class="btn btn-danger btn-sm">Excluir</a>
                            <form method="POST" class="mt-2">
                                <textarea name="comentario" class="form-control" rows="2"><?php echo htmlspecialchars($critica['comentario']); ?></textarea>
                                <input type="hidden" name="id_critica" value="<?php echo $critica['id']; ?>">
                                <button type="submit" name="editar_comentario" class="btn btn-dark btn-sm mt-2">Editar</button>
                            </form>
                        <?php endif; ?>
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
</html> -->
