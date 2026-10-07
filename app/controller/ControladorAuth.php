<?php
class ControladorAuth extends ControladorGeral{
    public function cadastro(){
        extract($this->receiveJSON());

        try{
            $usuario = new Usuario();
            /**@var string $login @var string $nome @var string $senha*/
            $usuario->login = $login;
            $usuario->nome = $nome;
            $usuario->senha = $senha;

            $usuario->save();
        }catch(Exception $e){
            $this->responseError($e->getMessage(), 400);
        }
        $this->responseJSON([
            "ok" => true,
            "mensagem" => "usuário cadastrado com sucesso"
        ]);
    }
}