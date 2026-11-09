<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Usuario.php';

class ProfessorController {

    public function dashboard() {
        session_start();
        if (!isset($_SESSION['usuario_id']) || $_SESSION['perfil'] !== 'Professor') {
            header("Location: index.php?action=login");
            exit;
        }

        $database = new Database();
        $db = $database->getConnection();

        $query = "SELECT u.nome AS aluno_nome, a.titulo AS atividade_titulo, p.status, p.data_envio
                  FROM aluno al
                  JOIN usuario u ON al.usuario_id = u.id
                  LEFT JOIN progresso p ON al.usuario_id = p.aluno_id
                  LEFT JOIN atividade a ON p.atividade_id = a.id
                  ORDER BY p.data_envio DESC";

        $stmt = $db->prepare($query);
        $stmt->execute();
        $submissoes = $stmt->fetchAll();

        require_once __DIR__ . '/../views/professor/dashboard.php';
    }

    // Exibe a tela de formulário de cadastro (UC00 / RF01)
    public function exibirFormularioCadastro() {
        session_start();
        if (!isset($_SESSION['usuario_id']) || $_SESSION['perfil'] !== 'Professor') {
            header("Location: index.php?action=login");
            exit;
        }
        require_once __DIR__ . '/../views/professor/cadastrar_usuario.php';
    }

    // Processa a submissão do formulário de cadastro (UC00 / RF01 / RN01)
    public function cadastrarNovoUsuario() {
        session_start();
        if (!isset($_SESSION['usuario_id']) || $_SESSION['perfil'] !== 'Professor') {
            header("Location: index.php?action=login");
            exit;
        }

        $mensagem_sucesso = "";
        $mensagem_erro = "";

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome = $_POST['nome'] ?? '';
            $email = $_POST['email'] ?? '';
            $cpf = preg_replace('/[^0-9]/', '', $_POST['cpf'] ?? '');
            $senha = $_POST['senha'] ?? '';
            $data_nascimento = $_POST['data_nascimento'] ?? '';
            $perfil = $_POST['perfil'] ?? 'Aluno';

            $extra_info = [
                'matricula' => $_POST['matricula'] ?? null,
                'turma_id' => $_POST['turma_id'] ?? 1,
                'departamento' => $_POST['departamento'] ?? 'Informática'
            ];

            $database = new Database();
            $db = $database->getConnection();
            $usuarioModel = new Usuario($db);

            try {
                if ($usuarioModel->cadastrar($nome, $email, $cpf, $senha, $data_nascimento, $perfil, $extra_info)) {
                    $mensagem_sucesso = "Usuário cadastrado com sucesso!";
                }
            } catch (Exception $e) {
                // Captura erro da Trigger do MySQL caso o aluno tenha menos de 50 anos (RN01)
                $mensagem_erro = "Erro ao cadastrar: " . $e->getMessage();
            }
        }

        require_once __DIR__ . '/../views/professor/cadastrar_usuario.php';
    }
}