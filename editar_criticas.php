<?php 
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['editar_comentario'])) {
    $id_critica = $_POST['id_critica'];
    $novo_comentario = $_POST['comentario'];

    $sql_update = "UPDATE criticas SET comentario = ? WHERE id = ? AND id_usuario = ?";
    $stmt_update = $conn->prepare($sql_update);

    if ($stmt_update === false) {
        die('Erro ao preparar a consulta: ' . $conn->error);
    }

    $stmt_update->bind_param("sii", $novo_comentario, $id_critica, $_SESSION['id_usuario']);
    $stmt_update->execute();

    header("Location: template_filme.php?id=$filme_id");
    exit;
}
?>