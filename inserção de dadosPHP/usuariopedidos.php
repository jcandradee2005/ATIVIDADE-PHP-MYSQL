<?php
// conexão com o banco de dados
$con = mysqli_connect("localhost", "root", "", "cadastro");

if (mysqli_connect_errno()) {
 echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

// verificar se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {

 // inserir novo aluno na tabela 'alunos'
 $nome = $_POST["nome"];
 $turma = $_POST["turma"];

 $sql = "INSERT INTO alunos (nome, turma) VALUES ('$nome', '$turma')";

 if (mysqli_query($con, $sql)) {
    $id_aluno = mysqli_insert_id($con);
    echo "New student registered successfully. Last inserted ID: " . $id_aluno;
 } else {
    echo "Error: " . $sql . "<br>" . mysqli_error($con);
 }

 // inserir novo curso na tabela 'cursos'
 $nome_curso = $_POST["nome_curso"];
 $instrutor = $_POST["instrutor"];

 $sql = "INSERT INTO cursos (id_aluno, nome_curso, instrutor) VALUES ('$id_aluno', '$nome_curso', '$instrutor')";

 if (mysqli_query($con, $sql)) {
    echo "New course registered successfully.";
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

<h2>Registre um novo aluno e seu curso</h2>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
 Nome: <input type="text" name="nome">
 <br>
 Turma: <input type="text" name="turma">
 <br>
 Nome do Curso: <input type="text" name="nome_curso">
 <br>
 Instrutor: <input type="text" name="instrutor">
 <br><br>
 <input type="submit" value="Registrar">
</form>

</body>
</html>
