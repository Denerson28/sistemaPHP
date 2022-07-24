<head>
    <link href="<?= URL_CSS ?>login.css" rel="stylesheet">
    <link href="<?= URL_CSS ?>dashboard.css" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<h1>Dashboard Comprador</h1>
<?php
if (isset($_SESSION['id']) && isset($_SESSION['nomeFuncionario'])) : ?>

    <div class="alert alert-success" role="alert">
        <h5>Comprador logado com sucesso</h5>
    </div>
    <div class="row" id="space">
        <div class="card mt-3 border-0" id ="tamanhobox">
            <div class="card-body px-2">
                <i class="fas fa-user"></i> <strong>Nome</strong>
                <p class="text-muted"><?= htmlentities(utf8_encode($_SESSION['nomeFuncionario'])) ?></p>
                <i class="fas fa-at"></i><strong> CPF</strong>
                <p class="text-muted"><?= htmlentities(utf8_encode($_SESSION['cpfFuncionario'])) ?></p>

            </div>
        </div>
    </div>
<?php endif; ?>