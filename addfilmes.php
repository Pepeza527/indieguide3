<?php
require 'config.php'; // Certifique-se de que o caminho está correto

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Coleta os dados do formulário
    $nome_filme = $_POST['nome_filme'] ?? '';
    $sinopse = $_POST['sinopse'] ?? '';
    $diretor = $_POST['diretor'] ?? '';
    $roteirista = $_POST['roteirista'] ?? '';
    $duracao = $_POST['duracao'] ?? '';
    $elenco = $_POST['elenco'] ?? '';
    // $id_festival = $_POST['id_festival']; 

   
    // if (empty($id_festival)) {
    //     echo "ID do festival não fornecido!";
    //     exit;
    // }

    // if (empty($nome_filme) || empty($elenco) || empty($id_festival)) {
    //     echo "<p>Por favor, preencha todos os campos obrigatórios.</p>";
    // } else {
   
        $imagem = $_FILES['imagem_filme'];
        if ($imagem['error'] === UPLOAD_ERR_OK) {
            $nome_imagem = time() . '_' . $imagem['name'];
            $caminho_destino = 'uploads/' . $nome_imagem;

            if (move_uploaded_file($imagem['tmp_name'], $caminho_destino)) {
               
                $sql = "INSERT INTO Filme (nome_filme, dir, roteirista, elenco, imagem, id_festival) 
                        VALUES (?, ?, ?, ?, ?, ?)";
                $stmt = $conexao->prepare($sql);  

                
                $stmt->bind_param("sssssi", $nome_filme, $diretor, $roteirista, $elenco, $caminho_destino, $id_festival);

                if ($stmt->execute()) {
                    header("Location: template_filme.php?id=" . $conexao->insert_id);
                    exit;
                } else {
                    echo "<p>Erro ao adicionar o filme.</p>";
                }
            } else {
                echo "<p>Erro ao fazer upload da imagem.</p>";
            }
        } else {
            echo "<p>Erro no arquivo de imagem.</p>";
        }
    }


?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Festivais e Filmes</title>
    <link rel="stylesheet" href="estilos/addfilmes.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="/">INDIE GUIDE AWARDS</a>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" href="addfest.php">Adicionar Festival</a></li>
                <li class="nav-item"><a class="nav-link" href="editar_filme.php">Editar filmes</a></li>
                <li class="nav-item"><a class="nav-link" href="listar_filme.php">Listar filmes</a></li>
                <li class="nav-item"><a class="nav-link" href="delete_filme.php">Deletar filmes</a></li>
                <li class="nav-item"><a class="nav-link" href="admin.php">Administração</a></li>
                <li class="nav-item"><a class="nav-link" href="editar_user.php">Editar Usuário</a></li>
            </ul>
        </div>
    </nav>

    <form action="addfilmes.php" method="post" enctype="multipart/form-data">
        <h1>Gerenciar Filmes</h1>
        <h2>Adicionar Filme</h2>

        <label for="nome_filme">Nome do Filme:</label>
        <input type="text" id="nome_filme" name="nome_filme" required>

        <label for="diretor">Diretor:</label>
        <input type="text" id="diretor" name="diretor">

        <label for="roteirista">Roteirista:</label>
        <input type="text" id="roteirista" name="roteirista">

        <label for="sinopse">Sinopse</label>
        <input type="text" id="sinopse" name="sinopse">

        <label for="elenco">Elenco:</label>
        <textarea id="elenco" name="elenco" required></textarea>

        <label for="duracao">Duração (em minutos)</label>
        <input type="number" id="duracao" name="duracao" min="1">

        <label for="imagem_filme">Imagem:</label>
        <input type="file" id="imagem_filme" name="imagem_filme" accept="image/*" required>

        <!-- <label for="id_festival">Festival:</label>
        <select id="id_festival" name="id_festival" required>
       
  
    
        </select> -->

        <button type="submit" name="acao" value="adicionar_filme">Adicionar Filme</button>
    </form>
</body>
</html>
