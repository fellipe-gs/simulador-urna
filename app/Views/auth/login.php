<section class="card">
  <h2>Identificação do eleitor</h2>
  <?php if (!empty($erro)): ?><div class="erro" role="alert"><?= e($erro) ?></div><?php endif; ?>
  <form method="post" action="/login">
    <?= csrf() ?>
    <label for="identificador">Identificador</label>
    <input id="identificador" name="identificador" required maxlength="50" autocomplete="off">
    <label for="senha">Senha</label>
    <input id="senha" name="senha" type="password" required autocomplete="off">
    <button type="submit">Entrar</button>
  </form>
</section>
