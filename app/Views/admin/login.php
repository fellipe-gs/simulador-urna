<section class="card">
  <h2>Administração</h2>
  <?php if (!empty($erro)): ?><div class="erro" role="alert"><?= e($erro) ?></div><?php endif; ?>
  <form method="post" action="/admin/login">
    <?= csrf() ?>
    <label for="email">E-mail</label><input id="email" name="email" type="email" required>
    <label for="senha">Senha</label><input id="senha" name="senha" type="password" required>
    <button type="submit">Entrar</button>
  </form>
</section>
