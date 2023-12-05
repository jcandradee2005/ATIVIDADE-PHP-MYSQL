<?php

$host = 'localhost';
$dbname = 'meu_banco_de_dados';
$user = 'meu_usuario';
$password = 'minha_senha';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Insere o evento
    $sql = "INSERT INTO eventos (nome_evento, data) VALUES (:nome_evento, :data)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':nome_evento', $nome_evento);
    $stmt->bindParam(':data', $data);

    $nome_evento = 'Meu Evento';
    $data = '2022-05-01';

    $stmt->execute();

    // Obtem o id_evento inserido
    $id_evento = $conn->lastInsertId();

    // Insere os participantes do evento
    $sql = "INSERT INTO participantes (id_evento, nome_participante) VALUES (:id_evento, :nome_participante)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id_evento', $id_evento);
    $stmt->bindParam(':nome_participante', $nome_participante);

    $participantes = ['João', 'Maria', 'Ana'];

    foreach ($participantes as $nome_participante) {
        $stmt->execute();
    }

    echo "Evento e participantes inseridos com sucesso!";

} catch(PDOException $e) {
    echo "Erro: " . $e->getMessage();
}

$conn = null;

?>
