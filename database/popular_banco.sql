-- =====================================================
-- Script para popular o banco de dados com dados de teste
-- Execute no banco de dados 'capsula'
-- =====================================================

USE capsula;

-- =====================================================
-- POSTS (Blog e Galeria)
-- =====================================================
INSERT INTO post (conteudo, data_publicacao, imagem, autor, tipo_post) VALUES
('Hoje foi um dia muito especial! Finalmente abrimos a cápsula do tempo que enterramos em 2015. Muitas lágrimas, risadas e memórias incríveis!', '2025-11-29 10:00:00', 'uploads/blogImagem_teste1.jpg', 'Professora Maria', 'post_geral'),
('Olha essa foto que achamos! Éramos tão jovens... O tempo passou voando, mas as amizades permanecem.', '2025-11-29 11:30:00', 'uploads/blogImagem_teste2.jpg', 'João Silva', 'post_geral'),
('Quem lembra dessa viagem de formatura? Foi épico! Saudades desses momentos.', '2025-11-29 12:15:00', 'uploads/blogImagem_teste3.jpg', 'Ana Santos', 'galeria'),
('A turma reunida 10 anos depois. Alguns mudaram muito, outros continuam iguais! 😄', '2025-11-29 13:00:00', 'uploads/blogImagem_teste4.jpg', 'Carlos Oliveira', 'galeria'),
('Encontramos as cartas que escrevemos para nós mesmos. Muito emocionante ler o que sonhávamos há 10 anos!', '2025-11-29 14:20:00', 'uploads/blogImagem_teste5.jpg', 'Beatriz Lima', 'post_geral'),
('Foto da nossa sala de aula em 2015. Quantas histórias vivemos ali!', '2025-11-29 15:00:00', 'uploads/blogImagem_teste6.jpg', 'Pedro Costa', 'galeria'),
('O reencontro foi muito além das expectativas. Obrigada a todos que vieram!', '2025-11-29 16:30:00', 'uploads/blogImagem_teste7.jpg', 'Professora Maria', 'post_geral'),
('Achamos o troféu do campeonato de 2015! Ainda somos campeões! 🏆', '2025-11-29 17:00:00', 'uploads/blogImagem_teste8.jpg', 'Lucas Ferreira', 'galeria'),
('As melhores amizades são aquelas que o tempo não apaga. Feliz em rever todos vocês!', '2025-11-28 09:00:00', 'uploads/blogImagem_teste9.jpg', 'Mariana Souza', 'post_geral'),
('Preparativos para a abertura da cápsula. A ansiedade estava no ar!', '2025-11-28 08:00:00', 'uploads/blogImagem_teste10.jpg', 'Professora Maria', 'galeria');

-- =====================================================
-- VISITAS (Estatísticas de acesso)
-- =====================================================
INSERT INTO visitas (user_ip, user_navegador, user_sistema_operacional, visit_data) VALUES
('192.168.1.100', 'Chrome', 'Windows', '2025-11-29 08:00:00'),
('192.168.1.101', 'Firefox', 'Windows', '2025-11-29 08:15:00'),
('192.168.1.102', 'Chrome', 'Android', '2025-11-29 08:30:00'),
('192.168.1.103', 'Safari', 'iOS', '2025-11-29 09:00:00'),
('192.168.1.104', 'Chrome', 'Windows', '2025-11-29 09:15:00'),
('192.168.1.105', 'Edge', 'Windows', '2025-11-29 09:30:00'),
('192.168.1.106', 'Chrome', 'Android', '2025-11-29 10:00:00'),
('192.168.1.107', 'Safari', 'macOS', '2025-11-29 10:15:00'),
('192.168.1.108', 'Chrome', 'Windows', '2025-11-29 10:30:00'),
('192.168.1.109', 'Firefox', 'Linux', '2025-11-29 11:00:00'),
('192.168.1.110', 'Chrome', 'Android', '2025-11-29 11:15:00'),
('192.168.1.111', 'Chrome', 'Windows', '2025-11-29 11:30:00'),
('192.168.1.112', 'Safari', 'iOS', '2025-11-29 12:00:00'),
('192.168.1.113', 'Chrome', 'Windows', '2025-11-29 12:15:00'),
('192.168.1.114', 'Edge', 'Windows', '2025-11-29 12:30:00'),
('192.168.1.115', 'Chrome', 'Android', '2025-11-29 13:00:00'),
('192.168.1.116', 'Firefox', 'Windows', '2025-11-29 13:15:00'),
('192.168.1.117', 'Chrome', 'Windows', '2025-11-29 13:30:00'),
('192.168.1.118', 'Safari', 'iOS', '2025-11-29 14:00:00'),
('192.168.1.119', 'Chrome', 'macOS', '2025-11-29 14:15:00'),
('192.168.1.120', 'Chrome', 'Windows', '2025-11-29 14:30:00'),
('192.168.1.121', 'Opera', 'Windows', '2025-11-29 15:00:00'),
('192.168.1.122', 'Chrome', 'Android', '2025-11-29 15:15:00'),
('192.168.1.123', 'Firefox', 'Android', '2025-11-29 15:30:00'),
('192.168.1.124', 'Chrome', 'Windows', '2025-11-29 16:00:00');

-- =====================================================
-- QUESTIONÁRIOS E RESPOSTAS
-- =====================================================

-- Questionário 1 - Gabriel
INSERT INTO quest (user_nome, quest_data) VALUES ('Gabriel Henrique', '2025-11-29 08:41:00');
SET @quest1 = LAST_INSERT_ID();
INSERT INTO respostas (quest_id, pergunta, resposta_nota, resposta_texto) VALUES
(@quest1, 'emocao', 5, NULL),
(@quest1, 'conexao', 4, NULL),
(@quest1, 'realizacao', 3, NULL),
(@quest1, 'contato', 2, NULL),
(@quest1, 'sentimento_geral', 5, NULL),
(@quest1, 'lembranca_especial', NULL, 'A carta que escrevi para mim mesmo falando sobre meus sonhos de ser programador. Realizei!'),
(@quest1, 'mudanca', NULL, 'Amadureci muito, aprendi a valorizar mais as pessoas ao meu redor.'),
(@quest1, 'sonho_2015', NULL, 'Queria ser desenvolvedor de jogos. Hoje trabalho com web, mas ainda quero fazer um jogo!'),
(@quest1, 'amigo_saudade', NULL, 'Lucas - éramos inseparáveis'),
(@quest1, 'conselho_passado', NULL, 'Não tenha medo de errar. Os erros são os melhores professores.'),
(@quest1, 'mensagem_futuro', NULL, 'Espero que em 2035 você esteja feliz, realizado e cercado de pessoas que ama.');

-- Questionário 2 - Maria Clara
INSERT INTO quest (user_nome, quest_data) VALUES ('Maria Clara', '2025-11-29 09:15:00');
SET @quest2 = LAST_INSERT_ID();
INSERT INTO respostas (quest_id, pergunta, resposta_nota, resposta_texto) VALUES
(@quest2, 'emocao', 5, NULL),
(@quest2, 'conexao', 5, NULL),
(@quest2, 'realizacao', 4, NULL),
(@quest2, 'contato', 3, NULL),
(@quest2, 'sentimento_geral', 5, NULL),
(@quest2, 'lembranca_especial', NULL, 'Uma foto nossa no dia da formatura. Chorei muito ao ver!'),
(@quest2, 'mudanca', NULL, 'Me tornei mais confiante e aprendi a me amar.'),
(@quest2, 'sonho_2015', NULL, 'Sonhava em ser médica. Hoje sou enfermeira e amo minha profissão!'),
(@quest2, 'amigo_saudade', NULL, 'Beatriz - minha melhor amiga da época'),
(@quest2, 'conselho_passado', NULL, 'Aproveite mais os momentos, eles passam rápido demais.'),
(@quest2, 'mensagem_futuro', NULL, 'Continue cuidando das pessoas com amor. Você faz diferença!');

-- Questionário 3 - Pedro Santos
INSERT INTO quest (user_nome, quest_data) VALUES ('Pedro Santos', '2025-11-29 10:00:00');
SET @quest3 = LAST_INSERT_ID();
INSERT INTO respostas (quest_id, pergunta, resposta_nota, resposta_texto) VALUES
(@quest3, 'emocao', 4, NULL),
(@quest3, 'conexao', 3, NULL),
(@quest3, 'realizacao', 5, NULL),
(@quest3, 'contato', 1, NULL),
(@quest3, 'sentimento_geral', 4, NULL),
(@quest3, 'lembranca_especial', NULL, 'O bilhete que a professora Maria escreveu pra cada um de nós.'),
(@quest3, 'mudanca', NULL, 'Fisicamente mudei bastante! Perdi 20kg e ganhei uma barba haha'),
(@quest3, 'sonho_2015', NULL, 'Queria viajar o mundo. Já conheci 15 países!'),
(@quest3, 'amigo_saudade', NULL, 'João - parceiro de todas as horas'),
(@quest3, 'conselho_passado', NULL, 'Estude inglês desde cedo, vai abrir muitas portas.'),
(@quest3, 'mensagem_futuro', NULL, 'Não pare de explorar o mundo. A vida é curta demais pra ficar parado.');

-- Questionário 4 - Ana Beatriz
INSERT INTO quest (user_nome, quest_data) VALUES ('Ana Beatriz', '2025-11-29 10:30:00');
SET @quest4 = LAST_INSERT_ID();
INSERT INTO respostas (quest_id, pergunta, resposta_nota, resposta_texto) VALUES
(@quest4, 'emocao', 5, NULL),
(@quest4, 'conexao', 4, NULL),
(@quest4, 'realizacao', 4, NULL),
(@quest4, 'contato', 4, NULL),
(@quest4, 'sentimento_geral', 5, NULL),
(@quest4, 'lembranca_especial', NULL, 'O CD com as músicas que a gente ouvia em 2015. Puro nostalgia!'),
(@quest4, 'mudanca', NULL, 'Me casei, tive dois filhos. A vida mudou completamente!'),
(@quest4, 'sonho_2015', NULL, 'Sonhava em ter uma família. Realizado com muito amor!'),
(@quest4, 'amigo_saudade', NULL, 'Maria Clara - ainda somos amigas!'),
(@quest4, 'conselho_passado', NULL, 'Não se preocupe tanto com a opinião dos outros.'),
(@quest4, 'mensagem_futuro', NULL, 'Espero que seus filhos estejam crescendo felizes e saudáveis.');

-- Questionário 5 - Lucas Ferreira
INSERT INTO quest (user_nome, quest_data) VALUES ('Lucas Ferreira', '2025-11-29 11:00:00');
SET @quest5 = LAST_INSERT_ID();
INSERT INTO respostas (quest_id, pergunta, resposta_nota, resposta_texto) VALUES
(@quest5, 'emocao', 3, NULL),
(@quest5, 'conexao', 2, NULL),
(@quest5, 'realizacao', 3, NULL),
(@quest5, 'contato', 0, NULL),
(@quest5, 'sentimento_geral', 4, NULL),
(@quest5, 'lembranca_especial', NULL, 'A camiseta do time que a gente criou. Ainda tenho a minha guardada!'),
(@quest5, 'mudanca', NULL, 'Mudei de cidade, de profissão, de tudo. Sou outro Lucas.'),
(@quest5, 'sonho_2015', NULL, 'Queria ser jogador de futebol. Não rolou, mas sigo jogando aos fins de semana.'),
(@quest5, 'amigo_saudade', NULL, 'Gabriel - sumimos um do outro'),
(@quest5, 'conselho_passado', NULL, 'Tenha um plano B. Nem tudo sai como planejamos.'),
(@quest5, 'mensagem_futuro', NULL, 'Espero que você tenha encontrado seu caminho e esteja em paz.');

-- Questionário 6 - Juliana Costa
INSERT INTO quest (user_nome, quest_data) VALUES ('Juliana Costa', '2025-11-29 11:30:00');
SET @quest6 = LAST_INSERT_ID();
INSERT INTO respostas (quest_id, pergunta, resposta_nota, resposta_texto) VALUES
(@quest6, 'emocao', 5, NULL),
(@quest6, 'conexao', 5, NULL),
(@quest6, 'realizacao', 5, NULL),
(@quest6, 'contato', 5, NULL),
(@quest6, 'sentimento_geral', 5, NULL),
(@quest6, 'lembranca_especial', NULL, 'O diário coletivo que escrevíamos. Cada página uma memória linda!'),
(@quest6, 'mudanca', NULL, 'Me tornei professora, assim como a prof Maria que tanto admirava.'),
(@quest6, 'sonho_2015', NULL, 'Queria dar aula. Hoje ensino crianças e amo cada dia!'),
(@quest6, 'amigo_saudade', NULL, 'Todos! Mantive contato com quase toda a turma.'),
(@quest6, 'conselho_passado', NULL, 'Siga seu coração. Você estava no caminho certo.'),
(@quest6, 'mensagem_futuro', NULL, 'Continue inspirando seus alunos como a prof Maria nos inspirou.');

-- Questionário 7 - Rafael Oliveira
INSERT INTO quest (user_nome, quest_data) VALUES ('Rafael Oliveira', '2025-11-29 12:00:00');
SET @quest7 = LAST_INSERT_ID();
INSERT INTO respostas (quest_id, pergunta, resposta_nota, resposta_texto) VALUES
(@quest7, 'emocao', 4, NULL),
(@quest7, 'conexao', 3, NULL),
(@quest7, 'realizacao', 2, NULL),
(@quest7, 'contato', 2, NULL),
(@quest7, 'sentimento_geral', 4, NULL),
(@quest7, 'lembranca_especial', NULL, 'As fotos da excursão para o museu. Que dia incrível foi aquele!'),
(@quest7, 'mudanca', NULL, 'Aprendi a ser mais paciente e menos ansioso.'),
(@quest7, 'sonho_2015', NULL, 'Queria ser rico. Descobri que felicidade não tem preço.'),
(@quest7, 'amigo_saudade', NULL, 'Carlos - meu parceiro de bagunça'),
(@quest7, 'conselho_passado', NULL, 'Dinheiro não é tudo. Invista em experiências e pessoas.'),
(@quest7, 'mensagem_futuro', NULL, 'Espero que você tenha aprendido a aproveitar o presente.');

-- Questionário 8 - Camila Rodrigues
INSERT INTO quest (user_nome, quest_data) VALUES ('Camila Rodrigues', '2025-11-29 12:30:00');
SET @quest8 = LAST_INSERT_ID();
INSERT INTO respostas (quest_id, pergunta, resposta_nota, resposta_texto) VALUES
(@quest8, 'emocao', 5, NULL),
(@quest8, 'conexao', 4, NULL),
(@quest8, 'realizacao', 4, NULL),
(@quest8, 'contato', 3, NULL),
(@quest8, 'sentimento_geral', 5, NULL),
(@quest8, 'lembranca_especial', NULL, 'A playlist que fizemos juntos. Cada música conta uma história.'),
(@quest8, 'mudanca', NULL, 'Me descobri como artista. Hoje vivo da minha arte!'),
(@quest8, 'sonho_2015', NULL, 'Queria pintar. Hoje tenho meu próprio ateliê!'),
(@quest8, 'amigo_saudade', NULL, 'Fernanda - sempre me incentivou'),
(@quest8, 'conselho_passado', NULL, 'Não desista dos seus sonhos artísticos. Vale a pena!'),
(@quest8, 'mensagem_futuro', NULL, 'Continue criando. Sua arte toca pessoas.');

-- =====================================================
-- Verificar dados inseridos
-- =====================================================
SELECT 'Posts inseridos:' as info, COUNT(*) as total FROM post;
SELECT 'Visitas inseridas:' as info, COUNT(*) as total FROM visitas;
SELECT 'Questionários inseridos:' as info, COUNT(*) as total FROM quest;
SELECT 'Respostas inseridas:' as info, COUNT(*) as total FROM respostas;
