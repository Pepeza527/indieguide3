<?php
require 'config.php';  // Inclui o arquivo de configuração

// Verifica se o ID foi fornecido corretamente
if (!isset($_GET['id']) || !filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
    die("ID inválido ou não fornecido.");
}

$id = (int)$_GET['id']; // Converte o ID para inteiro

// Se o formulário for enviado, realiza a atualização
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $data = $_POST['data'];
    $preco_inscricao = $_POST['preco_inscricao'];
    $descricao = $_POST['descricao'];
    $imagem_url = $_POST['imagem_url'];

    // Prepara a consulta de atualização com o nome correto da coluna
    $sql = "UPDATE festival SET nome=?, data=?, preco_inscricao=?, descricao=?, imagem_url=? WHERE id_festival=?";
    $stmt = $conexao->prepare($sql);

    if ($stmt === false) {
        die("Erro ao preparar a consulta: " . $conexao->error);
    }

    $stmt->bind_param("sssssi", $nome, $data, $preco_inscricao, $descricao, $imagem_url, $id);

    if ($stmt->execute()) {
        header("Location: listar_fest.php");
        exit;
    } else {
        echo "<p>Erro ao editar o festival: " . $stmt->error . "</p>";
    }
}

// Consulta para buscar o festival a ser editado
$sql = "SELECT * FROM festival WHERE id_festival = ?";
$stmt = $conexao->prepare($sql);

if ($stmt === false) {
    die("Erro ao preparar a consulta: " . $conexao->error);
}

$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$festival = $result->fetch_assoc();

if (!$festival) {
    echo "<p>Festival não encontrado.</p>";
    exit;
}
?>
<!-- Formulário de edição -->
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Festival</title>
    <link rel="stylesheet" href="estilos/addfestivais.css"> <!-- Adicione o caminho correto -->
</head>
<body>
    <h1>Editar Festival</h1>
    <form action="" method="POST">
        <div class="form-group">
            <label for="nome">Nome</label>
            <input type="text" class="form-control" id="nome" name="nome" value="<?= htmlspecialchars($festival['nome'] ?? '') ?>" required>
        </div>
        <div class="form-group">
            <label for="data">Data</label>
            <input type="date" class="form-control" id="data" name="data" value="<?= htmlspecialchars($festival['data'] ?? '') ?>" required>
        </div>
        <div class="form-group">
            <label for="preco_inscricao">Preço de Inscrição</label>
            <input type="text" class="form-control" id="preco_inscricao" name="preco_inscricao" value="<?= htmlspecialchars($festival['preco_inscricao'] ?? '') ?>" required>
        </div>
        <div class="form-group">
            <label for="descricao">Descrição</label>
            <textarea class="form-control" id="descricao" name="descricao" required><?= htmlspecialchars($festival['descricao'] ?? '') ?></textarea>
        </div>
        <div class="form-group">
            <label for="imagem_url">Imagem URL</label>
            <input type="text" class="form-control" id="imagem_url" name="imagem_url" value="<?= htmlspecialchars($festival['imagem_url'] ?? '') ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Salvar</button>
    </form>
</body>
</html>
