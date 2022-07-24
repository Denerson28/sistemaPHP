<head>
    <link href="<?= URL_CSS ?>login.css" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
<div class="space"></div>
<div class="container"></div>
<div class="row mb-3 mt-5" >
  <div class="col-4 offset-4 card bg-ligth">
    <form action="<?= URL_BASE . '/logar' ?>" method="post" class="needs-validation">
    <h1>Login</h1> 
      <div class="col-6">
        
        <p>
          <label for="cpf">CPF</label>
          <input id="cpf" class="form-control" type="cpf" name="cpf" value="" placeholder="Digite aqui seu CPF">
        </p>
        <p
          <label for="senha">Senha</label>
          <input id="senha" class="form-control" type="password" name="senha" value="" placeholder="Digite aqui sua senha">
        </p>

        <p>
        <button type="submit" class="btn btn-primary">Logar</button>
        </p>
      </div>
    </form>
  </div>
</div>