<?php
// conexão com o banco de dados
$con = mysqli_connect("localhost", "root", "", "gerenciamento_produtos");

if (mysqli_connect_errno()) {
 echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

// verificar se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {

 // inserir novo produto na tabela 'produtos'
 $nome_produto = $_POST["nome_produto"];
 $preco = $_POST["preco"];

 $sql = "INSERT INTO produtos (nome_produto, preco) VALUES ('$nome_produto', '$preco')";

 if (mysqli_query($con, $sql)) {
    $id_produto = mysqli_insert_id($con);
    echo "New product registered successfully. Last inserted ID: " . $id_produto;
 } else {
    echo "Error: " . $sql . "<br>" . mysqli_error($con);
 }

 // associar categoria ao produto na tabela 'categorias'
 $nome_categoria = $_POST["nome_categoria"];

 $sql = "SELECT id_categoria FROM categorias WHERE nome_categoria = '$nome_categoria'";
 $result = mysqli_query($con, $sql);

 if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $id_categoria = $row["id_categoria"];
 } else {
    $sql = "INSERT INTO categorias (nome_categoria) VALUES ('$nome_categoria')";

    if (mysqli_query($con, $sql)) {
        $id_categoria = mysqli_insert_id($con);
        echo "New category registered successfully. Last inserted ID: " . $id_categoria;
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($con);
    }
 }

 // atribuir produto à categoria na tabela 'produtos_categorias'
 $sql = "INSERT INTO produtos_categorias (id_produto, id_categoria) VALUES ('$id_produto', '$id_categoria')";

 if (mysqli_query($con, $sql)) {
    echo "Product " . $id_produto . " associated with category " . $id_categoria . " successfully.";
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

<h2>Registre um novo produto e atribua uma categoria</h2>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
 Nome do Produto: <input type="text" name="nome_produto">
 <br>
 Preço: <input type="text" name="preco">
 <br>
 Categoria: <input type="text" name="nome_categoria">
 <br><br>
 <input type="submit" value="Registrar">
</form>

</body>
</html>
