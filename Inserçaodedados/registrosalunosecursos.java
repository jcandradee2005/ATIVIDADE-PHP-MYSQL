import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;

public class registroalunoscursos {

    private static final String JDBC_URL = "jdbc:mysql://localhost/seu_banco_de_dados";
    private static final String JDBC_USER = "seu_usuario";
    private static final String JDBC_PASSWORD = "sua_senha";

    public static void registrarAlunoECurso(String nomeAluno, String turmaAluno, String nomeCurso, String instrutorCurso) {
        try (Connection connection = DriverManager.getConnection(JDBC_URL, JDBC_USER, JDBC_PASSWORD)) {

            // Inserir aluno na tabela alunos
            int idAluno = inserirAluno(connection, nomeAluno, turmaAluno);

            // Inserir curso na tabela cursos
            if (idAluno > 0) {
                inserirCurso(connection, nomeCurso, instrutorCurso, idAluno);
                System.out.println("Aluno e curso registrados com sucesso!");
            } else {
                System.out.println("Erro ao inserir aluno.");
            }

        } catch (SQLException e) {
            e.printStackTrace();
        }
    }

    private static int inserirAluno(Connection connection, String nomeAluno, String turmaAluno) throws SQLException {
        String sqlAluno = "INSERT INTO alunos (nome, turma) VALUES (?, ?)";
        try (PreparedStatement statementAluno = connection.prepareStatement(sqlAluno, PreparedStatement.RETURN_GENERATED_KEYS)) {
            statementAluno.setString(1, nomeAluno);
            statementAluno.setString(2, turmaAluno);

            int rowsAffectedAluno = statementAluno.executeUpdate();

            if (rowsAffectedAluno > 0) {
                try (ResultSet generatedKeys = statementAluno.getGeneratedKeys()) {
                    if (generatedKeys.next()) {
                        return generatedKeys.getInt(1);
                    }
                }
            }

            return -1;
        }
    }

    private static void inserirCurso(Connection connection, String nomeCurso, String instrutorCurso, int idAluno) throws SQLException {
        String sqlCurso = "INSERT INTO cursos (nome_curso, instrutor, id_aluno) VALUES (?, ?, ?)";
        try (PreparedStatement statementCurso = connection.prepareStatement(sqlCurso)) {
            statementCurso.setString(1, nomeCurso);
            statementCurso.setString(2, instrutorCurso);
            statementCurso.setInt(3, idAluno);

            statementCurso.executeUpdate();
        }
    }

    public static void main(String[] args) {
        //aluno:Joao carlos
        registrarAlunoECurso("Aluno A", "Turma 1", "Curso de Matemática", "Prof. Silva");
        registrarAlunoECurso("Aluno B", "Turma 2", "Curso de História", "Prof. Souza");
    }
}
