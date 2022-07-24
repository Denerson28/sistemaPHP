<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="#">
    <link href="<?= URL_CSS ?>bootstrap.min.css" rel="stylesheet">
    <link href="<?= URL_CSS ?>login.css" rel="stylesheet">
    <link href="<?= URL_JS ?>sweetalert2/sweetalert2.css" rel="stylesheet">
    <link href="<?= FONTAWESOME ?>" rel="stylesheet">
    <title>CompraVenda</title>
</head>

<?php
if (isset($data['mensagens'])) { ?>
  <div class="col-6">
    <div class="alert alert-danger" role="alert">
      <?php

      foreach ($data['mensagens'] as $mensagem) {
        echo $mensagem . "<br>";
      }

      ?>
    </div>
  </div>
<?php
}
?>
<form action="<?= URL_BASE . '/logar' ?>" method="post">
  <div class="col-6">
    
    <div class="form-group">
      <label for="cpf">CPF</label>
      <input id="cpf" class="form-control" type="cpf" name="cpf" value="" placeholder="Digite aqui seu CPF">
    </div>
    <div class="form-group">
      <label for="senha">Senha</label>
      <input id="senha" class="form-control" type="password" name="senha" value="" placeholder="Digite aqui sua senha">
    </div>

    <div class="form-group">
    <button type="submit" class="btn btn-primary">Logar</button>
    </div>

  </div>
</form>