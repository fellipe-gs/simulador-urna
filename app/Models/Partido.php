<?php
namespace App\Models;

use App\Core\Database;

class Partido
{
    public static function todos(): array
    {
        return Database::pdo()->query('SELECT * FROM partidos ORDER BY numero')->fetchAll();
    }

    public static function criar(string $nome, string $sigla, int $numero): void
    {
        Database::pdo()->prepare('INSERT INTO partidos (nome, sigla, numero) VALUES (?, ?, ?)')
            ->execute([$nome, $sigla, $numero]);
    }

    public static function excluir(int $id): void
    {
        Database::pdo()->prepare('DELETE FROM partidos WHERE id = ?')->execute([$id]);
    }
}
