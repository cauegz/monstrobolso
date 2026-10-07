<?php
class Usuario implements JsonSerializable{
    private static $pdo;
    private ?int $id = null;
    private string $login;
    private string $senha;
    private string $nome;

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
        //antes de executar o set padrão verifica se tem algum explícito na classe
        $metodo = 'set' . ucfirst($nome);

        if (method_exists($this, $metodo)) {
            $this->$metodo($valor);
            return;
        }
        $this->$nome = $valor;
    }

    public static function find($id)
    {
        $sql = "SELECT *
                FROM usuario
                WHERE id = :id";

        $result = self::getPDO()->prepare($sql);

        $result->bindParam(":id", $id);

        $result->execute();

        return $result->fetchObject(self::class);
    }

    public static function all($filter = null)
    {
        $sql = "SELECT *
                FROM usuario";

        if ($filter) {
            $sql .= " WHERE " . $filter;
        }

        $result = self::getPDO()->prepare($sql);

        $result->execute();

        return $result->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    public static function delete(int $id)
    {
        $sql = "DELETE FROM usuario
                WHERE id = :id";

        $result = self::getPDO()->prepare($sql);

        $result->bindParam(":id", $id);

        $result->execute();
    }

    public function save()
    {
        if ($this->id == null) {

            $sql = "INSERT INTO usuario (login, senha, nome)
                    VALUES (:login, :senha, :nome)";

            $result = self::getPDO()->prepare($sql);

            $result->bindParam(":login", $this->login);
            $result->bindParam(":senha", $this->senha);
            $result->bindParam(":nome", $this->nome);

            $result->execute();

            $this->id = self::getPDO()->lastInsertId();
        } else {

            $sql = "UPDATE usuario
                    SET login = :login,
                        senha = :senha,
                        nome = :nome
                    WHERE id = :id";

            $result = self::getPDO()->prepare($sql);

            $result->bindParam(":login", $this->login);
            $result->bindParam(":senha", $this->senha);
            $result->bindParam(":nome", $this->nome);
            $result->bindParam(":id", $this->id);

            $result->execute();
        }
    }

    /**
     * Verifica se a senha do usuário é válida e depois da um hash
     * 
     * @param string $senha: senha do usuário sem hash
     * 
     * @return void; 
     */
    public function setSenha($senha){
        if(strlen($senha) < 8 || !preg_match('/[A-Z]/', $senha) || !preg_match('/[a-z]/', $senha)){
            //fazer exceção personalizada aqui
            throw new Exception("Senha inválida");
        }
        $this->senha = password_hash($senha, PASSWORD_DEFAULT);
    }

    public function jsonSerialize(): mixed
    {
        return [
            "id" => $this->id,
            "login" => $this->login,
            "senha" => $this->senha,
            "nome" => $this->nome
        ];
    }
}