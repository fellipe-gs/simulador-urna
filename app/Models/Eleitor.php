<?php
namespace App\Models;

use App\Core\Database;

class Eleitor
{
    public static function porIdentificador(string $identificador): ?array
    {
        $st = Database::pdo()->prepare('SELECT * FROM eleitores WHERE identificador = ?');
        $st->execute([$identificador]);
        return $st->fetch() ?: null;
    }

    /** Bloqueia a linha na transação para evitar voto duplicado concorrente. */
    public static function travar(int $id): ?array
    {
        $st = Database::pdo()->prepare('SELECT * FROM eleitores WHERE id = ? FOR UPDATE');
        $st->execute([$id]);
        return $st->fetch() ?: null;
    }

    public static function marcarVotou(int $id): void
    {
        Database::pdo()->prepare('UPDATE eleitores SET votou = 1 WHERE id = ?')->execute([$id]);
    }
}
