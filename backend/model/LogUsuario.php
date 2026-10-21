<?php 

class LogUsuario extends ModelGeral {
    
    public static function save($usuario, $acao, $mensagem){
        $sql = "INSERT INTO log_usuario(usuario_id, acao, mensagem) 
                VALUES(:usuario, :acao, :mensagem)";
        $stmt = self::getPDO()->prepare($sql);
        $stmt->bindParam(':usuario', $usuario);
        $stmt->bindParam(':acao', $acao);
        $stmt->bindParam(':mensagem', $mensagem);
        $stmt->execute();
    }
}