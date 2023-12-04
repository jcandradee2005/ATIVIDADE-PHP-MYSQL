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

// Dados do paciente
$id_paciente = 1;
$nome_paciente = "Paciente PHP";
$data_nascimento = "1990-01-01";

// Inserir dados do paciente na tabela pacientes
$sql_paciente = "INSERT INTO pacientes (id_paciente, nome_paciente, data_nascimento) VALUES ($id_paciente, '$nome_paciente', '$data_nascimento')";

if ($conn->query($sql_paciente) === TRUE) {
    echo "Dados do paciente inseridos com sucesso.<br>";
} else {
    echo "Erro ao inserir dados do paciente: " . $conn->error;
}

// Dados do resultado do exame
$id_resultado = 1;
$tipo_exame = "Hematologia";
$resultado = "Dentro da faixa normal";

// Inserir dados do resultado do exame na tabela resultados_exames
$sql_resultado = "INSERT INTO resultados_exames (id_resultado, tipo_exame, resultado) VALUES ($id_resultado, '$tipo_exame', '$resultado')";

if ($conn->query($sql_resultado) === TRUE) {
    echo "Dados do resultado do exame inseridos com sucesso.<br>";
} else {
    echo "Erro ao inserir dados do resultado do exame: " . $conn->error;
}

// Fechar conexão
$conn->close();
?>
