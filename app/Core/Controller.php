<?php
namespace App\Core;

abstract class Controller
{
    protected function view(string $name, array $data = []): void
    {
        extract($data);
        ob_start();
        require BASE_PATH . "/app/Views/$name.php";
        $content = ob_get_clean();
        require BASE_PATH . '/app/Views/layout.php';
    }

    protected function redirect(string $path): never
    {
        header("Location: $path");
        exit;
    }

    // --- CSRF ---
    public static function csrfToken(): string
    {
        return $_SESSION['csrf'] ??= bin2hex(random_bytes(32));
    }

    protected function validarCsrf(): void
    {
        $ok = isset($_POST['csrf']) && hash_equals($_SESSION['csrf'] ?? '', $_POST['csrf']);
        if (!$ok) {
            http_response_code(419);
            exit('Requisição inválida. Recarregue a página.');
        }
    }

    // --- Autorização server-side ---
    protected function exigirEleitor(): void
    {
        if (empty($_SESSION['eleitor_id'])) $this->redirect('/login');
    }

    protected function exigirAdmin(): void
    {
        if (empty($_SESSION['admin_id'])) $this->redirect('/admin/login');
    }
}
