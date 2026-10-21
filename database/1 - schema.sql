
CREATE TABLE IF NOT EXISTS categoria
(
  id   INT     NOT NULL GENERATED ALWAYS AS IDENTITY,
  tipo CHAR(1) NOT NULL UNIQUE,
  PRIMARY KEY (id)
);

COMMENT ON COLUMN categoria.tipo IS 'CHECK (tipo IN (''1'',''2'',''3''))';

CREATE TABLE IF NOT EXISTS efeito
(
  id   INT          NOT NULL GENERATED ALWAYS AS IDENTITY,
  nome VARCHAR(100) NOT NULL UNIQUE,
  PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS inventario
(
  id              INT NOT NULL GENERATED ALWAYS AS IDENTITY,
  id_item_pokeapi INT NOT NULL,
  id_treinador    INT NOT NULL,
  quantidade      INT NOT NULL DEFAULT 1,
  PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS itens_compra
(
  id         INT NOT NULL GENERATED ALWAYS AS IDENTITY,
  quantidade INT NOT NULL,
  id_produto INT NOT NULL,
  id_usuario INT NOT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS log_usuario
(
  id         INT          NOT NULL GENERATED ALWAYS AS IDENTITY,
  usuario_id INT          NOT NULL,
  acao       VARCHAR(12)  NOT NULL,
  mensagem   VARCHAR(200) NOT NULL,
  criado_em  TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS loja
(
  id           INT     NOT NULL GENERATED ALWAYS AS IDENTITY,
  nome         CHAR(2) NOT NULL UNIQUE,
  categoria_id INT     NOT NULL,
  PRIMARY KEY (id)
);

COMMENT ON COLUMN loja.nome IS 'CHECK (nome IN (''l1'',''l2'',''l3''))';

CREATE TABLE IF NOT EXISTS npc
(
  id          INT          NOT NULL GENERATED ALWAYS AS IDENTITY,
  nome        VARCHAR(100) NOT NULL,
  id_tipo_npc INT          NOT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS pokemon
(
  id              INT NOT NULL GENERATED ALWAYS AS IDENTITY,
  id_pokeapi      INT NOT NULL,
  hp              INT NOT NULL,
  ataque          INT NOT NULL DEFAULT 0,
  defesa          INT NOT NULL DEFAULT 0,
  ataque_especial INT NOT NULL DEFAULT 0,
  defesa_especial INT NOT NULL DEFAULT 0,
  velocidade      INT NOT NULL DEFAULT 0,
  id_efeito       INT,
  id_treinador    INT NOT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS produto
(
  id              INT           NOT NULL GENERATED ALWAYS AS IDENTITY,
  id_item_pokeapi INT           NOT NULL UNIQUE,
  nome            VARCHAR(100)  NOT NULL,
  preco           DECIMAL(10,2) NOT NULL,
  estoque         INT           NOT NULL,
  categoria_id    INT           NOT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS time
(
  id           INT NOT NULL GENERATED ALWAYS AS IDENTITY,
  posicao      INT NOT NULL,
  id_treinador INT NOT NULL,
  id_pokemon   INT NOT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS tipo_npc
(
  id   INT          NOT NULL GENERATED ALWAYS AS IDENTITY,
  nome VARCHAR(100) NOT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS treinador
(
  id         INT NOT NULL GENERATED ALWAYS AS IDENTITY,
  id_npc     INT,
  id_usuario INT,
  PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS usuario
(
  id    INT          NOT NULL GENERATED ALWAYS AS IDENTITY,
  login VARCHAR(100) NOT NULL UNIQUE,
  senha VARCHAR(255) NOT NULL,
  nome  VARCHAR(100),
  PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS venda
(
  id              INT NOT NULL GENERATED ALWAYS AS IDENTITY,
  id_itens_compra INT NOT NULL,
  id_loja         INT NOT NULL,
  PRIMARY KEY (id)
);

ALTER TABLE npc DROP CONSTRAINT IF EXISTS FK_tipo_npc_TO_npc;
ALTER TABLE npc
  ADD CONSTRAINT FK_tipo_npc_TO_npc
    FOREIGN KEY (id_tipo_npc)
    REFERENCES tipo_npc (id);

ALTER TABLE pokemon DROP CONSTRAINT IF EXISTS FK_efeito_TO_pokemon;
ALTER TABLE pokemon
  ADD CONSTRAINT FK_efeito_TO_pokemon
    FOREIGN KEY (id_efeito)
    REFERENCES efeito (id);

ALTER TABLE treinador DROP CONSTRAINT IF EXISTS FK_npc_TO_treinador;
ALTER TABLE treinador
  ADD CONSTRAINT FK_npc_TO_treinador
    FOREIGN KEY (id_npc)
    REFERENCES npc (id);

ALTER TABLE treinador DROP CONSTRAINT IF EXISTS FK_usuario_TO_treinador;
ALTER TABLE treinador
  ADD CONSTRAINT FK_usuario_TO_treinador
    FOREIGN KEY (id_usuario)
    REFERENCES usuario (id);

ALTER TABLE inventario DROP CONSTRAINT IF EXISTS FK_treinador_TO_inventario;
ALTER TABLE inventario
  ADD CONSTRAINT FK_treinador_TO_inventario
    FOREIGN KEY (id_treinador)
    REFERENCES treinador (id);

ALTER TABLE produto DROP CONSTRAINT IF EXISTS FK_categoria_TO_produto;
ALTER TABLE produto
  ADD CONSTRAINT FK_categoria_TO_produto
    FOREIGN KEY (categoria_id)
    REFERENCES categoria (id);

ALTER TABLE loja DROP CONSTRAINT IF EXISTS FK_categoria_TO_loja;
ALTER TABLE loja
  ADD CONSTRAINT FK_categoria_TO_loja
    FOREIGN KEY (categoria_id)
    REFERENCES categoria (id);

ALTER TABLE venda DROP CONSTRAINT IF EXISTS FK_loja_TO_venda;
ALTER TABLE venda
  ADD CONSTRAINT FK_loja_TO_venda
    FOREIGN KEY (id_loja)
    REFERENCES loja (id);

ALTER TABLE venda DROP CONSTRAINT IF EXISTS FK_itens_compra_TO_venda;
ALTER TABLE venda
  ADD CONSTRAINT FK_itens_compra_TO_venda
    FOREIGN KEY (id_itens_compra)
    REFERENCES itens_compra (id);

ALTER TABLE itens_compra DROP CONSTRAINT IF EXISTS FK_produto_TO_itens_compra;
ALTER TABLE itens_compra
  ADD CONSTRAINT FK_produto_TO_itens_compra
    FOREIGN KEY (id_produto)
    REFERENCES produto (id);

ALTER TABLE itens_compra DROP CONSTRAINT IF EXISTS FK_usuario_TO_itens_compra;
ALTER TABLE itens_compra
  ADD CONSTRAINT FK_usuario_TO_itens_compra
    FOREIGN KEY (id_usuario)
    REFERENCES usuario (id);

ALTER TABLE log_usuario DROP CONSTRAINT IF EXISTS FK_usuario_TO_log_usuario;
ALTER TABLE log_usuario
  ADD CONSTRAINT FK_usuario_TO_log_usuario
    FOREIGN KEY (usuario_id)
    REFERENCES usuario (id);

ALTER TABLE pokemon DROP CONSTRAINT IF EXISTS FK_treinador_TO_pokemon;
ALTER TABLE pokemon
  ADD CONSTRAINT FK_treinador_TO_pokemon
    FOREIGN KEY (id_treinador)
    REFERENCES treinador (id);

ALTER TABLE time DROP CONSTRAINT IF EXISTS FK_treinador_TO_time;
ALTER TABLE time
  ADD CONSTRAINT FK_treinador_TO_time
    FOREIGN KEY (id_treinador)
    REFERENCES treinador (id);

ALTER TABLE time DROP CONSTRAINT IF EXISTS FK_pokemon_TO_time;
ALTER TABLE time
  ADD CONSTRAINT FK_pokemon_TO_time
    FOREIGN KEY (id_pokemon)
    REFERENCES pokemon (id);
