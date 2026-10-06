-- TIPOS DE NPC
INSERT INTO tipo_npc (nome) VALUES
('Líder de ginásio'),
('treinador');

-- EFEITOS
INSERT INTO efeito (nome) VALUES
('Normal'),
('Queimado'),
('Envenenado'),
('Paralisado'),
('Adormecido'),
('Congelado'),
('Confuso'),
('Atordoado'),
('Redução de Defesa');

insert into npc (nome, id_tipo_npc) VALUES
('jair de anunciação', 1);