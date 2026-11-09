<?php
// Ponto de Entrada (Front Controller)
$action = $_GET['action'] ?? 'login';

switch ($action) {
    case 'login':
        require_once __DIR__ . '/controllers/AuthController.php';
        $controller = new AuthController();
        $controller->login();
        break;

    case 'formulario_cadastro':
    case 'cadastrar_usuario':
        require_once __DIR__ . '/controllers/ProfessorController.php';
        $controller = new ProfessorController();
        if ($action === 'cadastrar_usuario') {
            $controller->cadastrarNovoUsuario();
        } else {
            $controller->exibirFormularioCadastro();
        }
        break;

    case 'dashboard':
        session_start();
        if (!isset($_SESSION['usuario_id']) || $_SESSION['perfil'] !== 'Aluno') {
            header("Location: index.php?action=login");
            exit;
        }
        require_once __DIR__ . '/config/database.php';
        require_once __DIR__ . '/models/Atividade.php';

        $database = new Database();
        $db = $database->getConnection();
        $atividadeModel = new Atividade($db);

        $atividades = $atividadeModel->listarPorAluno($_SESSION['usuario_id']);
        require_once __DIR__ . '/views/aluno/dashboard.php';
        break;

    case 'enviar_atividade':
        require_once __DIR__ . '/controllers/AlunoController.php';
        $controller = new AlunoController();
        $controller->entregarAtividade();
        break;

    case 'professor_dashboard':
        require_once __DIR__ . '/controllers/ProfessorController.php';
        $controller = new ProfessorController();
        $controller->dashboard();
        break;

    case 'logout':
        require_once __DIR__ . '/controllers/AuthController.php';
        $controller = new AuthController();
        $controller->logout();
        break;

    default:
        echo "Página não encontrada!";
        break;
}