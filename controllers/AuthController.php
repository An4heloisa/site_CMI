<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Usuario.php';

class AuthController {
    public function login() {
        session_start();
        $erro = "";

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $database = new Database();
            $db = $database->getConnection();
            $usuarioModel = new Usuario($db);

            $cpf = preg_replace('/[^0-9]/', '', $_POST['cpf'] ?? '');
            $senha = $_POST['senha'] ?? '';

            $usuario = $usuarioModel->autenticar($cpf, $senha);

            if ($usuario) {
                $_SESSION['usuario_id'] = $usuario['id'];
                $_SESSION['nome'] = $usuario['nome'];
                $_SESSION['perfil'] = $usuario['perfil'];

                if ($usuario['perfil'] === 'Aluno') {
                    header("Location: index.php?action=dashboard");
                } else {
                    header("Location: index.php?action=professor_dashboard");
                }
                exit;
            } else {
                $erro = "CPF ou senha inválidos. Tente novamente.";
            }
        }

        require_once __DIR__ . '/../views/auth/login.php';
    }

    public function logout() {
        session_start();
        session_destroy();
        header("Location: index.php?action=login");
        exit;
    }
}