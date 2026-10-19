<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\{Eleicao, Eleitor};

class AuthController extends Controller
{
    public function loginForm(): void
    {
        $this->view('auth/login', ['erro' => null]);
    }

    public function login(): void
    {
        $this->validarCsrf();
        $id    = trim((string)($_POST['identificador'] ?? ''));
        $senha = (string)($_POST['senha'] ?? '');
        $erro  = null;

        if ($id === '' || $senha === '' || strlen($id) > 50) {
            $erro = 'Informe identificador e senha.';
        } else {
            $eleitor = Eleitor::porIdentificador($id);
            $eleicao = Eleicao::atual();
            // Mensagem genérica: não revela se o identificador existe (RB02)
            if (!$eleitor || !password_verify($senha, $eleitor['senha_hash'])) {
                $erro = 'Identificador ou senha inválidos.';
            } elseif ($eleitor['status'] !== 'ATIVO') {
                $erro = 'Eleitor bloqueado. Procure o mesário.';
            } elseif ((int)$eleitor['votou'] === 1) {
                $erro = 'Este eleitor já votou.';
            } elseif (!$eleicao || $eleicao['status'] !== 'EM_ANDAMENTO') {
                $erro = 'A eleição não está em andamento.';
            }
        }

        if ($erro) {
            $this->view('auth/login', ['erro' => $erro]);
            return;
        }

        session_regenerate_id(true);
        $_SESSION['eleitor_id'] = (int)$eleitor['id'];
        $_SESSION['eleicao_id'] = (int)$eleitor['eleicao_id'];
        $this->redirect('/votar');
    }

    public function logout(): void
    {
        $this->validarCsrf();
        session_destroy();
        $this->redirect('/');
    }
}
