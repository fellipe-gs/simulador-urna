<section class="card">
  <h2>Número inválido</h2>
  <div class="erro" role="alert">Candidato não encontrado para o número "<?= e($numero) ?>". Se confirmar, o voto será NULO.</div>
  <form method="post" action="/votar/confirmar" class="actions">
    <?= csrf() ?>
    <input type="hidden" name="tipo" value="NULO">
    <button class="danger" type="submit">CONFIRMAR NULO</button>
    <a class="btn warn" href="/votar">CORRIGIR</a>
  </form>
</section>
