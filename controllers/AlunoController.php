<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Submissao.php';

class AlunoController {
    public function entregarAtividade() {
        session_start();
        if (!isset($_SESSION['usuario_id']) || $_SESSION['perfil'] !== 'Aluno') {
            header("Location: index.php?action=login");
            exit;
        }

        $atividade_id = $_GET['id'] ?? null;
        $mensagem_sucesso = "";
        $mensagem_erro = "";

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $atividade_id) {
            $texto_resposta = $_POST['texto_resposta'] ?? '';
            $nome_arquivo = null;

            if (isset($_FILES['arquivo_resposta']) && $_FILES['arquivo_resposta']['error'] === UPLOAD_ERR_OK) {
                $extensao = pathinfo($_FILES['arquivo_resposta']['name'], PATHINFO_EXTENSION);
                $extensoes_permitidas = ['pdf', 'doc', 'docx', 'png', 'jpg'];

                if (in_array(strtolower($extensao), $extensoes_permitidas)) {
                    $diretorio_destinatario = __DIR__ . '/../public/uploads/';
                    if (!is_dir($diretorio_destinatario)) {
                        mkdir($diretorio_destinatario, 0777, true);
                    }
                    $nome_arquivo = 'aluno_' . $_SESSION['usuario_id'] . '_ativ_' . $atividade_id . '_' . time() . '.' . $extensao;
                    move_uploaded_file($_FILES['arquivo_resposta']['tmp_name'], $diretorio_destinatario . $nome_arquivo);
                } else {
                    $mensagem_erro = "Formato de ficheiro não suportado. Envie em PDF, Word ou Imagem.";
                }
            }

            if (empty($mensagem_erro)) {
                $database = new Database();
                $db = $database->getConnection();
                $submissao = new Submissao($db);

                if ($submissao->enviarAtividade($_SESSION['usuario_id'], $atividade_id, $texto_resposta, $nome_arquivo)) {
                    $mensagem_sucesso = "Tarefa entregue com sucesso!";
                } else {
                    $mensagem_erro = "Erro ao registar a entrega da tarefa.";
                }
            }
        }

        require_once __DIR__ . '/../views/aluno/enviar_atividade.php';
    }
}