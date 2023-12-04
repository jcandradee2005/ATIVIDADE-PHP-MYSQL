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

// Função para inserir novo usuário e pedido
function inserirUsuarioPedido($nome, $email, $produto, $quantidade) {
    global $conn;

    // Inserir usuário
    $sqlUsuario = "INSERT INTO usuarios (nome, email) VALUES ('$nome', '$email')";
    $conn->query($sqlUsuario);

    // Obter o ID do usuário recém-inserido
    $idUsuario = $conn->insert_id;

    // Inserir pedido associado ao usuário
    $sqlPedido = "INSERT INTO pedidos (id_usuario, produto, quantidade) VALUES ('$idUsuario', '$produto', '$quantidade')";
    $conn->query($sqlPedido);
}

// Exemplo de uso
inserirUsuarioPedido("João Carlos", "jcgalo@email.com", "Produto A", 2);

// Fechar conexão
$conn->close();
?>
