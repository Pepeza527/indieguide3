<?php 
require 'config.php';

$sql = "SELECT * FROM filme";
$result = $conexao->query($sql);

// Verifica se a consulta foi bem-sucedida
if (!$result) {
    die("Erro na consulta SQL: " . $conexao->error);
}

// Armazena os resultados da consulta na variável $filmes
$filmes = $result->fetch_all(MYSQLI_ASSOC);  // Isso converte o resultado para um array associativo
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listar Filmes</title>
</head>
<body>
    <h1>Lista de Filmes</h1>
    <a href="addfilmes.php">Adicionar Novo Filme</a>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Diretor</th>
                <th>Roteirista</th>
                <th>Elenco</th>
                <th>Imagem</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($filmes as $filme): ?>
                <tr>
                    <td><?= htmlspecialchars($filme['id_filme']) ?></td>
                    <td><?= htmlspecialchars($filme['nome_filme']) ?></td>
                    <td><?= htmlspecialchars($filme['dir']) ?></td>
                    <td><?= htmlspecialchars($filme['roteirista']) ?></td>
                    <td><?= htmlspecialchars($filme['elenco']) ?></td>
                    <td><img src="<?= htmlspecialchars($filme['imagem']) ?>" alt="Imagem do Filme" width="100"></td>
                    <td>
                        <a href="editar_filme.php?id=<?= $filme['id_filme'] ?>">Editar</a>
                        <a href="delete_filme.php?id=<?= $filme['id_filme'] ?>" onclick="return confirm('Tem certeza que deseja excluir?');">Excluir</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
