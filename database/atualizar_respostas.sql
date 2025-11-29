-- =====================================================
-- Script para atualizar a tabela RESPOSTAS
-- Execute no seu banco de dados 'capsula'
-- Via HeidiSQL, phpMyAdmin ou linha de comando
-- =====================================================

USE capsula;

-- Se a coluna 'resposta' ainda existir, renomear para 'resposta_nota'
-- E permitir valores NULL
ALTER TABLE respostas 
CHANGE COLUMN resposta resposta_nota INT DEFAULT NULL;

-- Adicionar coluna para respostas de texto
ALTER TABLE respostas 
ADD COLUMN resposta_texto TEXT DEFAULT NULL AFTER resposta_nota;

-- Verificar a nova estrutura
DESCRIBE respostas;

-- =====================================================
-- A tabela respostas agora tem:
-- - respostasId (PK)
-- - quest_id (FK)
-- - pergunta (VARCHAR)
-- - resposta_nota (INT, NULL) - para escalas 0-5
-- - resposta_texto (TEXT, NULL) - para texto livre
-- =====================================================
