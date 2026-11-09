<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Conectando a Melhor Idade</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-size: 1.25rem; background-color: #f8f9fa; }
        .form-control { font-size: 1.2rem; padding: 12px; }
        .card-login { max-width: 500px; margin: 80px auto; }
    </style>
</head>
<body>
<div class="container">
    <div class="card card-login shadow-sm p-4 rounded">
        <h1 class="text-center mb-4 text-primary">Conectando a Melhor Idade</h1>
        <h2 class="text-center h4 mb-4">Entrar na Plataforma</h2>

        <?php if (!empty($erro)): ?>
            <div class="alert alert-danger fs-5"><?= $erro; ?></div>
        <?php endif; ?>

        <form action="" method="POST">
            <div class="mb-4">
                <label for="cpf" class="form-label fw-bold">Digite seu CPF:</label>
                <input type="text" class="form-control" id="cpf" name="cpf" placeholder="000.000.000-00" required>
            </div>
            <div class="mb-4">
                <label for="senha" class="form-label fw-bold">Digite sua Senha:</label>
                <input type="password" class="form-control" id="senha" name="senha" placeholder="Sua senha de acesso" required>
            </div>
            <button type="submit" class="btn btn-primary btn-lg w-100 p-3 fs-4 mb-3">Entrar</button>
        </form>

        
    </div>
</div>
</body>
</html>