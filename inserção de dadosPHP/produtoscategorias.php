<?php
// nome: Maxwell
// Conectar ao banco de dados (substitua pelos seus próprios dados)
$servername = "seu_servidor";
$username = "seu_usuario";
$password = "sua_senha";
$dbname = "seu_banco_de_dados";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Função para adicionar produto e associar à categoria
function adicionarProdutoCategoria($nomeProduto, $preco, $nomeCategoria) {
    global $conn;

    // Inserir produto
    $sqlProduto = "INSERT INTO produtos (nome_produto, preco) VALUES ('$nomeProduto', '$preco')";
    $conn->query($sqlProduto);

    // Obter o ID do produto recém-inserido
    $idProduto = $conn->insert_id;

    // Verificar se a categoria já existe
    $sqlCategoria = "SELECT id_categoria FROM categorias WHERE nome_categoria = '$nomeCategoria'";
    $result = $conn->query($sqlCategoria);

    // Se a categoria não existir, inseri-la
    if ($result->num_rows == 0) {
        $sqlNovaCategoria = "INSERT INTO categorias (nome_categoria) VALUES ('$nomeCategoria')";
        $conn->query($sqlNovaCategoria);

        // Obter o ID da categoria recém-inserida
        $idCategoria = $conn->insert_id;
    } else {
        $row = $result->fetch_assoc();
        $idCategoria = $row["id_categoria"];
    }

    // Atualizar a tabela de produtos com a categoria associada
    $sqlAtualizarProduto = "UPDATE produtos SET id_categoria = '$idCategoria' WHERE id_produto = '$idProduto'";
    $conn->query($sqlAtualizarProduto);
}

// Exemplo de uso
adicionarProdutoCategoria("Produto B", 30.0, "Eletrônicos");

// Fechar conexão
$conn->close();
?>
