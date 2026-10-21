<?php
class Venda implements \JsonSerializable
{
    private static $pdo;
    private ?int $id = null;
    private int $id_itens_compra;
    private int $id_loja;

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
            'id_tens_compra' => $this->id_tens_compra,
            'id_loja' => $this->id_itens_comppra
        ];
    }

    public static function find($id)
    {
        $sql = "SELECT * FROM public.venda WHERE id = :id";
        $result = self::getPDO()->prepare($sql);
        $result->bindParam(":id", $id);
        $result->execute();

        return $result->fetchObject(self::class);
    }

    public static function all($filter = null)
    {
        $sql = "SELECT * FROM public.venda";

        if ($filter) {
            $sql .= " WHERE " . $filter;
        }

        $result = self::getPDO()->prepare($sql);
        $result->execute();

        return $result->fetchAll(\PDO::FETCH_CLASS, self::class);
    }

    public static function delete(int $id)
    {
        $sql = "DELETE FROM public.venda WHERE id = :id";
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
            $sql = "INSERT INTO public.venda (tipo) VALUES (:tipo)";
            
            $result = self::getPDO()->prepare($sql);
            $result->bindParam(":id_itens_compra", $this->id_itens_compra);
            $result->bindParam(":id_loja, $this->id_loja");
            $result->execute();

            $this->id = (int)self::getPDO()->lastInsertId();
        } else {
            
            $sql = "UPDATE public.categoria SET tipo = :tipo WHERE id = :id"; 

            $result = self::getPDO()->prepare($sql);
            $result->bindParam(":id_itens_compra", $this->id_itens_compra);
            $result->bindParam("id_loja", $this->id_loja);
            $result->bindParam(":id", $this->id); 
            $result->execute();
        }
    }
}
