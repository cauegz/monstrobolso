<?php
class ItensCompra implements \JsonSerializable
    {
        private static $pdo;
        private ?int $id = null;
        private int $quantidade
        private int $id_produto;
        private int $id_usuario;

        private static function getPDO()
        {
            if (self::$pdo === null) {
                self::$pdo = Conexao::getPDO();
            }
            return self::$pdo;
        }
        public function __get(string $nome)
        {
            return $this->$nome;
        }
        public function __set(string $nome, $valor)
        {
            if (!trim((string)$valor)) {
                throw new \InvalidArgumentException('Credenciais inválidas');
            }

            $metodo = 'set' . ucfirst($nome);

            if (method_exists($this, $metodo)) {
                $this->$metodo($valor);
                return;
            }
            $this->$nome = $valor;
        }
        public function jsonSerialize(): array
        {
            return [
                'id'   => $this->id,
                'quantidade' => $this->quantidade,
                'id_produto' => $this->id_produto,
                'id_usuario' => $this->id_usuario
            ];
        }
        public static function find($id)
        {
            $sql = "SELECT * FROM public.itens_compra WHERE id = :id";
            $result = self::getPDO()->prepare($sql);
            $result->bindParam(":id", $id);
            $result->execute();

            return $result->fetchObject(self::class);
        }
        public static function all($filter = null)
        {
            $sql = "SELECT * FROM public.itens_compra";

            if ($filter) {
                $sql .= " WHERE " . $filter;
            }

            $result = self::getPDO()->prepare($sql);
            $result->execute();

            return $result->fetchAll(\PDO::FETCH_CLASS, self::class);
        }
        public static function delete(int $id)
        {
            $sql = "DELETE FROM public.itens_compra WHERE id = :id";
            $result = self::getPDO()->prepare($sql);
            $result->bindParam(":id", $id);
            $result->execute();
        }
        public function isNovo(): bool
        {
            return $this->id === null;
        }

        public function save()
        {
            
            if ($this->isNovo()) { 
                $sql = "INSERT INTO public.itens_compra (quantidade, id_produto, id_usuario) VALUES (:quantidade, :id_produto, :id_usuario)";
                
                $result = self::getPDO()->prepare($sql);
                $result->bindParam(":quantidade", $this->quantidade);
                $result->bindParam(":id_produto", $this->id_produto);
                $result->bindParam(":id_usuario", $this->id_usuario)
                $result->execute();

                $this->id = (int)self::getPDO()->lastInsertId();
            } else {
                
                $sql = "UPDATE public.itens_compra SET quantidade = :quantidade, id_produto = :id_produto, id_usuario = :id_usuario WHERE id = :id"; 

                $result = self::getPDO()->prepare($sql);
                $result->bindParam(":id", $this->id); 
                $result->bindParam(":quantidade", $this->quantidade);
                $result->bindParam("id_produto", $this->id_produto);
                $result->bindParam(":id_usuario", $this->id_usuario);
                $result->execute();
            
        }
    }

}