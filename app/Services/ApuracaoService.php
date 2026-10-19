<?php
namespace App\Services;

use App\Models\Voto;

class ApuracaoService
{
    /** Cálculo puro (testável sem banco): totais e percentuais sobre o total de votos. */
    public static function calcular(int $validos, int $brancos, int $nulos): array
    {
        $total = $validos + $brancos + $nulos;
        $pct = fn(int $n) => $total > 0 ? round($n * 100 / $total, 2) : 0.0;
        return [
            'total'       => $total,
            'validos'     => $validos,
            'brancos'     => $brancos,
            'nulos'       => $nulos,
            'pct_validos' => $pct($validos),
            'pct_brancos' => $pct($brancos),
            'pct_nulos'   => $pct($nulos),
        ];
    }

    public function resultado(int $eleicaoId): array
    {
        $tipos  = Voto::totaisPorTipo($eleicaoId);
        $resumo = self::calcular((int)($tipos['VALIDO'] ?? 0), (int)($tipos['BRANCO'] ?? 0), (int)($tipos['NULO'] ?? 0));
        return ['resumo' => $resumo, 'candidatos' => Voto::porCandidato($eleicaoId)];
    }
}
