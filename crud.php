<?php
// Configuração do banco de dados
$host = "localhost";
$username = "root";
$password = "123456"; // Adicione sua senha aqui
$dbname = "festival_filmes";

try {
    // Conexão com o banco de dados
    $conexao = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Funções CRUD para Festival
    function adicionarFestival($nome, $sobre, $regulacoes, $premios, $imagem, $conexao) {
        $sql = "INSERT INTO Festival (nome_festival, sobre, regulacoes, premios, imagem) 
                VALUES (:nome, :sobre, :regulacoes, :premios, :imagem)";
        $stmt = $conexao->prepare($sql);
        $stmt->execute([
            ':nome' => $nome,
            ':sobre' => $sobre,
            ':regulacoes' => $regulacoes,
            ':premios' => $premios,
            ':imagem' => $imagem
        ]);
        echo "Festival adicionado com sucesso!<br>";
    }

    function editarFestival($id, $nome, $sobre, $regulacoes, $premios, $conexao) {
        $sql = "UPDATE Festival 
                SET nome_festival = :nome, sobre = :sobre, regulacoes = :regulacoes, premios = :premios 
                WHERE id_festival = :id";
        $stmt = $conexao->prepare($sql);
        $stmt->execute([
            ':nome' => $nome,
            ':sobre' => $sobre,
            ':regulacoes' => $regulacoes,
            ':premios' => $premios,
            ':id' => $id
        ]);
        echo "Festival atualizado com sucesso!<br>";
    }

    function excluirFestival($id, $conexao) {
        $sql = "DELETE FROM Festival WHERE id_festival = :id";
        $stmt = $conexao->prepare($sql);
        $stmt->execute([':id' => $id]);
        echo "Festival excluído com sucesso!<br>";
    }

    // Funções CRUD para Filme
    function adicionarFilme($nome, $dir, $roteirista, $elenco, $id_festival, $conexao) {
        $sql = "INSERT INTO Filme (nome_filme, dir, roteirista, elenco, id_festival) 
                VALUES (:nome, :dir, :roteirista, :elenco, :id_festival)";
        $stmt = $conexao->prepare($sql);
        $stmt->execute([
            ':nome' => $nome,
            ':dir' => $dir,
            ':roteirista' => $roteirista,
            ':elenco' => $elenco,
            ':id_festival' => $id_festival
        ]);
        echo "Filme adicionado com sucesso!<br>";
    }

    function editarFilme($id, $nome, $dir, $roteirista, $elenco, $id_festival, $conexao) {
        $sql = "UPDATE Filme 
                SET nome_filme = :nome, dir = :dir, roteirista = :roteirista, elenco = :elenco, id_festival = :id_festival 
                WHERE id_filme = :id";
        $stmt = $conexao->prepare($sql);
        $stmt->execute([
            ':nome' => $nome,
            ':dir' => $dir,
            ':roteirista' => $roteirista,
            ':elenco' => $elenco,
            ':id_festival' => $id_festival,
            ':id' => $id
        ]);
        echo "Filme atualizado com sucesso!<br>";
    }

    function excluirFilme($id, $conexao) {
        $sql = "DELETE FROM Filme WHERE id_filme = :id";
        $stmt = $conexao->prepare($sql);
        $stmt->execute([':id' => $id]);
        echo "Filme excluído com sucesso!<br>";
    }

} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}

// Lógica de upload de imagem e adição de festival
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['acao']) && $_POST['acao'] === 'adicionar_festival') {
    $nome = $_POST['nome_festival'];
    $sobre = $_POST['sobre'];
    $regulacoes = $_POST['regulacoes'];
    $premios = $_POST['premios'];
    $imagem = null;

    // Verifica se o arquivo foi enviado
    if (isset($_FILES['imagem_festival']) && $_FILES['imagem_festival']['error'] === 0) {
        $nomeImagem = time() . '_' . basename($_FILES['imagem_festival']['name']);
        $caminhoTemp = $_FILES['imagem_festival']['tmp_name'];
        $caminhoDestino = 'uploads/' . $nomeImagem;

        // Move a imagem para o diretório de destino
        if (move_uploaded_file($caminhoTemp, $caminhoDestino)) {
            $imagem = $caminhoDestino;
        } else {
            echo "Erro ao salvar a imagem.<br>";
        }
    }

    // Adiciona o festival ao banco de dados
    if ($imagem) {
        adicionarFestival($nome, $sobre, $regulacoes, $premios, $imagem, $conexao);
        echo "Festival adicionado com sucesso com a imagem: $imagem<br>";
    } else {
        echo "Erro: Imagem não foi salva.<br>";
    }
}
?>
