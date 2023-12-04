import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;

public class usuariospedidos {

    private static final String JDBC_URL = "jdbc:mysql://localhost/seu_banco_de_dados";
    private static final String JDBC_USER = "seu_usuario";
    private static final String JDBC_PASSWORD = "sua_senha";

    public static void cadastrarUsuarioEPedido(String nome, String email, String produto, int quantidade) {
        try (Connection connection = DriverManager.getConnection(JDBC_URL, JDBC_USER, JDBC_PASSWORD)) {

            String sqlUsuario = "INSERT INTO usuarios (nome, email) VALUES (?, ?)";
            try (PreparedStatement statementUsuario = connection.prepareStatement(sqlUsuario, PreparedStatement.RETURN_GENERATED_KEYS)) {
                statementUsuario.setString(1, nome);
                statementUsuario.setString(2, email);

                int rowsAffectedUsuario = statementUsuario.executeUpdate();

                if (rowsAffectedUsuario > 0) {

                    try (ResultSet generatedKeys = statementUsuario.getGeneratedKeys()) {
                        if (generatedKeys.next()) {
                            int idUsuario = generatedKeys.getInt(1);

                            String sqlPedido = "INSERT INTO pedidos (id_usuario, produto, quantidade) VALUES (?, ?, ?)";
                            try (PreparedStatement statementPedido = connection.prepareStatement(sqlPedido)) {

                                statementPedido.setInt(1, idUsuario);
                                statementPedido.setString(2, produto);
                                statementPedido.setInt(3, quantidade);

                                int rowsAffectedPedido = statementPedido.executeUpdate();

                                if (rowsAffectedPedido > 0) {
                                    System.out.println("Usuário e pedido registrados com sucesso!");
                                } else {
                                    System.out.println("Erro ao inserir pedido.");
                                }
                            }
                        }
                    }
                } else {
                    System.out.println("Erro ao inserir usuário.");
                }
            }
        } catch (SQLException e) {
            e.printStackTrace();
        }
    }

    public static void main(String[] args) {
        // aluno: Joao Carlos
        cadastrarUsuarioEPedido("Joao Carlos", "jcgalo@gmail.com", "Produto A", 2);
    }
}
