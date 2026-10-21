<?php
class ControladorAuth extends ControladorGeral {

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_set_cookie_params([
                'httponly' => true,
                'samesite' => 'Lax',
                // 'secure' => true, // ative em produção com HTTPS
            ]);
            session_start();
        }
    }

    // /api/cadastro
    public function cadastro() {
        $d     = $this->receiveJSON();
        $nome  = trim($d['nome'] ?? '');
        $login = strtolower(trim($d['login'] ?? ''));
        $senha = $d['senha'] ?? '';
        
        $usuario = new Usuario();
        $treinador = new Treinador();

        try {
            $usuario->nome  = $nome;
            $usuario->login = $login;
            $usuario->senha = $senha; // o model valida e faz o hash
            if($usuario->findByLogin($usuario->login)){
                throw new InvalidArgumentException("Login está em uso");
            }
            $usuario->save();

            $treinador->usuario = $usuario->id;
            $treinador->save();
        } catch (InvalidArgumentException $e) {
            error_log($e->getMessage());
            $this->responseError($e->getMessage(), 400); // senha fraca ou login inválido

        } catch (Exception $e){
            error_log($e->getMessage());
            $this->responseError($e->getMessage(), 500);
        }

        session_regenerate_id(true);
        $_SESSION['usuario_id']   = $usuario->id;
        $_SESSION['usuario_nome'] = $usuario->nome;

        $this->responseJSON([
            'ok'    => true,
            'id'    => $usuario->id,
            'treinador' => $treinador->id,
            'nome'  => $usuario->nome,
            'login' => $usuario->login,
        ]);

        LogUsuario::save($usuario->id, "CADASTRO", "O usuario {$usuario->login} se cadastrou no sistema");
    }

    // api/login
    public function login() {
        $d     = $this->receiveJSON();
        $login = strtolower(trim($d['login'] ?? ''));
        $senha = $d['senha'] ?? '';

        $user = Usuario::findByLogin($login);

        if (!$user || !password_verify($senha, $user->senha)) {
            $this->responseError('Login ou senha incorretos.', 400); //login ou senha incorretos é 400(bad request)
            return;
        }

        $treinador = Treinador::findByUsuario($user->id);
        session_regenerate_id(true);
        $_SESSION['usuario_id']   = $user->id;
        $_SESSION['usuario_nome'] = $user->nome;
        $_SESSION['treinador'] = $treinador->id;

        $this->responseJSON(['ok' => true, 'nome' => $user->nome, 'login' => $user->login]);
        LogUsuario::save($user->id, "LOGIN", "O usuario {$user->login} se logou no sistema");
    }

    // api/me
    public function me() { // consulta sessão: tem alguém logado agora?
        if (empty($_SESSION['usuario_id'])) {
            $this->responseError('Rota não encontrada', 404); //evitar usar 401 para não expor a rota
            return;
        }
        $id = $_SESSION['usuario_id'];
        $usuario = Usuario::find($id);
        $treinador = Treinador::findByUsuario($usuario->id);
        $this->responseJSON([
            'ok' => true, 
            'nome' => $usuario->nome,
            'treinador' => $treinador->id,
            'login' => $usuario->login 
        ]);
    }

    // api/logout
    public function logout() {
        LogUsuario::save($_SESSION['usuario_id'] ?? null, "LOGOUT", "O usuario {$_SESSION['usuario_nome']} se deslogou do sistema");
        $_SESSION = [];
        session_destroy();
        $this->responseJSON(['ok' => true]);
    }
}