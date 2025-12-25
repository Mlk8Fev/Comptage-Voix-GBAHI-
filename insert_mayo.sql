-- Script SQL pour insérer les lieux de vote et bureaux de vote de MAYO
-- À exécuter dans phpMyAdmin

-- 1. Insérer les lieux de vote de MAYO
INSERT INTO lieux_vote (nom, commune, circonscription, created_at, updated_at) VALUES
('GROUPE SCOLAIRE BAKAYO', 'MAYO', 'Circonscription MAYO', NOW(), NOW()),
('EPP DEGAULEKRO CPT', 'MAYO', 'Circonscription MAYO', NOW(), NOW()),
('EPP MADOU SAHOUA 1 DE MAYO', 'MAYO', 'Circonscription MAYO', NOW(), NOW()),
('EPP KOMEAYO', 'MAYO', 'Circonscription MAYO', NOW(), NOW()),
('EPP MADOU SAHOUA II DE MAYO', 'MAYO', 'Circonscription MAYO', NOW(), NOW()),
('GROUPE SCOLAIRE MOUSSAYO', 'MAYO', 'Circonscription MAYO', NOW(), NOW()),
('EPP KOUAMEKRO', 'MAYO', 'Circonscription MAYO', NOW(), NOW()),
('EPP ALLANGBAKRO', 'MAYO', 'Circonscription MAYO', NOW(), NOW()),
('EPP BAKAYO 3', 'MAYO', 'Circonscription MAYO', NOW(), NOW()),
('EPP KONANKRO', 'MAYO', 'Circonscription MAYO', NOW(), NOW()),
('EPP MADOUSAHOUA 3', 'MAYO', 'Circonscription MAYO', NOW(), NOW());

-- 2. Insérer les bureaux de vote de MAYO
-- Note: Les totaux sont répartis approximativement 50/50 entre hommes et femmes

-- GROUPE SCOLAIRE BAKAYO - BV 01 (Total: 381)
INSERT INTO bureaux_vote (lieu_vote_id, numero, hommes_inscrits, femmes_inscrits, est_ouvert, created_at, updated_at)
SELECT id, '01', 191, 190, 1, NOW(), NOW()
FROM lieux_vote WHERE nom = 'GROUPE SCOLAIRE BAKAYO' AND commune = 'MAYO';

-- GROUPE SCOLAIRE BAKAYO - BV 02 (Total: 376)
INSERT INTO bureaux_vote (lieu_vote_id, numero, hommes_inscrits, femmes_inscrits, est_ouvert, created_at, updated_at)
SELECT id, '02', 188, 188, 1, NOW(), NOW()
FROM lieux_vote WHERE nom = 'GROUPE SCOLAIRE BAKAYO' AND commune = 'MAYO';

-- EPP DEGAULEKRO CPT - BV 01 (Total: 131)
INSERT INTO bureaux_vote (lieu_vote_id, numero, hommes_inscrits, femmes_inscrits, est_ouvert, created_at, updated_at)
SELECT id, '01', 66, 65, 1, NOW(), NOW()
FROM lieux_vote WHERE nom = 'EPP DEGAULEKRO CPT' AND commune = 'MAYO';

-- EPP MADOU SAHOUA 1 DE MAYO - BV 01 (Total: 400)
INSERT INTO bureaux_vote (lieu_vote_id, numero, hommes_inscrits, femmes_inscrits, est_ouvert, created_at, updated_at)
SELECT id, '01', 200, 200, 1, NOW(), NOW()
FROM lieux_vote WHERE nom = 'EPP MADOU SAHOUA 1 DE MAYO' AND commune = 'MAYO';

-- EPP MADOU SAHOUA 1 DE MAYO - BV 02 (Total: 397)
INSERT INTO bureaux_vote (lieu_vote_id, numero, hommes_inscrits, femmes_inscrits, est_ouvert, created_at, updated_at)
SELECT id, '02', 199, 198, 1, NOW(), NOW()
FROM lieux_vote WHERE nom = 'EPP MADOU SAHOUA 1 DE MAYO' AND commune = 'MAYO';

-- EPP KOMEAYO - BV 01 (Total: 368)
INSERT INTO bureaux_vote (lieu_vote_id, numero, hommes_inscrits, femmes_inscrits, est_ouvert, created_at, updated_at)
SELECT id, '01', 184, 184, 1, NOW(), NOW()
FROM lieux_vote WHERE nom = 'EPP KOMEAYO' AND commune = 'MAYO';

-- EPP MADOU SAHOUA II DE MAYO - BV 01 (Total: 403)
INSERT INTO bureaux_vote (lieu_vote_id, numero, hommes_inscrits, femmes_inscrits, est_ouvert, created_at, updated_at)
SELECT id, '01', 202, 201, 1, NOW(), NOW()
FROM lieux_vote WHERE nom = 'EPP MADOU SAHOUA II DE MAYO' AND commune = 'MAYO';

-- EPP MADOU SAHOUA II DE MAYO - BV 02 (Total: 0 - vide dans l'image, on met 0)
INSERT INTO bureaux_vote (lieu_vote_id, numero, hommes_inscrits, femmes_inscrits, est_ouvert, created_at, updated_at)
SELECT id, '02', 0, 0, 1, NOW(), NOW()
FROM lieux_vote WHERE nom = 'EPP MADOU SAHOUA II DE MAYO' AND commune = 'MAYO';

-- GROUPE SCOLAIRE MOUSSAYO - BV 01 (Total: 346)
INSERT INTO bureaux_vote (lieu_vote_id, numero, hommes_inscrits, femmes_inscrits, est_ouvert, created_at, updated_at)
SELECT id, '01', 173, 173, 1, NOW(), NOW()
FROM lieux_vote WHERE nom = 'GROUPE SCOLAIRE MOUSSAYO' AND commune = 'MAYO';

-- GROUPE SCOLAIRE MOUSSAYO - BV 02 (Total: 344)
INSERT INTO bureaux_vote (lieu_vote_id, numero, hommes_inscrits, femmes_inscrits, est_ouvert, created_at, updated_at)
SELECT id, '02', 172, 172, 1, NOW(), NOW()
FROM lieux_vote WHERE nom = 'GROUPE SCOLAIRE MOUSSAYO' AND commune = 'MAYO';

-- EPP KOUAMEKRO - BV 01 (Total: 110)
INSERT INTO bureaux_vote (lieu_vote_id, numero, hommes_inscrits, femmes_inscrits, est_ouvert, created_at, updated_at)
SELECT id, '01', 55, 55, 1, NOW(), NOW()
FROM lieux_vote WHERE nom = 'EPP KOUAMEKRO' AND commune = 'MAYO';

-- EPP ALLANGBAKRO - BV 01 (Total: 101)
INSERT INTO bureaux_vote (lieu_vote_id, numero, hommes_inscrits, femmes_inscrits, est_ouvert, created_at, updated_at)
SELECT id, '01', 51, 50, 1, NOW(), NOW()
FROM lieux_vote WHERE nom = 'EPP ALLANGBAKRO' AND commune = 'MAYO';

-- EPP BAKAYO 3 - BV 01 (Total: 144)
INSERT INTO bureaux_vote (lieu_vote_id, numero, hommes_inscrits, femmes_inscrits, est_ouvert, created_at, updated_at)
SELECT id, '01', 72, 72, 1, NOW(), NOW()
FROM lieux_vote WHERE nom = 'EPP BAKAYO 3' AND commune = 'MAYO';

-- EPP KONANKRO - BV 01 (Total: 64)
INSERT INTO bureaux_vote (lieu_vote_id, numero, hommes_inscrits, femmes_inscrits, est_ouvert, created_at, updated_at)
SELECT id, '01', 32, 32, 1, NOW(), NOW()
FROM lieux_vote WHERE nom = 'EPP KONANKRO' AND commune = 'MAYO';

-- EPP MADOUSAHOUA 3 - BV 01 (Total: 101)
INSERT INTO bureaux_vote (lieu_vote_id, numero, hommes_inscrits, femmes_inscrits, est_ouvert, created_at, updated_at)
SELECT id, '01', 51, 50, 1, NOW(), NOW()
FROM lieux_vote WHERE nom = 'EPP MADOUSAHOUA 3' AND commune = 'MAYO';

