<?php
// nome: Maxwell
$servername = "seu_servidor_mysql";
$username = "seu_usuario_mysql";
$password = "sua_senha_mysql";
$dbname = "seu_banco_de_dados";

// Criar conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Dados do livro
$id_livro = 1;
$titulo_livro = "O Livro";
$ano_publicacao = 2022;

// Dados do autor
$id_autor = 1;
$nome_autor = "Autor Sobrenome";

// Inserir dados do autor na tabela autores
$sql_autor = "INSERT INTO autores (id_autor, nome_autor) VALUES ($id_autor, '$nome_autor')";

if ($conn->query($sql_autor) === TRUE) {
    echo "Dados do autor inseridos com sucesso.<br>";
} else {
    echo "Erro ao inserir dados do autor: " . $conn->error;
}

// Inserir dados do livro na tabela livros
$sql_livro = "INSERT INTO livros (id_livro, titulo, ano_publicacao, id_autor) VALUES ($id_livro, '$titulo_livro', $ano_publicacao, $id_autor)";

if ($conn->query($sql_livro) === TRUE) {
    echo "Dados do livro inseridos com sucesso.<br>";
} else {
    echo "Erro ao inserir dados do livro: " . $conn->error;
}

// Fechar conexão
$conn->close();
?>
