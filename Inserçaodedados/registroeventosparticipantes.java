import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;

public class registroEventosparticipantes {

    private static final String JDBC_URL = "jdbc:mysql://localhost/seu_banco_de_dados";
    private static final String JDBC_USER = "seu_usuario";
    private static final String JDBC_PASSWORD = "sua_senha";

    public static void registrarEventoEParticipante(String nomeEvento, String dataEvento, String nomeParticipante) {
        try (Connection connection = DriverManager.getConnection(JDBC_URL, JDBC_USER, JDBC_PASSWORD)) {

            // Inserir evento na tabela eventos
            int idEvento = inserirEvento(connection, nomeEvento, dataEvento);

            // Inserir participante na tabela participantes associado ao evento
            if (idEvento > 0) {
                inserirParticipante(connection, idEvento, nomeParticipante);
                System.out.println("Evento e participante registrados com sucesso!");
            } else {
                System.out.println("Erro ao inserir evento.");
            }

        } catch (SQLException e) {
            e.printStackTrace();
        }
    }

    private static int inserirEvento(Connection connection, String nomeEvento, String dataEvento) throws SQLException {
        String sqlEvento = "INSERT INTO eventos (nome_evento, data) VALUES (?, ?)";
        try (PreparedStatement statementEvento = connection.prepareStatement(sqlEvento, PreparedStatement.RETURN_GENERATED_KEYS)) {
            statementEvento.setString(1, nomeEvento);
            statementEvento.setString(2, dataEvento);

            int rowsAffectedEvento = statementEvento.executeUpdate();

            if (rowsAffectedEvento > 0) {
                try (ResultSet generatedKeys = statementEvento.getGeneratedKeys()) {
                    if (generatedKeys.next()) {
                        return generatedKeys.getInt(1);
                    }
                }
            }

            return -1;
        }
    }

    private static void inserirParticipante(Connection connection, int idEvento, String nomeParticipante) throws SQLException {
        String sqlParticipante = "INSERT INTO participantes (id_evento, nome_participante) VALUES (?, ?)";
        try (PreparedStatement statementParticipante = connection.prepareStatement(sqlParticipante)) {
            statementParticipante.setInt(1, idEvento);
            statementParticipante.setString(2, nomeParticipante);

            statementParticipante.executeUpdate();
        }
    }

    public static void main(String[] args) {
        //nome:Joao Carlos
        registrarEventoEParticipante("Evento A", "2023-01-01", "Participante X");
        registrarEventoEParticipante("Evento B", "2023-02-01", "Participante Y");
    }
}
