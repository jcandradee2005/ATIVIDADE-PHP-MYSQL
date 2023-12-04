import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.sql.SQLException;

public class gestaoecategorias {

    private static final String JDBC_URL = "jdbc:mysql://localhost/seu_banco_de_dados";
    private static final String JDBC_USER = "seu_usuario";
    private static final String JDBC_PASSWORD = "sua_senha";

    public static void adicionarProdutoECategoria(String nomeProduto, double preco, String nomeCategoria) {
        try (Connection connection = DriverManager.getConnection(JDBC_URL, JDBC_USER, JDBC_PASSWORD)) {

            // Inserir categoria na tabela categorias
            int idCategoria = inserirCategoria(connection, nomeCategoria);

            // Inserir produto na tabela produtos associado à categoria
            if (idCategoria > 0) {
                inserirProduto(connection, nomeProduto, preco, idCategoria);
                System.out.println("Produto e categoria adicionados com sucesso!");
            } else {
                System.out.println("Erro ao inserir categoria.");
            }

        } catch (SQLException e) {
            e.printStackTrace();
        }
    }

    private static int inserirCategoria(Connection connection, String nomeCategoria) throws SQLException {
        String sqlCategoria = "INSERT INTO categorias (nome_categoria) VALUES (?)";
        try (PreparedStatement statementCategoria = connection.prepareStatement(sqlCategoria, PreparedStatement.RETURN_GENERATED_KEYS)) {
            statementCategoria.setString(1, nomeCategoria);

            int rowsAffectedCategoria = statementCategoria.executeUpdate();

            if (rowsAffectedCategoria > 0) {
                try (var generatedKeys = statementCategoria.getGeneratedKeys()) {
                    if (generatedKeys.next()) {
                        return generatedKeys.getInt(1);
                    }
                }
            }

            return -1;
        }
    }

    private static void inserirProduto(Connection connection, String nomeProduto, double preco, int idCategoria) throws SQLException {
        String sqlProduto = "INSERT INTO produtos (nome_produto, preco, id_categoria) VALUES (?, ?, ?)";
        try (PreparedStatement statementProduto = connection.prepareStatement(sqlProduto)) {
            statementProduto.setString(1, nomeProduto);
            statementProduto.setDouble(2, preco);
            statementProduto.setInt(3, idCategoria);

            statementProduto.executeUpdate();
        }
    }
        
    public static void main(String[] args) {
        // aluno:Joao Carlos
        adicionarProdutoECategoria("Produto A", 50.0, "Eletrônicos");
        adicionarProdutoECategoria("Produto B", 30.0, "Roupas");
    }
}
