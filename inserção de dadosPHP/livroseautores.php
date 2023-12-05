<?php //nome: maxwell
// Conexão com o banco de dados
$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "myDB";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Verificar se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Inserir dados do livro na tabela 'livros'
    $titulo = $_POST["titulo"];
    $ano_publicacao = $_POST["ano_publicacao"];

    $sql = "INSERT INTO livros (titulo, ano_publicacao) VALUES ('$titulo', '$ano_publicacao')";

    if ($conn->query($sql) === TRUE) {
        $id_livro = $conn->insert_id;
        echo "Livro inserido com sucesso. ID: " . $id_livro;
    } else {
        echo "Erro: " . $sql . "<br>" . $conn->error;
    }

    // Inserir dados do autor na tabela 'autores'
    $nome_autor = $_POST["nome_autor"];

    $sql = "SELECT id_autor FROM autores WHERE nome_autor = '$nome_autor'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $id_autor = $row["id_autor"];
    } else {
        $sql = "INSERT INTO autores (nome_autor) VALUES ('$nome_autor')";

        if ($conn->query($sql) === TRUE) {
            $id_autor = $conn->insert_id;
            echo "Autor inserido com sucesso. ID: " . $id_autor;
        } else {
            echo "Erro: " . $sql . "<br>" . $conn->error;
        }
    }

    // Vincular o livro ao autor na tabela 'livros_autores'
    $sql = "INSERT INTO livros_autores (id_livro, id_autor) VALUES ('$id_livro', '$id_autor')";

    if ($conn->query($sql) === TRUE) {
        echo "Livro " . $id_livro . " vinculado ao autor " . $id_autor . " com sucesso.";
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

<h2>Cadastro de Livros e Autores</h2>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
 Título: <input type="text" name="titulo">
 <br>
 Ano de Publicação: <input type="text" name="ano_publicacao">
 <br>
 Nome do Autor: <input type="text" name="nome_autor">
 <br><br>
 <input type="submit" value="Cadastrar">
</form>

</body>
</html>
