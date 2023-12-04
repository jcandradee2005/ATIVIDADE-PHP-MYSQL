<?php
$servername = "seu_servidor";
$username = "seu_usuario";
$password = "sua_senha";
$dbname = "seu_banco_de_dados";

// Conexão com o banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Processar o formulário quando enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome_projeto = $_POST["nome_projeto"];
    $descricao = $_POST["descricao"];
    $id_funcionario = $_POST["id_funcionario"];

    // Inserir dados na tabela projetos
    $sql_projetos = "INSERT INTO projetos (nome_projeto, descricao) VALUES ('$nome_projeto', '$descricao')";
    
    if ($conn->query($sql_projetos) === TRUE) {
        $id_projeto = $conn->insert_id;

        // Inserir dados na tabela atribuicoes
        $sql_atribuicoes = "INSERT INTO atribuicoes (id_projeto, id_funcionario) VALUES ('$id_projeto', '$id_funcionario')";

        if ($conn->query($sql_atribuicoes) === TRUE) {
            echo "Projeto e atribuição inseridos com sucesso.<br>";
        } else {
            echo "Erro ao inserir atribuição: " . $conn->error . "<br>";
        }
    } else {
        echo "Erro ao inserir projeto: " . $conn->error . "<br>";
    }
}

// Consultar funcionários para o menu dropdown
$sql_funcionarios = "SELECT id_funcionario, nome FROM funcionarios";
$result_funcionarios = $conn->query($sql_funcionarios);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inserir Projeto</title>
</head>
<body>

<h2>Inserir Projeto</h2>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    Nome do Projeto: <input type="text" name="nome_projeto" required><br>
    Descrição: <textarea name="descricao"></textarea><br>
    Funcionário:
    <select name="id_funcionario">
        <?php
        while ($row = $result_funcionarios->fetch_assoc()) {
            echo "<option value='".$row['id_funcionario']."'>".$row['nome']."</option>";
        }
        ?>
    </select><br>
    <input type="submit" value="Inserir Projeto">
</form>

</body>
</html>

<?php
// Fechar a conexão
$conn->close();
?>
