<?php
include_once('config.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Corrigido: Certifique-se de que o campo correto é id_usuario
    $sql = "DELETE FROM usuarios WHERE id_usuario = ?";  

    $stmt = $conexao->prepare($sql);

    if ($stmt === false) {
        die("Erro na preparação da consulta: " . $conexao->error);  
    }

    // Alterado o tipo de parâmetro de 'id' para 'i' para integer
    $stmt->bind_param('i', $id);  

    if ($stmt->execute()) {
        echo "Usuário excluído com sucesso!";
    } else {
        echo "Erro ao excluir usuário.";
    }

    // Fechar a declaração
    $stmt->close();
} else {
    echo "ID não fornecido.";
}
?>
