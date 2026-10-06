<?php
class Usuario{
    private static $pdo;
    private $login;
    private $senha;
    private $nome;

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

        return $result->fetch(PDO::FETCH_CLASS, self::class);
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

    public function setSenha($senha){
        if(strlen($senha) < 8 || !self::temMaiuscula($senha) || !self::temMinuscula($senha)){
            //fazer exceção personalizada aqui
            throw new Exception("Senha inválida");
        }
        $this->senha = $senha;
    }

    private static function temMaiuscula($senha){
        if(preg_match("[A-Z]", $senha)){
            return true;
        }
        return false;
    }

    private static function temMinuscula($senha)
    {
        if (preg_match("[a-z]", $senha)) {
            return true;
        }
        return false;
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