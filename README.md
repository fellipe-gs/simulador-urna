# Simulador Didático de Urna Eletrônica

Sistema web **exclusivamente educacional** que simula votação e apuração com dados 100% fictícios.
Projeto de Vida – Mundo do Trabalho II (SESI/SENAI).

**Stack:** PHP 8.1+ (puro, MVC) • MySQL 8 • HTML/CSS/JS • Git/GitHub • Trello • Google Drive

## Equipe
| Nome | Papel |
|------|-------|
| _preencher_ | _preencher_ |

## Links do projeto
- Trello: _colar link_
- Google Drive: _colar link_

## Estrutura (MVC)
```
app/Controllers   # recebem a requisição e chamam Services/Models
app/Models        # acesso ao banco (consultas parametrizadas)
app/Services      # regras de negócio (votação, apuração)
app/Views         # HTML (telas)
app/Core          # Router, Controller base, Database, Env
config/           # configurações (lidas do .env)
database/         # schema.sql e seed.sql
public/           # ponto de entrada (index.php) e CSS
routes/           # mapa de rotas
tests/            # testes
docs/             # requisitos, banco, arquitetura, testes, evidências
```

## Como rodar
1. Copie `.env.example` para `.env` e ajuste o acesso ao MySQL (o `.env` **não** vai para o Git).
2. Crie o banco: `mysql -u root -p < database/schema.sql` e depois `mysql -u root -p < database/seed.sql`.
3. Suba o servidor: `php -S localhost:8000 -t public public/index.php`
4. Acesse `http://localhost:8000`.

## Dados fictícios de teste
| Perfil | Login | Senha | Situação |
|--------|-------|-------|----------|
| Eleitor | ELE001 / ELE002 | eleitor123 | ATIVO (pode votar) |
| Eleitor | ELE003 | eleitor123 | BLOQUEADO (CT04) |
| Eleitor | ELE004 | eleitor123 | JÁ VOTOU (CT05) |
| Admin | admin@urna.test | admin123 | Painel em `/admin` |

> A eleição começa como `CRIADA`: entre no painel admin e clique em **Iniciar** antes de testar o voto.

## Fluxo
Abertura → Autenticação do eleitor → Número → Confirmação / Branco / Número inválido (nulo) → Voto computado → Apuração (admin) → Encerramento.

## Segurança aplicada
`password_hash/password_verify` • PDO com prepared statements • validação server-side • token CSRF • `session_regenerate_id` • autorização no servidor (eleitor/admin) • transação com `FOR UPDATE` + `UNIQUE (eleicao_id, eleitor_id)` contra voto duplicado • escape de saída (`htmlspecialchars`) contra XSS.

## Testes
`php tests/run.php` (apuração e hash). A matriz completa CT01–CT12 fica em `docs/testes/`.

## Status
- [x] Estrutura MVC, rotas, schema/seed
- [x] Autenticação e elegibilidade do eleitor
- [x] Votação (válido, branco, nulo), apuração, encerramento
- [x] Admin: iniciar/encerrar eleição, criar/excluir partidos e candidatos
- [ ] Editar partidos/candidatos (CRUD completo)
- [ ] Testes de fluxo CT01–CT11 com evidências
- [ ] Ajuste visual conforme design system do professor
- [ ] Deploy

## Convenções
- Commits pequenos, em português, no formato `tipo: descrição` (`feat`, `fix`, `docs`, `test`, `chore`).
- Branches: `main` (estável) e `feature/<epic>-<tarefa>` (ex.: `feature/epic05-login-eleitor`).
- Referenciar o card do Trello no commit/PR quando possível.
- Nunca versionar `.env` ou credenciais reais.

> Uso exclusivamente educacional. Todos os candidatos, partidos e eleitores são fictícios.
