<?php
// conexão com o banco de dados
$con = mysqli_connect("localhost", "root", "", "gerenciamento_projetos");

if (mysqli_connect_errno()) {
 echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

// verificar se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {

 // inserir novo projeto na tabela 'projetos'
 $nome_projeto = $_POST["nome_projeto"];
 $descricao = $_POST["descricao"];

 $sql = "INSERT INTO projetos (nome_projeto, descricao) VALUES ('$nome_projeto', '$descricao')";

 if (mysqli_query($con, $sql)) {
    $id_projeto = mysqli_insert_id($con);
    echo "New project registered successfully. Last inserted ID: " . $id_projeto;
 } else {
    echo "Error: " . $sql . "<br>" . mysqli_error($con);
 }

 // associar funcionários ao projeto na tabela 'atribuicoes'
 $funcionarios = $_POST["funcionarios"];

 foreach ($funcionarios as $id_funcionario) {
     $sql = "INSERT INTO atribuicoes (id_projeto, id_funcionario) VALUES ('$id_projeto', '$id_funcionario')";

     if (mysqli_query($con, $sql)) {
        echo "Funcionário " . $id_funcionario . " atribuído ao projeto " . $id_projeto . " com sucesso.";
     } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($con);
     }
 }

 // fechar conexão
 mysqli_close($con);
}
?>

<!DOCTYPE html>
<html>
<body>

<h2>Registre um novo projeto e atribua funcionários</h2>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
 Nome do Projeto: <input type="text" name="nome_projeto">
 <br>
 Descrição: <textarea name="descricao"></textarea>
 <br>
 Funcionários: <br>
 <input type="checkbox" name="funcionarios[]" value="1"> Funcionário 1<br>
 <input type="checkbox" name="funcionarios[]" value="2"> Funcionário 2<br>
 <input type="checkbox" name="funcionarios[]" value="3"> Funcionário 3<br>
 <br><br>
 <input type="submit" value="Registrar">
</form>

</body>
</html>
