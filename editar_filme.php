<?php
require 'config.php';

// Verifica se o ID foi fornecido e se é um número válido
if (!isset($_GET['id']) || !filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
    die('ID inválido ou não fornecido.');
}

$id = (int)$_GET['id']; // Converte o ID para um inteiro

// Verifica se a conexão MySQLi está definida
if (!isset($conexao)) {
    die('Erro ao conectar ao banco de dados.');
}

// Consulta para buscar o filme
$sql = "SELECT * FROM filme WHERE id_filme = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param('i', $id); // Vincula o ID como parâmetro inteiro
$stmt->execute();
$result = $stmt->get_result();
$filme = $result->fetch_assoc();

// Verifica se o filme foi encontrado
if (!$filme) {
    die('Filme não encontrado.');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome_filme = $_POST['nome_filme'] ?? '';
    $diretor = $_POST['diretor'] ?? '';
    $roteirista = $_POST['roteirista'] ?? '';
    $elenco = $_POST['elenco'] ?? '';
    $imagem = $_POST['imagem'] ?? ''; // Adicionando o campo imagem
    $id_festival = $_POST['id_festival'] ?? ''; // Adicionando o campo id_festival

    // Atualiza o filme no banco de dados
    $sql = "UPDATE filmes SET nome_filme = ?, dir = ?, roteirista = ?, elenco = ?, imagem = ?, id_festival = ? WHERE id_filme = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param('ssssssi', $nome_filme, $diretor, $roteirista, $elenco, $imagem, $id_festival, $id);

    if ($stmt->execute()) {
        header('Location: listar_filmes.php');
        exit;
    } else {
        echo "<p>Erro ao atualizar o filme.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Filme</title>
    <link rel="stylesheet" href="estilos/addfilmes.css">
</head>
<body>
    <h1>Editar Filme</h1>
    <form action="editar_filme.php?id=<?= htmlspecialchars($id) ?>" method="post">
        <label for="nome_filme">Nome do Filme:</label>
        <input type="text" id="nome_filme" name="nome_filme" value="<?= htmlspecialchars($filme['nome_filme']) ?>" required>
        
        <label for="diretor">Diretor:</label>
        <input type="text" id="diretor" name="diretor" value="<?= htmlspecialchars($filme['dir']) ?>">
        
        <label for="roteirista">Roteirista:</label>
        <input type="text" id="roteirista" name="roteirista" value="<?= htmlspecialchars($filme['roteirista']) ?>">
        
        <label for="elenco">Elenco:</label>
        <textarea id="elenco" name="elenco" required><?= htmlspecialchars($filme['elenco']) ?></textarea>
        
        <label for="imagem">Imagem:</label>
        <input type="text" id="imagem" name="imagem" value="<?= htmlspecialchars($filme['imagem']) ?>">
        
        <label for="id_festival">ID do Festival:</label>
        <input type="text" id="id_festival" name="id_festival" value="<?= htmlspecialchars($filme['id_festival']) ?>">

        <button type="submit">Atualizar Filme</button>
    </form>
</body>
</html>
