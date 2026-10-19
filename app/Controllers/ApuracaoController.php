<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Eleicao;
use App\Services\ApuracaoService;

class ApuracaoController extends Controller
{
    public function resultado(): void
    {
        $this->exigirAdmin();
        $eleicao = Eleicao::atual();
        $dados   = (new ApuracaoService())->resultado((int)$eleicao['id']);
        $this->view('apuracao/resultado', ['eleicao' => $eleicao] + $dados);
    }

    public function encerrada(): void
    {
        $this->view('apuracao/encerrada');
    }
}
