import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Date;

public class gestaoresultadosexamespacientes {

    private static final String JDBC_URL = "jdbc:mysql://localhost/seu_banco_de_dados";
    private static final String JDBC_USER = "seu_usuario";
    private static final String JDBC_PASSWORD = "sua_senha";

    public static void inserirResultadoExameEPaciente(String tipoExame, String resultadoExame, String nomePaciente, Date dataNascimento) {
        try (Connection connection = DriverManager.getConnection(JDBC_URL, JDBC_USER, JDBC_PASSWORD)) {

            // Inserir paciente na tabela pacientes
            int idPaciente = inserirPaciente(connection, nomePaciente, dataNascimento);

            // Inserir resultado de exame na tabela resultados_exames associado ao paciente
            if (idPaciente > 0) {
                inserirResultadoExame(connection, tipoExame, resultadoExame, idPaciente);
                System.out.println("Resultado de exame e paciente registrados com sucesso!");
            } else {
                System.out.println("Erro ao inserir paciente.");
            }

        } catch (SQLException e) {
            e.printStackTrace();
        }
    }

    private static int inserirPaciente(Connection connection, String nomePaciente, Date dataNascimento) throws SQLException {
        String sqlPaciente = "INSERT INTO pacientes (nome_paciente, data_nascimento) VALUES (?, ?)";
        try (PreparedStatement statementPaciente = connection.prepareStatement(sqlPaciente, PreparedStatement.RETURN_GENERATED_KEYS)) {
            statementPaciente.setString(1, nomePaciente);
            statementPaciente.setDate(2, dataNascimento);

            int rowsAffectedPaciente = statementPaciente.executeUpdate();

            if (rowsAffectedPaciente > 0) {
                try (ResultSet generatedKeys = statementPaciente.getGeneratedKeys()) {
                    if (generatedKeys.next()) {
                        return generatedKeys.getInt(1);
                    }
                }
            }

            return -1;
        }
    }

    private static void inserirResultadoExame(Connection connection, String tipoExame, String resultadoExame, int idPaciente) throws SQLException {
        String sqlResultadoExame = "INSERT INTO resultados_exames (tipo_exame, resultado, id_paciente) VALUES (?, ?, ?)";
        try (PreparedStatement statementResultadoExame = connection.prepareStatement(sqlResultadoExame)) {
            statementResultadoExame.setString(1, tipoExame);
            statementResultadoExame.setString(2, resultadoExame);
            statementResultadoExame.setInt(3, idPaciente);

            statementResultadoExame.executeUpdate();
        }
    }

    public static void main(String[] args) {
        //nome:Joao Carlos
        inserirResultadoExameEPaciente("Hematologia", "Normal", "Paciente A", Date.valueOf("1990-01-01"));
        inserirResultadoExameEPaciente("Bioquímico", "Elevado", "Paciente B", Date.valueOf("1985-05-15"));
    }
}
