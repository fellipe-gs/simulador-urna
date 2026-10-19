<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\{Candidato, Eleicao, Partido, Usuario};

class AdminController extends Controller
{
    public function loginForm(): void
    {
        $this->view('admin/login', ['erro' => null]);
    }

    public function login(): void
    {
        $this->validarCsrf();
        $u = Usuario::porEmail(trim((string)($_POST['email'] ?? '')));
        if (!$u || !password_verify((string)($_POST['senha'] ?? ''), $u['senha_hash']) || $u['perfil'] !== 'ADMIN') {
            $this->view('admin/login', ['erro' => 'E-mail ou senha inválidos.']);
            return;
        }
        session_regenerate_id(true);
        $_SESSION['admin_id'] = (int)$u['id'];
        $this->redirect('/admin');
    }

    public function logout(): void
    {
        $this->validarCsrf();
        session_destroy();
        $this->redirect('/');
    }

    public function painel(): void
    {
        $this->exigirAdmin();
        $eleicao = Eleicao::atual();
        $this->view('admin/painel', [
            'eleicao'    => $eleicao,
            'partidos'   => Partido::todos(),
            'candidatos' => Candidato::daEleicao((int)$eleicao['id']),
            'erro'       => $_SESSION['flash_erro'] ?? null,
        ]);
        unset($_SESSION['flash_erro']);
    }

    public function iniciarEleicao(): void
    {
        $this->exigirAdmin(); $this->validarCsrf();
        Eleicao::definirStatus((int)Eleicao::atual()['id'], 'EM_ANDAMENTO');
        $this->redirect('/admin');
    }

    public function encerrarEleicao(): void
    {
        $this->exigirAdmin(); $this->validarCsrf();
        Eleicao::definirStatus((int)Eleicao::atual()['id'], 'ENCERRADA');
        $this->redirect('/apuracao');
    }

    public function criarPartido(): void
    {
        $this->exigirAdmin(); $this->validarCsrf();
        $nome = trim((string)($_POST['nome'] ?? ''));
        $sigla = strtoupper(trim((string)($_POST['sigla'] ?? '')));
        $num = (int)($_POST['numero'] ?? 0);
        if ($nome === '' || $sigla === '' || $num < 10 || $num > 99) {
            $_SESSION['flash_erro'] = 'Partido: preencha nome, sigla e número (10 a 99).';
        } else {
            try { Partido::criar($nome, $sigla, $num); }
            catch (\PDOException $e) { $_SESSION['flash_erro'] = 'Sigla ou número de partido já existe.'; }
        }
        $this->redirect('/admin');
    }

    public function excluirPartido(): void
    {
        $this->exigirAdmin(); $this->validarCsrf();
        try { Partido::excluir((int)$_POST['id']); }
        catch (\PDOException $e) { $_SESSION['flash_erro'] = 'Partido possui candidatos vinculados.'; }
        $this->redirect('/admin');
    }

    public function criarCandidato(): void
    {
        $this->exigirAdmin(); $this->validarCsrf();
        $nome = trim((string)($_POST['nome'] ?? ''));
        $num  = preg_replace('/\D/', '', (string)($_POST['numero'] ?? ''));
        $cargo = trim((string)($_POST['cargo'] ?? ''));
        $pid  = (int)($_POST['partido_id'] ?? 0);
        if ($nome === '' || $num === '' || $cargo === '' || !$pid) {
            $_SESSION['flash_erro'] = 'Candidato: preencha todos os campos.';
        } else {
            try { Candidato::criar($nome, $num, $cargo, $pid, (int)Eleicao::atual()['id']); }
            catch (\PDOException $e) { $_SESSION['flash_erro'] = 'Número de candidato já existe nesta eleição.'; }
        }
        $this->redirect('/admin');
    }

    public function excluirCandidato(): void
    {
        $this->exigirAdmin(); $this->validarCsrf();
        try { Candidato::excluir((int)$_POST['id']); }
        catch (\PDOException $e) { $_SESSION['flash_erro'] = 'Candidato já possui votos.'; }
        $this->redirect('/admin');
    }
}
