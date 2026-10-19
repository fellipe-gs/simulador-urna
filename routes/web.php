<?php
/** @var App\Core\Router $router */

// Público / eleitor
$router->get('/',                   'HomeController@index');
$router->get('/login',              'AuthController@loginForm');
$router->post('/login',             'AuthController@login');
$router->post('/logout',            'AuthController@logout');

// Votação (exige eleitor autenticado)
$router->get('/votar',              'VotacaoController@teclado');
$router->post('/votar/numero',      'VotacaoController@buscarNumero');
$router->post('/votar/branco',      'VotacaoController@branco');
$router->post('/votar/confirmar',   'VotacaoController@confirmar');

// Apuração e encerramento
$router->get('/apuracao',           'ApuracaoController@resultado');
$router->get('/encerrada',          'ApuracaoController@encerrada');

// Administração (exige administrador)
$router->get('/admin/login',        'AdminController@loginForm');
$router->post('/admin/login',       'AdminController@login');
$router->post('/admin/logout',      'AdminController@logout');
$router->get('/admin',              'AdminController@painel');
$router->post('/admin/eleicao/iniciar',  'AdminController@iniciarEleicao');
$router->post('/admin/eleicao/encerrar', 'AdminController@encerrarEleicao');
$router->post('/admin/partidos',         'AdminController@criarPartido');
$router->post('/admin/partidos/excluir', 'AdminController@excluirPartido');
$router->post('/admin/candidatos',         'AdminController@criarCandidato');
$router->post('/admin/candidatos/excluir', 'AdminController@excluirCandidato');
