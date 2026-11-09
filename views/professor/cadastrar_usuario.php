<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Usuário - Conectando a Melhor Idade</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-size: 1.2rem; background-color: #f8f9fa; }
        .form-control, .form-select { font-size: 1.1rem; padding: 10px; }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark p-3">
    <div class="container">
        <a class="navbar-brand fs-3" href="index.php?action=professor_dashboard">← Voltar ao Painel</a>
    </div>
</nav>

<div class="container my-5" style="max-width: 700px;">
    <h1 class="mb-4">Cadastrar Novo Usuário</h1>

    <?php if (!empty($mensagem_sucesso)): ?>
        <div class="alert alert-success fs-4 p-4"><?= $mensagem_sucesso; ?></div>
        <a href="index.php?action=professor_dashboard" class="btn btn-primary btn-lg mt-2">Voltar ao Painel</a>
    <?php else: ?>

        <?php if (!empty($mensagem_erro)): ?>
            <div class="alert alert-danger fs-5 p-3"><?= $mensagem_erro; ?></div>
        <?php endif; ?>

        <form action="index.php?action=cadastrar_usuario" method="POST" class="bg-white p-4 rounded shadow-sm">
            <div class="mb-3">
                <label for="nome" class="form-label fw-bold">Nome Completo:</label>
                <input type="text" class="form-control" id="nome" name="nome" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label fw-bold">E-mail:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="cpf" class="form-label fw-bold">CPF:</label>
                    <input type="text" class="form-control" id="cpf" name="cpf" placeholder="000.000.000-00" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="senha" class="form-label fw-bold">Senha de Acesso:</label>
                    <input type="password" class="form-control" id="senha" name="senha" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="data_nascimento" class="form-label fw-bold">Data de Nascimento:</label>
                    <input type="date" class="form-control" id="data_nascimento" name="data_nascimento" required>
                    <small class="text-muted">Para alunos: idade mínima de 50 anos (RN01).</small>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="perfil" class="form-label fw-bold">Perfil do Usuário:</label>
                    <select class="form-select" id="perfil" name="perfil" onchange="alternarCamposPerfil()" required>
                        <option value="Aluno">Aluno (Idoso)</option>
                        <option value="Professor">Professor</option>
                    </select>
                </div>
            </div>

            <!-- Campos Específicos para Alunos -->
            <div id="campos_aluno">
                <div class="mb-3">
                    <label for="matricula" class="form-label fw-bold">Matrícula do Aluno:</label>
                    <input type="text" class="form-control" id="matricula" name="matricula" placeholder="Ex: 2026001">
                </div>
                <input type="hidden" name="turma_id" value="1">
            </div>

            <!-- Campos Específicos para Professores -->
            <div id="campos_professor" style="display: none;">
                <div class="mb-3">
                    <label for="departamento" class="form-label fw-bold">Departamento:</label>
                    <input type="text" class="form-control" id="departamento" name="departamento" placeholder="Ex: Informática">
                </div>
            </div>

            <button type="submit" class="btn btn-success btn-lg w-100 p-3 fs-4 mt-3">Cadastrar Usuário</button>
        </form>
    <?php endif; ?>
</div>

<script>
function alternarCamposPerfil() {
    const perfil = document.getElementById('perfil').value;
    const camposAluno = document.getElementById('campos_aluno');
    const camposProfessor = document.getElementById('campos_professor');

    if (perfil === 'Aluno') {
        camposAluno.style.display = 'block';
        camposProfessor.style.display = 'none';
    } else {
        camposAluno.style.display = 'none';
        camposProfessor.style.display = 'block';
    }
}
</script>
</body>
</html>