<?php
// conexão com o banco de dados
$con = mysqli_connect("localhost", "root", "", "cadastro");

if (mysqli_connect_errno()) {
 echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

// verificar se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {

 // inserir novo usuário na tabela 'usuarios'
 $nome = $_POST["nome"];
 $email = $_POST["email"];

 $sql = "INSERT INTO usuarios (nome, email) VALUES ('$nome', '$email')";

 if (mysqli_query($con, $sql)) {
    $id_usuario = mysqli_insert_id($con);
    echo "New user registered successfully. Last inserted ID: " . $id_usuario;
 } else {
    echo "Error: " . $sql . "<br>" . mysqli_error($con);
 }

 // inserir novo pedido na tabela 'pedidos'
 $produto = $_POST["produto"];
 $quantidade = $_POST["quantidade"];

 $sql = "INSERT INTO pedidos (id_usuario, produto, quantidade) VALUES ('$id_usuario', '$produto', '$quantidade')";

 if (mysqli_query($con, $sql)) {
    echo "New order registered successfully.";
 } else {
    echo "Error: " . $sql . "<br>" . mysqli_error($con);
 }

 // fechar conexão
 mysqli_close($con);
}
?>

<!DOCTYPE html>
<html>
<body>

<h2>Registre um novo usuário e seu pedido</h2>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
 Nome: <input type="text" name="nome">
 <br>
 E-mail: <input type="text" name="email">
 <br>
 Produto: <input type="text" name="produto">
 <br>
 Quantidade: <input type="text" name="quantidade">
 <br><br>
 <input type="submit" value="Registrar">
</form>

</body>
</html>
