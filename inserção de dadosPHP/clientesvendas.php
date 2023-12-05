<?php
$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "myDB";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$nome = $_POST["nome"];
$email = $_POST["email"];
$produto_vendido = $_POST["produto_vendido"];
$valor = $_POST["valor"];

$sql = "INSERT INTO clientes (nome, email) VALUES ('$nome', '$email')";

if ($conn->query($sql) === TRUE) {
    $id_cliente = $conn->insert_id;
    echo "Cliente inserido com sucesso. ID: " . $id_cliente;
} else {
    echo "Erro: " . $sql . "<br>" . $conn->error;
}

$sql = "INSERT INTO vendas (id_cliente, produto_vendido, valor) VALUES ('$id_cliente', '$produto_vendido', '$valor')";

if ($conn->query($sql) === TRUE) {
    $id_venda = $conn->insert_id;
    echo "Venda inserida com sucesso. ID: " . $id_venda;
} else {
    echo "Erro: " . $sql . "<br>" . $conn->error;
}

// Fechar conexão
$conn->close();
}
?>

<!DOCTYPE html>
<html>
<body>

<h2>Registro de Clientes e Vendas</h2>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
 Nome: <input type="text" name="nome">
 <br>
 E-mail: <input type="text" name="email">
 <br>
 Produto Vendido: <input type="text" name="produto_vendido">
 <br>
 Valor: <input type="text" name="valor">
 <br><br>
 <input type="submit" value="Registrar">
</form>

</body>
</html>
