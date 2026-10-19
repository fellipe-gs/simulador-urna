<?php
namespace App\Models;

use App\Core\Database;

class Candidato
{
    public static function porNumero(int $eleicaoId, string $numero): ?array
    {
        $st = Database::pdo()->prepare(
            'SELECT c.*, p.sigla AS partido_sigla, p.nome AS partido_nome
               FROM candidatos c JOIN partidos p ON p.id = c.partido_id
              WHERE c.eleicao_id = ? AND c.numero = ?'
        );
        $st->execute([$eleicaoId, $numero]);
        return $st->fetch() ?: null;
    }

    public static function daEleicao(int $eleicaoId): array
    {
        $st = Database::pdo()->prepare(
            'SELECT c.*, p.sigla AS partido_sigla FROM candidatos c
               JOIN partidos p ON p.id = c.partido_id
              WHERE c.eleicao_id = ? ORDER BY c.numero'
        );
        $st->execute([$eleicaoId]);
        return $st->fetchAll();
    }

    public static function criar(string $nome, string $numero, string $cargo, int $partidoId, int $eleicaoId): void
    {
        Database::pdo()->prepare(
            'INSERT INTO candidatos (nome, numero, cargo, partido_id, eleicao_id) VALUES (?, ?, ?, ?, ?)'
        )->execute([$nome, $numero, $cargo, $partidoId, $eleicaoId]);
    }

    public static function excluir(int $id): void
    {
        Database::pdo()->prepare('DELETE FROM candidatos WHERE id = ?')->execute([$id]);
    }
}
