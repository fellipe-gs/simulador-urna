<?php
namespace App\Controllers;

use App\Core\{Controller, RegraNegocioException};
use App\Models\{Candidato, Eleicao};
use App\Services\VotacaoService;

class VotacaoController extends Controller
{
    public function teclado(): void
    {
        $this->exigirEleitor();
        $this->view('votacao/teclado');
    }

    public function buscarNumero(): void
    {
        $this->exigirEleitor();
        $this->validarCsrf();
        $numero = preg_replace('/\D/', '', (string)($_POST['numero'] ?? ''));
        $cand   = $numero !== '' ? Candidato::porNumero($_SESSION['eleicao_id'], $numero) : null;

        if ($cand) {
            $this->view('votacao/confirmacao', ['candidato' => $cand, 'tipo' => 'VALIDO']);
        } else {
            // Número inexistente: eleitor pode corrigir ou confirmar voto NULO (RF10)
            $this->view('votacao/numero_invalido', ['numero' => $numero]);
        }
    }

    public function branco(): void
    {
        $this->exigirEleitor();
        $this->validarCsrf();
        $this->view('votacao/confirmacao', ['candidato' => null, 'tipo' => 'BRANCO']);
    }

    public function confirmar(): void
    {
        $this->exigirEleitor();
        $this->validarCsrf();
        $tipo = (string)($_POST['tipo'] ?? '');
        $cid  = isset($_POST['candidato_id']) ? (int)$_POST['candidato_id'] : null;

        try {
            (new VotacaoService())->registrar($_SESSION['eleitor_id'], $_SESSION['eleicao_id'], $tipo, $cid);
        } catch (RegraNegocioException $e) {
            $this->view('votacao/teclado', ['erro' => $e->getMessage()]);
            return;
        }

        // Encerra a sessão do eleitor: não há como votar de novo (RB11/RB04)
        $_SESSION = [];
        $this->view('votacao/computado');
    }
}
