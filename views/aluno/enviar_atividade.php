<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entregar Tarefa - Conectando a Melhor Idade</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-size: 1.25rem; background-color: #f8f9fa; }
        .form-control { font-size: 1.2rem; padding: 12px; }
        .btn-audio { background-color: #0d6efd; color: white; font-weight: bold; }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark p-3">
    <div class="container">
        <a class="navbar-brand fs-3" href="index.php?action=dashboard">← Voltar às Tarefas</a>
    </div>
</nav>

<div class="container my-5" style="max-width: 800px;">
    <div class="alert alert-info p-4 d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h4">Instrução Falada</h2>
            <p class="mb-0">Clique no botão para ouvir como enviar a sua resposta.</p>
        </div>
        <button onclick="falarInstrucao()" class="btn btn-audio btn-lg p-3">🔊 Ouvir Instruções</button>
    </div>

    <h1 class="mb-4">Envio da Atividade</h1>

    <?php if (!empty($mensagem_sucesso)): ?>
        <div class="alert alert-success fs-4 p-4"><?= $mensagem_sucesso; ?></div>
        <a href="index.php?action=dashboard" class="btn btn-primary btn-lg mt-3">Voltar ao Painel Principal</a>
    <?php else: ?>

        <?php if (!empty($mensagem_erro)): ?>
            <div class="alert alert-danger fs-4 p-3"><?= $mensagem_erro; ?></div>
        <?php endif; ?>

        <form action="" method="POST" enctype="multipart/form-data" class="bg-white p-4 rounded shadow-sm">
            <div class="mb-4">
                <label for="texto_resposta" class="form-label fw-bold">Escreva a sua resposta (Opcional):</label>
                <textarea class="form-control" id="texto_resposta" name="texto_resposta" rows="5" placeholder="Digite aqui a sua resposta em texto..."></textarea>
            </div>

            <div class="mb-4">
                <label for="arquivo_resposta" class="form-label fw-bold">Anexar Ficheiro/Documento (PDF ou Imagem):</label>
                <input class="form-control form-control-lg" type="file" id="arquivo_resposta" name="arquivo_resposta">
            </div>

            <button type="submit" class="btn btn-success btn-lg w-100 p-3 fs-4">Confirmar e Enviar Tarefa</button>
        </form>
    <?php endif; ?>
</div>

<script>
function falarInstrucao() {
    const texto = "Nesta página você pode responder à tarefa digitando no campo de texto ou escolhendo um arquivo do seu computador. Quando terminar, clique no botão verde 'Confirmar e Enviar Tarefa'.";
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