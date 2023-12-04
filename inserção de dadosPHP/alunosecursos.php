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
    $nome_aluno = $_POST["nome_aluno"];
    $turma = $_POST["turma"];
    $nome_curso = $_POST["nome_curso"];
    $instrutor = $_POST["instrutor"];

    // Inserir dados na tabela alunos
    $sql_alunos = "INSERT INTO alunos (nome, turma) VALUES ('$nome_aluno', '$turma')";
    
    if ($conn->query($sql_alunos) === TRUE) {
        $id_aluno = $conn->insert_id;

        // Inserir dados na tabela cursos
        $sql_cursos = "INSERT INTO cursos (nome_curso, instrutor) VALUES ('$nome_curso', '$instrutor')";
        
        if ($conn->query($sql_cursos) === TRUE) {
            $id_curso = $conn->insert_id;

            // Associar aluno ao curso na tabela de relacionamento
            $sql_relacionamento = "INSERT INTO aluno_curso_relacionamento (id_aluno, id_curso) VALUES ('$id_aluno', '$id_curso')";
            
            if ($conn->query($sql_relacionamento) === TRUE) {
                echo "Aluno registrado e matriculado no curso com sucesso.<br>";
            } else {
                echo "Erro ao associar aluno ao curso: " . $conn->error . "<br>";
            }
        } else {
            echo "Erro ao registrar curso: " . $conn->error . "<br>";
        }
    } else {
        echo "Erro ao registrar aluno: " . $conn->error . "<br>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Aluno e Curso</title>
</head>
<body>

<h2>Registrar Aluno e Curso</h2>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    Nome do Aluno: <input type="text" name="nome_aluno" required><br>
    Turma: <input type="text" name="turma" required><br>
    Nome do Curso: <input type="text" name="nome_curso" required><br>
    Instrutor do Curso: <input type="text" name="instrutor" required><br>
    <input type="submit" value="Registrar">
</form>

</body>
</html>

<?php
// Fechar a conexão
$conn->close();
?>
