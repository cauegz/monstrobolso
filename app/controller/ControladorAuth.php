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

    public function cadastro() {
        $d     = $this->receiveJSON();
        $nome  = trim($d['nome'] ?? '');
        $login = strtolower(trim($d['login'] ?? ''));
        $senha = $d['senha'] ?? '';

        if ($nome === '') {
            $this->responseError('Informe o nome.', 422);
            return;
        }
        if (!preg_match('/^[a-z0-9_.]{3,30}$/', $login)) {
            $this->responseError('Login inválido. Use 3 a 30 caracteres: letras, números, "_" ou ".".', 422);
            return;
        }

        try {
            $usuario = new Usuario();
            $usuario->nome  = $nome;
            $usuario->login = $login;
            $usuario->senha = $senha; // o model valida e faz o hash
            $usuario->save();
        } catch (InvalidArgumentException $e) {
            $this->responseError($e->getMessage(), 422); // senha fraca
            return;
        } catch (PDOException $e) {
            if ($e->getCode() === '23505') { // unique_violation
                $this->responseError('Login já está em uso.', 409);
                return;
            }
            error_log($e->getMessage());
            $this->responseError('Erro interno.', 500);
            return;
        }

        $this->responseJSON([
            'ok'    => true,
            'id'    => $usuario->id,
            'nome'  => $usuario->nome,
            'login' => $usuario->login,
        ]);
    }

    public function login() {
        $d     = $this->receiveJSON();
        $login = strtolower(trim($d['login'] ?? ''));
        $senha = $d['senha'] ?? '';

        $user = Usuario::findByLogin($login);

        if (!$user || !password_verify($senha, $user->senha)) {
            $this->responseError('Login ou senha incorretos.', 400); //login ou senha incorretos é 400(bad request)
            return;
        }

        session_regenerate_id(true);
        $_SESSION['usuario_id']   = $user->id;
        $_SESSION['usuario_nome'] = $user->nome;

        $this->responseJSON(['ok' => true, 'nome' => $user->nome, 'login' => $user->login]);
    }

    public function me() { // consulta sessão: tem alguém logado agora?
        if (empty($_SESSION['usuario_id'])) {
            $this->responseError('Rota não encontrada', 404); //evitar usar 401 para não expor a rota
            return;
        }
        $id = $_SESSION['usuario_id'];
        $usuario = Usuario::find($id);
        $this->responseJSON([
            'ok' => true, 
            'nome' => $usuario->nome,
            'login' => $usuario->login 
        ]);
    }

    public function logout() {
        $_SESSION = [];
        session_destroy();
        $this->responseJSON(['ok' => true]);
    }
}