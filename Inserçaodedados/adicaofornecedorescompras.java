import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;

public class adicaofornecedorescompras {

    private static final String JDBC_URL = "jdbc:mysql://localhost/seu_banco_de_dados";
    private static final String JDBC_USER = "seu_usuario";
    private static final String JDBC_PASSWORD = "sua_senha";

    public static void adicionarFornecedorECompra(String nomeFornecedor, String contatoFornecedor, String produtoComprado, int quantidade) {
        try (Connection connection = DriverManager.getConnection(JDBC_URL, JDBC_USER, JDBC_PASSWORD)) {

            // Inserir fornecedor na tabela fornecedores
            int idFornecedor = inserirFornecedor(connection, nomeFornecedor, contatoFornecedor);

            // Inserir compra na tabela compras associada ao fornecedor
            if (idFornecedor > 0) {
                inserirCompra(connection, idFornecedor, produtoComprado, quantidade);
                System.out.println("Fornecedor e compra registrados com sucesso!");
            } else {
                System.out.println("Erro ao inserir fornecedor.");
            }

        } catch (SQLException e) {
            e.printStackTrace();
        }
    }

    private static int inserirFornecedor(Connection connection, String nomeFornecedor, String contatoFornecedor) throws SQLException {
        String sqlFornecedor = "INSERT INTO fornecedores (nome, contato) VALUES (?, ?)";
        try (PreparedStatement statementFornecedor = connection.prepareStatement(sqlFornecedor, PreparedStatement.RETURN_GENERATED_KEYS)) {
            statementFornecedor.setString(1, nomeFornecedor);
            statementFornecedor.setString(2, contatoFornecedor);

            int rowsAffectedFornecedor = statementFornecedor.executeUpdate();

            if (rowsAffectedFornecedor > 0) {
                try (ResultSet generatedKeys = statementFornecedor.getGeneratedKeys()) {
                    if (generatedKeys.next()) {
                        return generatedKeys.getInt(1);
                    }
                }
            }

            return -1;
        }
    }

    private static void inserirCompra(Connection connection, int idFornecedor, String produtoComprado, int quantidade) throws SQLException {
        String sqlCompra = "INSERT INTO compras (id_fornecedor, produto_comprado, quantidade) VALUES (?, ?, ?)";
        try (PreparedStatement statementCompra = connection.prepareStatement(sqlCompra)) {
            statementCompra.setInt(1, idFornecedor);
            statementCompra.setString(2, produtoComprado);
            statementCompra.setInt(3, quantidade);

            statementCompra.executeUpdate();
        }
    }

    public static void main(String[] args) {
        //nome:Joao Carlos
        adicionarFornecedorECompra("Fornecedor A", "contato1@example.com", "Produto X", 100);
        adicionarFornecedorECompra("Fornecedor B", "contato2@example.com", "Produto Y", 150);
    }
}
