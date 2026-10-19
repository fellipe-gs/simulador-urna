<?php
function e(?string $v): string { return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }
function csrf(): string { return '<input type="hidden" name="csrf" value="' . e(App\Core\Controller::csrfToken()) . '">'; }
?><!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Simulador Didático de Urna Eletrônica</title>
  <link rel="stylesheet" href="/css/style.css">
</head>
<body>
  <header><h1>Simulador Didático de Urna</h1><span class="tag">Uso exclusivamente educacional</span></header>
  <main><?= $content ?></main>
  <footer>Dados 100% fictícios • Projeto de Vida – Mundo do Trabalho II</footer>
</body>
</html>
