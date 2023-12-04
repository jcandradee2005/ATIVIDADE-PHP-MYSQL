<?php
// nome: Maxwell
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
    $nome = $_POST["nome"];
    $cargo = $_POST["cargo"];
    $id_departamento = $_POST["id_departamento"];

    // Inserir dados na tabela funcionarios
    $sql_funcionarios = "INSERT INTO funcionarios (nome, cargo, id_departamento) VALUES ('$nome', '$cargo', '$id_departamento')";
    
    if ($conn->query($sql_funcionarios) === TRUE) {
        echo "Funcionário inserido com sucesso.<br>";
    } else {
        echo "Erro ao inserir funcionário: " . $conn->error . "<br>";
    }
}

// Consultar departamentos para o menu dropdown
$sql_departamentos = "SELECT id_departamento, nome_departamento FROM departamentos";
$result_departamentos = $conn->query($sql_departamentos);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inserir Funcionário</title>
</head>
<body>

<h2>Inserir Funcionário</h2>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    Nome: <input type="text" name="nome" required><br>
    Cargo: <input type="text" name="cargo" required><br>
    Departamento:
    <select name="id_departamento">
        <?php
        while ($row = $result_departamentos->fetch_assoc()) {
            echo "<option value='".$row['id_departamento']."'>".$row['nome_departamento']."</option>";
        }
        ?>
    </select><br>
    <input type="submit" value="Inserir Funcionário">
</form>

</body>
</html>

<?php
// Fechar a conexão
$conn->close();
?>
