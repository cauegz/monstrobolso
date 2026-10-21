<?php
class Usuario extends ModelGeral implements JsonSerializable, ModelInterface
{
    protected string $login;
    protected string $senha;
    protected string $nome;

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

    public static function delete($id)
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

    public static function findByLogin(string $login)
    {
        $stmt = self::getPDO()->prepare("SELECT * FROM usuario WHERE login = :login");
        $stmt->execute([':login' => $login]);
        return $stmt->fetchObject(self::class); // false se não existir
    }

    /**
     * Verifica se a senha do usuário é válida e depois da um hash
     * 
     * @param string $senha: senha do usuário sem hash
     * 
     * @return void; 
     */
    public function setSenha($senha){
        if (strlen($senha) < 8 || !preg_match('/[A-Z]/', $senha) || !preg_match('/[a-z]/', $senha)) {
            throw new InvalidArgumentException('A senha precisa ter no minímo 8 caracteres, com letra maiúscula e minúscula.');
        }
        $this->senha = password_hash($senha, PASSWORD_DEFAULT);
    }

    public function setLogin(string $login){
        if(!trim($login) || strlen($login) < 2){
            throw new InvalidArgumentException('login inválido');
        }
        $this->login = $login;
    }

    public function setNome(string $nome){
        if(!trim($nome) || strlen($nome) < 2){
            throw new InvalidArgumentException('nome inválido');
        }
        $this->nome = $nome;
    }

    // jsonSerialize sem a senha
    public function jsonSerialize(): mixed
    {
        return [
            "id"    => $this->id,
            "login" => $this->login,
            "nome"  => $this->nome
        ];
    }
}