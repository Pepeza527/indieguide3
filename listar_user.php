<?php 
include_once('config.php');

$sql = "SELECT * FROM usuarios";
$result = $conexao->query($sql);


if (!$result) {
    die("Erro na consulta SQL: " . $conexao->error);
}
?>

<table border="1">
    <tr>
        <th>ID</th>
        <th>Nome</th>
        <th>sobrenome</th>
        <th>senha</th>
        <th>Email</th>
        <th>Ações</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?= $row['id_usuario'] ?></td>
            <td><?= $row['primeironome'] ?></td>
            <td><?= $row['sobrenome'] ?></td>
            <td><?= $row['senha'] ?></td>
            <td><?= $row['email'] ?></td>
            <td>
                <a href="editar_user.php?id=<?= $row['id_usuario'] ?>">Editar</a>
                <a href="delete_user.php?id=<?= $row['id_usuario'] ?>">Excluir</a>
            </td>
        </tr>
    <?php } ?>
</table>
