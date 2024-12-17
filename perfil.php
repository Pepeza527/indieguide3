<?php 
session_start();

// Verificar se o usuário está logado
if (empty($_SESSION['email']) || empty($_SESSION['id_usuario'])) {
    header('Location: cadastro.php');
    exit();
}

// Recuperar variáveis de sessão
$email = $_SESSION['email'];
$id_usuario = $_SESSION['id_usuario'];

include_once('config.php');

// Carregar dados do usuário
$usuario_sql = "SELECT primeironome, sobrenome FROM usuarios WHERE id_usuario = ?";
$usuario_stmt = $conexao->prepare($usuario_sql);

if (!$usuario_stmt) {
    die("Erro na preparação da consulta de usuário: " . $conexao->error);
}

$usuario_stmt->bind_param("i", $id_usuario);
$usuario_stmt->execute();
$usuario_result = $usuario_stmt->get_result();

if ($usuario_result->num_rows > 0) {
    // O usuário existe, então recuperar os dados
    $usuario = $usuario_result->fetch_assoc();
    $primeironome = htmlspecialchars($usuario['primeironome']);
    $sobrenome = htmlspecialchars($usuario['sobrenome']);
} else {
    // Caso o usuário não exista, redirecionar para o cadastro
    header('Location: cadastro.php');
    exit();
}

$usuario_stmt->close();

// Consulta para críticas do usuário
$criticas_sql = "SELECT id_critica, id_filme, comentario, data FROM critica WHERE id_usuario = ?";
$criticas_stmt = $conexao->prepare($criticas_sql);

if (!$criticas_stmt) {
    die("Erro na preparação da consulta de críticas: " . $conexao->error);
}

$criticas_stmt->bind_param("i", $id_usuario);
$criticas_stmt->execute();
$criticas_result = $criticas_stmt->get_result();

// Fechar conexões
$criticas_stmt->close();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil - IGA</title>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=HK+Grotesk:wght@400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="estilos/perfil.css">
</head>
<body>

<div class="content">
    <h1 class="main-title">PERFIL</h1>
    <hr class="title-underline">

    <!-- Nome do Usuário -->
    <div class="perfil-container">
        <h1><?php echo $primeironome . ' ' . $sobrenome; ?></h1>
    </div>

    <!-- Seção de Críticas -->
    <section class="criticas-section">
        <h2>Suas Críticas</h2>
        <ul>
            <?php
            if ($criticas_result->num_rows > 0) {
                while ($critica = $criticas_result->fetch_assoc()) {
                    echo "<li>
                            <p>" . htmlspecialchars($critica['comentario']) . "</p>
                            <small>Postado em: " . htmlspecialchars($critica['data']) . "</small>
                          </li>";
                }
            } else {
                echo "<li>Você ainda não escreveu nenhuma crítica.</li>";
            }
            ?>
        </ul>
    </section>
</div>

<?php
$conexao->close();
?>

</body>
</html>
