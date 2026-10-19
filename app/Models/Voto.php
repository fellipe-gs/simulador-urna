<?php
namespace App\Models;

use App\Core\Database;

class Voto
{
    public static function inserir(int $eleicaoId, int $eleitorId, ?int $candidatoId, string $tipo): void
    {
        Database::pdo()->prepare(
            'INSERT INTO votos (eleicao_id, eleitor_id, candidato_id, tipo) VALUES (?, ?, ?, ?)'
        )->execute([$eleicaoId, $eleitorId, $candidatoId, $tipo]);
    }

    /** Totais por candidato (votos válidos). */
    public static function porCandidato(int $eleicaoId): array
    {
        $st = Database::pdo()->prepare(
            "SELECT c.id, c.nome, c.numero, p.sigla AS partido_sigla, COUNT(v.id) AS total
               FROM candidatos c
               JOIN partidos p ON p.id = c.partido_id
          LEFT JOIN votos v ON v.candidato_id = c.id AND v.tipo = 'VALIDO'
              WHERE c.eleicao_id = ?
           GROUP BY c.id, c.nome, c.numero, p.sigla
           ORDER BY total DESC, c.numero"
        );
        $st->execute([$eleicaoId]);
        return $st->fetchAll();
    }

    public static function totaisPorTipo(int $eleicaoId): array
    {
        $st = Database::pdo()->prepare('SELECT tipo, COUNT(*) AS total FROM votos WHERE eleicao_id = ? GROUP BY tipo');
        $st->execute([$eleicaoId]);
        return $st->fetchAll(\PDO::FETCH_KEY_PAIR);
    }
}
