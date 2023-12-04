<?php
// nome: Maxwell
$servername = "seu_servidor_mysql";
$username = "seu_usuario_mysql";
$password = "sua_senha_mysql";
$dbname = "seu_banco_de_dados";

// Conexão com o banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Inserção de dados de autores
$sql = "INSERT INTO autores (id_autor, nome_autor) VALUES
    (1, 'Autor 1'),
    (2, 'Autor 2'),
    (3, 'Autor 3')";

if ($conn->multi_query($sql) === TRUE) {
    echo "Dados de autores inseridos com sucesso.<br>";
} else {
    echo "Erro ao inserir dados de autores: " . $conn->error;
}

// Inserção de dados de livros
$sql = "INSERT INTO livros (id_livro, titulo, ano_publicacao, id_autor) VALUES
    (1, 'Livro 1', 2000, 1),
    (2, 'Livro 2', 2010, 2),
    (3, 'Livro 3', 2020, 3)";

if ($conn->multi_query($sql) === TRUE) {
    echo "Dados de livros inseridos com sucesso.<br>";
} else {
    echo "Erro ao inserir dados de livros: " . $conn->error;
}

// Inserção de dados de eventos
$sql = "INSERT INTO eventos (id_evento, nome_evento, data) VALUES
    (1, 'Evento 1', '2023-01-01'),
    (2, 'Evento 2', '2023-02-15'),
    (3, 'Evento 3', '2023-05-10')";

if ($conn->multi_query($sql) === TRUE) {
    echo "Dados de eventos inseridos com sucesso.<br>";
} else {
    echo "Erro ao inserir dados de eventos: " . $conn->error;
}

// Inserção de dados de participantes
$sql = "INSERT INTO participantes (id_participante, id_evento, nome_participante) VALUES
    (1, 1, 'Maxwell'),
    (2, 1, 'Tiaguin'),
    (3, 2, 'Tonhão'),
    (4, 3, 'João Carlos')";

if ($conn->multi_query($sql) === TRUE) {
    echo "Dados de participantes inseridos com sucesso.<br>";
} else {
    echo "Erro ao inserir dados de participantes: " . $conn->error;
}

// Fecha a conexão
$conn->close();
?>
