<?php 

class LogUsuario {
    private static $pdo;    
    private ?int $id = null;

    private int $usuario_id;
    private string $mensagem;

    public function __get(string $nome)
    {
        return $this->$nome;
    }

    public function __set(string $nome, $valor)
    {
        $this->$nome = $valor;
    }

    private static function getPDO()
    {
        if (self::$pdo === null) {
            self::$pdo = Conexao::getPDO();
        }

        return self::$pdo;
    }

    public static function salvar($usuario_id, $mensagem){
        $sql = "INSERT INTO log_usuario(usuario_id, mensagem) 
                VALUES(:usuario,  :mensagem)";
        $stmt = self::getPDO()->prepare($sql);
        $stmt->bindParam(':usuario', $usuario_id);
        $stmt->bindParam(':mensagem', $mensagem);
        $stmt->execute();
    }
}