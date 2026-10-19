<?php
// Testes sem dependências: php tests/run.php
require __DIR__ . '/../app/Services/ApuracaoService.php';
use App\Services\ApuracaoService;

$falhas = 0;
function check(string $nome, bool $ok): void {
    global $falhas;
    echo ($ok ? '[OK]   ' : '[FALHA] ') . $nome . PHP_EOL;
    if (!$ok) $falhas++;
}

// CT12 – Apuração: totais e percentuais
$r = ApuracaoService::calcular(6, 2, 2);
check('CT12 total = 10', $r['total'] === 10);
check('CT12 válidos 60%', $r['pct_validos'] === 60.0);
check('CT12 brancos 20%', $r['pct_brancos'] === 20.0);
check('CT12 nulos 20%', $r['pct_nulos'] === 20.0);

// Sem votos: não divide por zero
$z = ApuracaoService::calcular(0, 0, 0);
check('Apuração sem votos retorna 0%', $z['total'] === 0 && $z['pct_validos'] === 0.0);

// Hash de senha (RNF06)
$h = password_hash('eleitor123', PASSWORD_DEFAULT);
check('password_verify aceita senha correta', password_verify('eleitor123', $h));
check('password_verify recusa senha incorreta', !password_verify('errada', $h));

// Hash do seed corresponde a eleitor123 / admin123
check('Seed: hash do eleitor válido', password_verify('eleitor123', '$2y$10$w6vsBYCentnZJDTBv3NY5.0rbjKzkeja5Yzg1O5MAz2POd3nn/OM6'));
check('Seed: hash do admin válido', password_verify('admin123', '$2y$10$HsnQFdObOh6f3pl80h8B2OTIpY3bmjuVk2gwh3CpuYbft/mJuM2Y6'));

exit($falhas ? 1 : 0);
