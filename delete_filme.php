<?php
require 'config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Verifica se a conexão está aberta corretamente
    if ($conexao instanceof mysqli) {
        $stmt = $conexao->prepare("DELETE FROM filme WHERE id_filme = ?");
        if ($stmt) {
            $stmt->bind_param('i', $id);

            // Executa a query
            if ($stmt->execute()) {
                // Redireciona em caso de sucesso
                header('Location: listar_filme.php');
                exit;
            } else {
                echo "<p>Erro ao excluir o filme: " . htmlspecialchars($stmt->error) . "</p>";
            }

            // Fecha o statement
            $stmt->close();
        } else {
            echo "<p>Erro na preparação da query: " . htmlspecialchars($conexao->error) . "</p>";
        }
    } else {
        echo "<p>Erro: Conexão com o banco de dados não encontrada.</p>";
    }
} else {
    echo "<p>Erro: ID do filme não fornecido.</p>";
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excluir Filme</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Excluir Filme</h1>
    <p>Você tem certeza de que deseja excluir este filme?</p>

    <!-- Botões para confirmar ou cancelar a exclusão -->
    <form action="excluir_filme.php" method="get">
        <input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">
        <button type="submit">Excluir</button>
        <a href="listar_filmes.php" style="text-decoration: none;">
            <button type="button">Cancelar</button>
        </a>
    </form>
</body>
</html>
