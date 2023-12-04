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

// Função para inserir novo cliente e venda
function inserirClienteVenda($nome, $email, $produtoVendido, $valor) {
    global $conn;

    // Inserir cliente
    $sqlCliente = "INSERT INTO clientes (nome, email) VALUES ('$nome', '$email')";
    $conn->query($sqlCliente);

    // Obter o ID do cliente recém-inserido
    $idCliente = $conn->insert_id;

    // Inserir venda associada ao cliente
    $sqlVenda = "INSERT INTO vendas (id_cliente, produto_vendido, valor) VALUES ('$idCliente', '$produtoVendido', '$valor')";
    $conn->query($sqlVenda);
}

// Exemplo de uso
inserirClienteVenda("Maxwell", "maxwell@email.com", "Produto C", 50.0);

// Fechar conexão
$conn->close();
?>
