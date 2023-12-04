import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;

public class funcionariosedepartamentos {

    private static final String JDBC_URL = "jdbc:mysql://localhost/seu_banco_de_dados";
    private static final String JDBC_USER = "seu_usuario";
    private static final String JDBC_PASSWORD = "sua_senha";

    public static void incluirFuncionarioEDepartamento(String nomeFuncionario, String cargoFuncionario, String nomeDepartamento) {
        try (Connection connection = DriverManager.getConnection(JDBC_URL, JDBC_USER, JDBC_PASSWORD)) {

            // Inserir departamento na tabela departamentos
            int idDepartamento = inserirDepartamento(connection, nomeDepartamento);

            // Inserir funcionário na tabela funcionarios associado ao departamento
            if (idDepartamento > 0) {
                inserirFuncionario(connection, nomeFuncionario, cargoFuncionario, idDepartamento);
                System.out.println("Funcionário e departamento incluídos com sucesso!");
            } else {
                System.out.println("Erro ao inserir departamento.");
            }

        } catch (SQLException e) {
            e.printStackTrace();
        }
    }

    private static int inserirDepartamento(Connection connection, String nomeDepartamento) throws SQLException {
        String sqlDepartamento = "INSERT INTO departamentos (nome_departamento) VALUES (?)";
        try (PreparedStatement statementDepartamento = connection.prepareStatement(sqlDepartamento, PreparedStatement.RETURN_GENERATED_KEYS)) {
            statementDepartamento.setString(1, nomeDepartamento);

            int rowsAffectedDepartamento = statementDepartamento.executeUpdate();

            if (rowsAffectedDepartamento > 0) {
                try (ResultSet generatedKeys = statementDepartamento.getGeneratedKeys()) {
                    if (generatedKeys.next()) {
                        return generatedKeys.getInt(1);
                    }
                }
            }

            return -1;
        }
    }

    private static void inserirFuncionario(Connection connection, String nomeFuncionario, String cargoFuncionario, int idDepartamento) throws SQLException {
        String sqlFuncionario = "INSERT INTO funcionarios (nome, cargo, id_departamento) VALUES (?, ?, ?)";
        try (PreparedStatement statementFuncionario = connection.prepareStatement(sqlFuncionario)) {
            statementFuncionario.setString(1, nomeFuncionario);
            statementFuncionario.setString(2, cargoFuncionario);
            statementFuncionario.setInt(3, idDepartamento);

            statementFuncionario.executeUpdate();
        }
    }

    public static void main(String[] args) {
        //nome:Joao Carlos
        incluirFuncionarioEDepartamento("Funcionario A", "Analista", "Departamento X");
        incluirFuncionarioEDepartamento("Funcionario B", "Gerente", "Departamento Y");
    }
}

