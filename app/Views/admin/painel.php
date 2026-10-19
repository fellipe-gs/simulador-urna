<section class="card">
  <h2>Eleição: <?= e($eleicao['nome']) ?> — <?= e($eleicao['status']) ?></h2>
  <?php if (!empty($erro)): ?><div class="erro" role="alert"><?= e($erro) ?></div><?php endif; ?>
  <div class="actions">
    <form method="post" action="/admin/eleicao/iniciar"><?= csrf() ?><button type="submit">Iniciar</button></form>
    <form method="post" action="/admin/eleicao/encerrar"><?= csrf() ?><button class="danger" type="submit">Encerrar</button></form>
    <a class="btn sec" href="/apuracao">Apuração</a>
    <form method="post" action="/admin/logout"><?= csrf() ?><button class="sec" type="submit">Sair</button></form>
  </div>
</section>

<section class="card">
  <h2>Partidos (fictícios)</h2>
  <table><tr><th>Sigla</th><th>Nome</th><th>Nº</th><th></th></tr>
  <?php foreach ($partidos as $p): ?>
    <tr><td><?= e($p['sigla']) ?></td><td><?= e($p['nome']) ?></td><td><?= (int)$p['numero'] ?></td>
    <td><form method="post" action="/admin/partidos/excluir"><?= csrf() ?><input type="hidden" name="id" value="<?= (int)$p['id'] ?>"><button class="danger" type="submit">Excluir</button></form></td></tr>
  <?php endforeach; ?></table>
  <form method="post" action="/admin/partidos">
    <?= csrf() ?>
    <label for="pn">Nome</label><input id="pn" name="nome" required>
    <label for="ps">Sigla</label><input id="ps" name="sigla" required maxlength="10">
    <label for="pnum">Número (10–99)</label><input id="pnum" name="numero" type="number" min="10" max="99" required>
    <button type="submit">Cadastrar partido</button>
  </form>
</section>

<section class="card">
  <h2>Candidatos (fictícios)</h2>
  <table><tr><th>Nº</th><th>Nome</th><th>Partido</th><th></th></tr>
  <?php foreach ($candidatos as $c): ?>
    <tr><td><?= e($c['numero']) ?></td><td><?= e($c['nome']) ?></td><td><?= e($c['partido_sigla']) ?></td>
    <td><form method="post" action="/admin/candidatos/excluir"><?= csrf() ?><input type="hidden" name="id" value="<?= (int)$c['id'] ?>"><button class="danger" type="submit">Excluir</button></form></td></tr>
  <?php endforeach; ?></table>
  <form method="post" action="/admin/candidatos">
    <?= csrf() ?>
    <label for="cn">Nome</label><input id="cn" name="nome" required>
    <label for="cnum">Número</label><input id="cnum" name="numero" inputmode="numeric" required maxlength="5">
    <label for="cc">Cargo</label><input id="cc" name="cargo" required value="Presidente Fictício">
    <label for="cp">Partido</label>
    <select id="cp" name="partido_id" required><?php foreach ($partidos as $p): ?><option value="<?= (int)$p['id'] ?>"><?= e($p['sigla']) ?></option><?php endforeach; ?></select>
    <button type="submit">Cadastrar candidato</button>
  </form>
</section>
