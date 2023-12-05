<?php
// nome: maxwell
$host = 'localhost';
$dbname = 'meu_banco_de_dados';
$user = 'meu_usuario';
$password = 'minha_senha';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Insere o paciente
    $sql = "INSERT INTO pacientes (nome_paciente, data_nascimento) VALUES (:nome_paciente, :data_nascimento)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':nome_paciente', $nome_paciente);
    $stmt->bindParam(':data_nascimento', $data_nascimento);

    $nome_paciente = 'João Silva';
    $data_nascimento = '1985-07-23';

    $stmt->execute();

    // Obtem o id_paciente inserido
    $id_paciente = $conn->lastInsertId();

    // Insere o resultado do exame do paciente
    $sql = "INSERT INTO resultados_exames (id_paciente, tipo_exame, resultado) VALUES (:id_paciente, :tipo_exame, :resultado)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id_paciente', $id_paciente);
    $stmt->bindParam(':tipo_exame', $tipo_exame);
    $stmt->bindParam(':resultado', $resultado);

    $tipo_exame = 'Análise de Sangue';
    $resultado = 'Negativo para COVID-19';

    $stmt->execute();

    echo "Resultado do exame e paciente inseridos com sucesso!";

} catch(PDOException $e) {
    echo "Erro: " . $e->getMessage();
}

$conn = null;

?>
