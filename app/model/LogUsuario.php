<?php 

class LogUsuario extends ModelGeral {
    protected int $usuario;
    protected string $mensagem;

    public static function save($usuario, $mensagem){
        $sql = "INSERT INTO log_usuario(usuario_id, mensagem) 
                VALUES(:usuario,  :mensagem)";
        $stmt = self::getPDO()->prepare($sql);
        $stmt->bindParam(':usuario', $usuario);
        $stmt->bindParam(':mensagem', $mensagem);
        $stmt->execute();
    }
}