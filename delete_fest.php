<?php
require 'config.php';  // Inclui o arquivo de configuração

// Verifica se o ID foi passado corretamente
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Prepara a consulta de exclusão (corrige o nome da coluna para id_festival)
    $sql = "DELETE FROM festival WHERE id_festival = ?";
    $stmt = $conexao->prepare($sql);

    // Verifica se a preparação da consulta foi bem-sucedida
    if ($stmt === false) {
        die("Erro ao preparar a consulta: " . $conexao->error);
    }

    // Vincula o parâmetro e executa a consulta
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: listar_fest.php");
        exit;
    } else {
        echo "<p>Erro ao excluir o festival: " . $stmt->error . "</p>";
    }
} else {
    echo "<p>ID do festival não foi fornecido.</p>";
}
?>
