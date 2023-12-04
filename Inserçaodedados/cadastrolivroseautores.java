import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;

public class cadastrolivrosautores {

    private static final String JDBC_URL = "jdbc:mysql://localhost/seu_banco_de_dados";
    private static final String JDBC_USER = "seu_usuario";
    private static final String JDBC_PASSWORD = "sua_senha";

    public static void cadastrarLivroEautor(String tituloLivro, int anoPublicacao, String nomeAutor) {
        try (Connection connection = DriverManager.getConnection(JDBC_URL, JDBC_USER, JDBC_PASSWORD)) {

            // Inserir autor na tabela autores
            int idAutor = inserirAutor(connection, nomeAutor);

            // Inserir livro na tabela livros associado ao autor
            if (idAutor > 0) {
                inserirLivro(connection, tituloLivro, anoPublicacao, idAutor);
                System.out.println("Livro e autor cadastrados com sucesso!");
            } else {
                System.out.println("Erro ao inserir autor.");
            }

        } catch (SQLException e) {
            e.printStackTrace();
        }
    }

    private static int inserirAutor(Connection connection, String nomeAutor) throws SQLException {
        String sqlAutor = "INSERT INTO autores (nome_autor) VALUES (?)";
        try (PreparedStatement statementAutor = connection.prepareStatement(sqlAutor, PreparedStatement.RETURN_GENERATED_KEYS)) {
            statementAutor.setString(1, nomeAutor);

            int rowsAffectedAutor = statementAutor.executeUpdate();

            if (rowsAffectedAutor > 0) {
                try (ResultSet generatedKeys = statementAutor.getGeneratedKeys()) {
                    if (generatedKeys.next()) {
                        return generatedKeys.getInt(1);
                    }
                }
            }

            return -1;
        }
    }

    private static void inserirLivro(Connection connection, String tituloLivro, int anoPublicacao, int idAutor) throws SQLException {
        String sqlLivro = "INSERT INTO livros (titulo, ano_publicacao, id_autor) VALUES (?, ?, ?)";
        try (PreparedStatement statementLivro = connection.prepareStatement(sqlLivro)) {
            statementLivro.setString(1, tituloLivro);
            statementLivro.setInt(2, anoPublicacao);
            statementLivro.setInt(3, idAutor);

            statementLivro.executeUpdate();
        }
    }

     
    piblic static void main(String[] args) {
        //nome:Joao Carlos
        cadastrarLivroEautor("Livro A", 2022, "Autor X");
        cadastrarLivroEautor("Livro B", 2020, "Autor Y");
    }
}
