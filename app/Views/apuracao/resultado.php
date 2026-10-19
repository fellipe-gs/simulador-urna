<section class="card">
  <h2>Apuração – <?= e($eleicao['nome']) ?> (<?= e($eleicao['status']) ?>)</h2>
  <table>
    <tr><th>Candidato</th><th>Nº</th><th>Partido</th><th>Votos</th></tr>
    <?php foreach ($candidatos as $c): ?>
      <tr><td><?= e($c['nome']) ?></td><td><?= e($c['numero']) ?></td><td><?= e($c['partido_sigla']) ?></td><td><?= (int)$c['total'] ?></td></tr>
    <?php endforeach; ?>
  </table>
  <p>Válidos: <?= $resumo['validos'] ?> (<?= $resumo['pct_validos'] ?>%) •
     Brancos: <?= $resumo['brancos'] ?> (<?= $resumo['pct_brancos'] ?>%) •
     Nulos: <?= $resumo['nulos'] ?> (<?= $resumo['pct_nulos'] ?>%) •
     Total: <?= $resumo['total'] ?></p>
  <a class="btn sec" href="/admin">Voltar ao painel</a>
</section>
