<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel do Professor - Conectando a Melhor Idade</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark p-3">
    <div class="container">
        <a class="navbar-brand fs-3" href="#">Painel do Professor</a>
        <div class="d-flex align-items-center">
            <span class="text-white me-3 fs-5">Prof. <?= htmlspecialchars($_SESSION['nome']); ?></span>
            <a href="index.php?action=logout" class="btn btn-outline-light">Sair</a>
        </div>
    </div>
</nav>

<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Acompanhamento de Entregas da Turma</h1>
        <div>
            <!-- Botão de Cadastro Visível no Painel -->
            <a href="index.php?action=formulario_cadastro" class="btn btn-success btn-lg me-2">+ Cadastrar Usuário</a>
            <button class="btn btn-primary btn-lg">+ Criar Nova Atividade</button>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-striped table-hover fs-5 align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Aluno</th>
                        <th>Atividade</th>
                        <th>Estado</th>
                        <th>Data do Envio</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($submissoes)): ?>
                        <tr><td colspan="5" class="text-center">Nenhuma entrega registrada até o momento.</td></tr>
                    <?php else: ?>
                        <?php foreach ($submissoes as $sub): ?>
                            <tr>
                                <td><?= htmlspecialchars($sub['aluno_nome']); ?></td>
                                <td><?= htmlspecialchars($sub['atividade_titulo'] ?? 'N/A'); ?></td>
                                <td>
                                    <?php if ($sub['status'] === 'Finalizada'): ?>
                                        <span class="badge bg-success fs-6">Finalizada</span>
                                    <?php elseif ($sub['status'] === 'Enviada / Aguardando Avaliacao'): ?>
                                        <span class="badge bg-warning text-dark fs-6">Aguardando Avaliação</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary fs-6">Pendente</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= $sub['data_envio'] ? date('d/m/Y H:i', strtotime($sub['data_envio'])) : '-'; ?></td>
                                <td><button class="btn btn-sm btn-outline-primary fs-6">Avaliar / Dar Feedback</button></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>