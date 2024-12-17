<?php 
// Inclui as configurações do banco de dados
require 'config.php';

// Verifica se a conexão foi bem-sucedida
if ($conexao->connect_errno) {
    die("Erro de conexão com o banco de dados: " . $conexao->connect_error);
}

$sql = "SELECT * FROM festival";
$result = $conexao->query($sql);

if (!$result) {
    die("Erro na consulta SQL: " . $conexao->error);
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Listar Festivais</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h3>Lista de Festivais</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th>Premios</th>
                    <th>Regulamento</th>
                    <th>Imagem</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?= $row['id_festival'] ?></td>
                        <td><?= $row['nome_festival'] ?></td>
                        <td><?= $row['sobre'] ?></td>
                        <td><?= $row['premios'] ?></td>
                        <td><?= $row['regulacoes'] ?></td>
                        <td><img src="<?= $row['imagem'] ?>" style="width: 100px;"></td>
                        <td>
                            <a href="editar_fest.php?id=<?= $row['id_festival'] ?>" class="btn btn-warning">Editar</a>
                            <a href="delete_fest.php?id=<?= $row['id_festival'] ?>" class="btn btn-danger" onclick="return confirm('Tem certeza?')">Excluir</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php
// Fecha a conexão com o banco de dados
$conexao->close();
?>
