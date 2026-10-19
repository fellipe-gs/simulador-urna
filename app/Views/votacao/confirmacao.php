<section class="card">
  <h2>Confirme seu voto</h2>
  <?php if ($tipo === 'VALIDO'): ?>
    <p><strong><?= e($candidato['nome']) ?></strong><br>
       Nº <?= e($candidato['numero']) ?> • <?= e($candidato['partido_sigla']) ?> • <?= e($candidato['cargo']) ?></p>
  <?php else: ?>
    <p><strong>VOTO EM BRANCO</strong></p>
  <?php endif; ?>
  <form method="post" action="/votar/confirmar" class="actions">
    <?= csrf() ?>
    <input type="hidden" name="tipo" value="<?= e($tipo) ?>">
    <?php if ($tipo === 'VALIDO'): ?><input type="hidden" name="candidato_id" value="<?= (int)$candidato['id'] ?>"><?php endif; ?>
    <button type="submit">CONFIRMAR</button>
    <a class="btn warn" href="/votar">CORRIGIR</a>
  </form>
</section>
