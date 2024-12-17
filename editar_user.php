<?php
include_once('config.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM usuarios WHERE id = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nome = $_POST['name'];
    $email = $_POST['email'];
    $senha = $_POST['password'];

    $sql = "UPDATE usuarios SET nome = ?, email = ?, senha = ? WHERE id = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param('sssi', $nome, $email, $senha, $id);

    if ($stmt->execute()) {
        echo "Usuário atualizado com sucesso!";
    } else {
        echo "Erro ao atualizar usuário.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atualizar Usuário</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- CSS Personalizado -->
    <link rel="stylesheet" href="estilos/editar_user.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Atualizar Usuário</h2>
        <form action="update.php" method="POST">
            <!-- Campo oculto para o ID do usuário -->
            <input type="hidden" name="id" value="<?= htmlspecialchars($user['id']) ?>">

            <div class="form-group">
                <label for="name">Nome:</label>
                <input 
                    type="text" 
                    id="name" 
                    name="name" 
                    class="form-control" 
                    value="<?= htmlspecialchars($user['nome']) ?>" 
                    required>
            </div>
            
            <div class="form-group">
                <label for="email">Email:</label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    class="form-control" 
                    value="<?= htmlspecialchars($user['email']) ?>" 
                    required>
            </div>
            
            <div class="form-group">
                <label for="password">Senha:</label>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    class="form-control" 
                    value="<?= htmlspecialchars($user['senha']) ?>" 
                    required>
            </div>
            
            <button type="submit" class="btn btn-primary btn-block">Atualizar</button>
        </form>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

