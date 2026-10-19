<?php
namespace App\Services;

use App\Core\Database;
use App\Core\RegraNegocioException;
use App\Models\{Candidato, Eleicao, Eleitor, Voto};

class VotacaoService
{
    /**
     * Registra o voto aplicando as regras RB01, RB03-RB07, RB09, RB11, RB13.
     * Tudo em transação; a linha do eleitor é travada (FOR UPDATE).
     */
    public function registrar(int $eleitorId, int $eleicaoId, string $tipo, ?int $candidatoId): void
    {
        if (!in_array($tipo, ['VALIDO', 'BRANCO', 'NULO'], true)) {
            throw new RegraNegocioException('Tipo de voto inválido.');
        }

        $pdo = Database::pdo();
        $pdo->beginTransaction();
        try {
            $eleitor = Eleitor::travar($eleitorId);
            $eleicao = Eleicao::buscar($eleicaoId);

            if (!$eleitor || (int)$eleitor['eleicao_id'] !== $eleicaoId) throw new RegraNegocioException('Eleitor não habilitado.');
            if ($eleitor['status'] !== 'ATIVO')                          throw new RegraNegocioException('Eleitor bloqueado.');
            if ((int)$eleitor['votou'] === 1)                            throw new RegraNegocioException('Este eleitor já votou.');
            if (!$eleicao || $eleicao['status'] !== 'EM_ANDAMENTO')      throw new RegraNegocioException('A eleição não está em andamento.');

            if ($tipo === 'VALIDO') {
                $ids = array_map('intval', array_column(Candidato::daEleicao($eleicaoId), 'id'));
                if (!$candidatoId || !in_array($candidatoId, $ids, true)) throw new RegraNegocioException('Candidato inexistente.');
            } else {
                $candidatoId = null;
            }

            Voto::inserir($eleicaoId, $eleitorId, $candidatoId, $tipo);
            Eleitor::marcarVotou($eleitorId);
            $pdo->commit();
        } catch (\Throwable $e) {
            $pdo->rollBack();
            throw $e;
        }
    }
}
