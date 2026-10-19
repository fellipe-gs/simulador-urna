<section class="card">
  <h2>Digite o número do candidato</h2>
  <?php if (!empty($erro)): ?><div class="erro" role="alert"><?= e($erro) ?></div><?php endif; ?>
  <form method="post" action="/votar/numero">
    <?= csrf() ?>
    <label for="numero">Número</label>
    <input id="numero" class="num" name="numero" inputmode="numeric" pattern="[0-9]{1,5}" maxlength="5" required autofocus>
    <div class="actions"><button type="submit">Buscar candidato</button></div>
  </form>
  <form method="post" action="/votar/branco">
    <?= csrf() ?>
    <button class="sec" type="submit">Voto em branco</button>
  </form>
</section>
