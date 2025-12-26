-- Script SQL pour ajouter le deuxième bureau de vote à GROUPE SCOLAIRE LESSIRI
-- À exécuter dans phpMyAdmin

-- Ajouter le bureau 02 pour GROUPE SCOLAIRE LESSIRI
INSERT INTO bureaux_vote (lieu_vote_id, numero, hommes_inscrits, femmes_inscrits, est_ouvert, created_at, updated_at)
SELECT 
    id, 
    '02', 
    150,  -- Ajustez selon vos données réelles
    150,  -- Ajustez selon vos données réelles
    1, 
    NOW(), 
    NOW()
FROM lieux_vote 
WHERE nom = 'GROUPE SCOLAIRE LESSIRI' 
AND commune = 'LILIYO'
AND NOT EXISTS (
    SELECT 1 FROM bureaux_vote 
    WHERE lieu_vote_id = lieux_vote.id 
    AND numero = '02'
);

