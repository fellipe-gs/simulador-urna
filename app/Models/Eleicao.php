<?php
namespace App\Models;

use App\Core\Database;

class Eleicao
{
    public static function atual(): ?array
    {
        $r = Database::pdo()->query('SELECT * FROM eleicoes ORDER BY id DESC LIMIT 1')->fetch();
        return $r ?: null;
    }

    public static function buscar(int $id): ?array
    {
        $st = Database::pdo()->prepare('SELECT * FROM eleicoes WHERE id = ?');
        $st->execute([$id]);
        return $st->fetch() ?: null;
    }

    public static function definirStatus(int $id, string $status): void
    {
        $campo = $status === 'EM_ANDAMENTO' ? ', data_inicio = NOW()' : ($status === 'ENCERRADA' ? ', data_fim = NOW()' : '');
        $st = Database::pdo()->prepare("UPDATE eleicoes SET status = ? $campo WHERE id = ?");
        $st->execute([$status, $id]);
    }
}
