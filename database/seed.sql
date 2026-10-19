-- Dados 100% FICTÍCIOS (RB14). Senhas de teste: eleitores = eleitor123 | admin = admin123
USE simulador_urna;

INSERT INTO usuarios (nome, email, senha_hash, perfil) VALUES
('Administrador Teste', 'admin@urna.test', '$2y$10$HsnQFdObOh6f3pl80h8B2OTIpY3bmjuVk2gwh3CpuYbft/mJuM2Y6', 'ADMIN');

INSERT INTO eleicoes (id, nome, descricao, status) VALUES
(1, 'Eleição Escolar Fictícia 2026', 'Simulação didática', 'CRIADA');

INSERT INTO partidos (id, nome, sigla, numero) VALUES
(1, 'Partido Horizonte Fictício', 'PHF', 11),
(2, 'Partido Aurora Fictício',   'PAF', 22),
(3, 'Partido Rio Claro Fictício', 'PRC', 33);

INSERT INTO candidatos (nome, numero, cargo, partido_id, eleicao_id) VALUES
('Ana Prado (fictícia)',   '11', 'Presidente Fictício', 1, 1),
('Bruno Lima (fictício)',  '22', 'Presidente Fictício', 2, 1),
('Carla Souza (fictícia)', '33', 'Presidente Fictício', 3, 1);

INSERT INTO eleitores (identificador, nome, senha_hash, status, votou, eleicao_id) VALUES
('ELE001', 'Eleitor Teste 1',          '$2y$10$w6vsBYCentnZJDTBv3NY5.0rbjKzkeja5Yzg1O5MAz2POd3nn/OM6', 'ATIVO',     0, 1),
('ELE002', 'Eleitor Teste 2',          '$2y$10$w6vsBYCentnZJDTBv3NY5.0rbjKzkeja5Yzg1O5MAz2POd3nn/OM6', 'ATIVO',     0, 1),
('ELE003', 'Eleitor Bloqueado (CT04)', '$2y$10$w6vsBYCentnZJDTBv3NY5.0rbjKzkeja5Yzg1O5MAz2POd3nn/OM6', 'BLOQUEADO', 0, 1),
('ELE004', 'Eleitor Já Votou (CT05)',  '$2y$10$w6vsBYCentnZJDTBv3NY5.0rbjKzkeja5Yzg1O5MAz2POd3nn/OM6', 'ATIVO',     1, 1);
