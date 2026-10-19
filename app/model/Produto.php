<?php>
class Produto implements \JsonSerializable
{
    private static $pdo;
    private ?int $id = null;
    private string $nome;
    private float $preco;
    private int  $estoque;
    private int  $categoria_id;
    privte int   $id_item_pokeapi

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
            'nome' => $this->nome,
            'preco' => $this->preco,
            'estoque' => $this->estoque,
            'categoria_id' => $this->categoria_id,
            'id_item_pokeapi' => $this->id_item_pokeapi
        ];
    }

    public static function find($id)
    {
        $sql = "SELECT * FROM public.produto WHERE id = :id";
        $result = self::getPDO()->prepare($sql);
        $result->bindParam(":id", $id);
        $result->execute();

        return $result->fetchObject(self::class);
    }

    public static function all($filter = null)
    {
        $sql = "SELECT * FROM public.produto";

        if ($filter) {
            $sql .= " WHERE " . $filter;
        }

        $result = self::getPDO()->prepare($sql);
        $result->execute();

        return $result->fetchAll(\PDO::FETCH_CLASS, self::class);
    }

    public static function delete(int $id)
    {
        $sql = "DELETE FROM public.produto WHERE id = :id";
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
            $sql = "INSERT INTO public.produto (id_tem_pokeapi, nome, preco, estoque, categoria_id) VALUES (:id_tem_pokeapi, :nome, :preco, :estoque, :categoria_id)";
            
            $result = self::getPDO()->prepare($sql);
            $result->bindParam(":id_item_pokeapi", $this->id_item_pokeapi);
            $result->bindParam(":nome", $this->nome);
            $result->bindParam(":preco", $this->preco);
            $result->bindParam(":estoque", $this->estoque);
            $result->bindParam(":cateoria_id", $this->categoria_id);

            $result->execute();

            $this->id = (int)self::getPDO()->lastInsertId();
        } else {
            
            $sql = "UPDATE public.produto SET id_item_pokeapi = :id_item_pokeapi, nome = :nome, preco = :preco, estoque = :estoque, categoria_id = :categoria_id,    WHERE id = :id"; 

            $result = self::getPDO()->prepare($sql);
            $result->bindParam(":id_item_pokeapi", $this->id_item_pokeapi);
            $result->bindParam(":nome", $this->nome);
            $result->bindParam(":preco", $this->preco);
            $result->bindParam(":estoque", $this->estoque);
            $result->bindParam(":cateoria_id", $this->categoria_id);
            $result->bindParam(":id", $this->id); 
            
            $result->execute();
        }
    }
}
