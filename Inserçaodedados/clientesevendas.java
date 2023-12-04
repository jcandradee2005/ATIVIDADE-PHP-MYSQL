import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;

public class clientesevendas {

    private static final String JDBC_URL = "jdbc:mysql://localhost/seu_banco_de_dados";
    private static final String JDBC_USER = "seu_usuario";
    private static final String JDBC_PASSWORD = "sua_senha";

    public static void registrarClienteEVenda(String nomeCliente, String emailCliente, String produtoVendido, double valorVenda) {
        try (Connection connection = DriverManager.getConnection(JDBC_URL, JDBC_USER, JDBC_PASSWORD)) {

            // Inserir cliente na tabela clientes
            int idCliente = inserirCliente(connection, nomeCliente, emailCliente);

            // Inserir venda na tabela vendas associada ao cliente
            if (idCliente > 0) {
                inserirVenda(connection, idCliente, produtoVendido, valorVenda);
                System.out.println("Cliente e venda registrados com sucesso!");
            } else {
                System.out.println("Erro ao inserir cliente.");
            }

        } catch (SQLException e) {
            e.printStackTrace();
        }
    }

    private static int inserirCliente(Connection connection, String nomeCliente, String emailCliente) throws SQLException {
        String sqlCliente = "INSERT INTO clientes (nome, email) VALUES (?, ?)";
        try (PreparedStatement statementCliente = connection.prepareStatement(sqlCliente, PreparedStatement.RETURN_GENERATED_KEYS)) {
            statementCliente.setString(1, nomeCliente);
            statementCliente.setString(2, emailCliente);

            int rowsAffectedCliente = statementCliente.executeUpdate();

            if (rowsAffectedCliente > 0) {
                try (ResultSet generatedKeys = statementCliente.getGeneratedKeys()) {
                    if (generatedKeys.next()) {
                        return generatedKeys.getInt(1);
                    }
                }
            }

            return -1;
        }
    }

    private static void inserirVenda(Connection connection, int idCliente, String produtoVendido, double valorVenda) throws SQLException {
        String sqlVenda = "INSERT INTO vendas (id_cliente, produto_vendido, valor) VALUES (?, ?, ?)";
        try (PreparedStatement statementVenda = connection.prepareStatement(sqlVenda)) {
            statementVenda.setInt(1, idCliente);
            statementVenda.setString(2, produtoVendido);
            statementVenda.setDouble(3, valorVenda);

            statementVenda.executeUpdate();
        }
    }

    public static void main(String[] args) {
        //nome:Joao Carlos
        registrarClienteEVenda("Cliente A", "clienteA@example.com", "Produto X", 100.0);
        registrarClienteEVenda("Cliente B", "clienteB@example.com", "Produto Y", 150.0);
    }
}
