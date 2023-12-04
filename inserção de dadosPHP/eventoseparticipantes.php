<?php
//nome: Maxwell
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

// Dados do evento
$id_evento = 1;
$nome_evento = "Evento PHP";
$data_evento = "2023-01-01";

// Inserir dados do evento na tabela eventos
$sql_evento = "INSERT INTO eventos (id_evento, nome_evento, data) VALUES ($id_evento, '$nome_evento', '$data_evento')";

if ($conn->query($sql_evento) === TRUE) {
    echo "Dados do evento inseridos com sucesso.<br>";
} else {
    echo "Erro ao inserir dados do evento: " . $conn->error;
}

// Dados do participante
$id_participante = 1;
$nome_participante = "Participante PHP";

// Inserir dados do participante na tabela participantes
$sql_participante = "INSERT INTO participantes (id_participante, id_evento, nome_participante) VALUES ($id_participante, $id_evento, '$nome_participante')";

if ($conn->query($sql_participante) === TRUE) {
    echo "Dados do participante inseridos com sucesso.<br>";
} else {
    echo "Erro ao inserir dados do participante: " . $conn->error;
}

// Fechar conexão
$conn->close();
?>
