<?php
namespace App\Models;

use App\Core\Database;

class Usuario
{
    public static function porEmail(string $email): ?array
    {
        $st = Database::pdo()->prepare('SELECT * FROM usuarios WHERE email = ?');
        $st->execute([$email]);
        return $st->fetch() ?: null;
    }
}
