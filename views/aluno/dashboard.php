<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel do Aluno - Conectando a Melhor Idade</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-size: 1.25rem; background-color: #f8f9fa; color: #212529; }
        .btn-audio { background-color: #0d6efd; color: white; font-weight: bold; font-size: 1.2rem; }
        .card-atividade { border-left: 6px solid #ffc107; margin-bottom: 20px; }
        .card-concluida { border-left: 6px solid #198754; }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark p-3">
    <div class="container">
        <a class="navbar-brand fs-3" href="#">Conectando a Melhor Idade</a>
        <div class="d-flex align-items-center">
            <span class="text-white me-3 fs-5">Olá, <?= htmlspecialchars($_SESSION['nome']); ?></span>
            <a href="index.php?action=logout" class="btn btn-outline-light btn-lg">Sair</a>
        </div>
    </div>
</nav>

<div class="container my-5">
    <div class="alert alert-info p-4 d-flex justify-content-between align-items-center" role="alert">
        <div>
            <h2 class="h4">Precisa de ajuda para ler a tela?</h2>
            <p class="mb-0">Clique no botão ao lado para ouvir as instruções desta página.</p>
        </div>
        <button onclick="executarGuiaAudio()" class="btn btn-audio btn-lg p-3">🔊 Ouvir Instruções</button>
    </div>

    <h1 class="mb-4">Minhas Atividades</h1>

    <section class="mb-5">
        <h2 class="text-warning-emphasis border-bottom pb-2">Tarefas Pendentes</h2>
        <?php if (empty($atividades['pendentes'])): ?>
            <p class="fs-4 text-muted">Nenhuma atividade pendente no momento!</p>
        <?php else: ?>
            <div class="row">
                <?php foreach ($atividades['pendentes'] as $ativ): ?>
                    <div class="col-md-6">
                        <div class="card card-atividade p-3 shadow-sm">
                            <div class="card-body">
                                <h3 class="card-title h3"><?= htmlspecialchars($ativ['titulo']); ?></h3>
                                <p class="card-text fs-5"><?= htmlspecialchars($ativ['descricao']); ?></p>
                                <p class="text-danger fw-bold">Data de Entrega: <?= date('d/m/Y H:i', strtotime($ativ['data_entrega'])); ?></p>
                                <a href="index.php?action=enviar_atividade&id=<?= $ativ['id']; ?>" class="btn btn-primary btn-lg w-100">Entregar Tarefa</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </section>

    <section>
        <h2 class="text-success border-bottom pb-2">Tarefas Concluídas</h2>
        <?php if (empty($atividades['concluidas'])): ?>
            <p class="fs-4 text-muted">Você ainda não concluiu nenhuma tarefa.</p>
        <?php else: ?>
            <div class="row">
                <?php foreach ($atividades['concluidas'] as $ativ): ?>
                    <div class="col-md-6">
                        <div class="card card-atividade card-concluida p-3 shadow-sm">
                            <div class="card-body">
                                <h3 class="card-title h3"><?= htmlspecialchars($ativ['titulo']); ?></h3>
                                <span class="badge bg-success fs-6">Concluída</span>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </section>
</div>

<script>
function executarGuiaAudio() {
    const texto = "Bem-vindo ao seu painel de atividades. Aqui você pode ver suas tarefas pendentes e suas tarefas já concluídas. Para entregar uma tarefa pendente, clique no botão azul escrito 'Entregar Tarefa'.";
    if ('speechSynthesis' in window) {
        window.speechSynthesis.cancel();
        const utterance = new SpeechSynthesisUtterance(texto);
        utterance.lang = 'pt-BR';
        utterance.rate = 0.85;
        window.speechSynthesis.speak(utterance);
    }
}
</script>
</body>
</html>