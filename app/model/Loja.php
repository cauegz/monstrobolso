<?php
class Loja implements JsonSerializable{
    private static $pdo;
    private ?int $id = null;
    //private existeNoBanco = $this->id !== null;
    private string $nome;
    private int $categoria_id;

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
        // Remove espaços e verifica se o valor está vazio
        if (!trim((string)$valor)) {
            throw new \InvalidArgumentException('Credenciais inválidas');
        }

        
        //Verifica se existe um método setSuaPropriedade explícito
        // Usamos ucfirst($nome) para seguir o padrão camelCase
        $metodo = 'set' . ucfirst($nome);

        if (method_exists($this, $metodo)) {
            $this->$metodo($valor);
            return;
        }
        $this->$nome = $valor;
    
    }
    public function setNome($nome){
        if (!in_array($nome, ['l1', 'l2', 'l3'], true)) {
            throw new \Exception('O nome da loja deve ser l1, l2 ou l3');
        }
        $this->nome = $nome;
    }
    public static function find($id)
    {
        $sql = "SELECT id, nome, categoria_id 
                FROM public.loja WHERE id = :id";
        $result = self::getPDO()->prepare($sql);

        //vincula a variavel PHP ao marcador da query
        $result->bindParam(":id", $id);

        $result->execute();

        return $result->fetchObject(self::class);
    }

    public static function all($filter = null)
    {
        $sql = "SELECT *
                FROM loja";

        if ($filter) {
            $sql .= " WHERE " . $filter;
        }

        $result = self::getPDO()->prepare($sql);

        $result->execute();

        return $result->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    public static function delete(int $id)
    {
        $sql = "DELETE FROM loja
                WHERE id = :id";

        $result = self::getPDO()->prepare($sql);

        $result->bindParam(":id", $id);

        $result->execute();
    }
    public function isNovo(): bool
    {
        return $this->id === null; // Retorna true se for novo, false se já estiver no banco
    }

    public function save()
    {
        if(isNovo == true){

            $sql = "INSERT INTO public.loja (nome, categoria_id)
                    VALUES(:nome, :categoria_id)";
            
            $result = self::getPDO()->prepare($sql);
            $result->bindParam(":nome", $this->nome);
            $result->bindParam(":categoria_id", $this->categoria_id);
            $result->execute();

            $this->id = self::getPDO()->lastInsertId();
        }
        else{
            $sql = "UPDATE public.loja
                    SET nome = :nome,
                        categoria_id = :categoria_id
                    WHERE id = :id";

            $result = self::getPDO()->prepare($sql);

            $result->bindParam(":nome", $this->nome);
            $result->bindParam(":categoria_id", $this->categoria_id);
            
            $result->execute();
        }
    }

}