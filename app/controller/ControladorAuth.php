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
        }
        if (!preg_match('/^[a-z0-9_.]{3,30}$/', $login)) {
            $this->responseError('Login inválido. Use 3 a 30 caracteres: letras, números, "_" ou ".".', 422);
        }
        if (strlen($senha) <= 8) {
            $this->responseError('A senha precisa ter 8+ caracteres.', 422);
        }

        try {
            $usuario = new Usuario();
            $usuario->nome  = $nome;
            $usuario->login = $login;
            $usuario->senha = password_hash($senha, PASSWORD_DEFAULT);
            $usuario->save();
        } catch (PDOException $e) {
            if ($e->getCode() === '23505') { // unique_violation
                $this->responseError('Login já está em uso.', 409);
            }
            error_log($e->getMessage());
            $this->responseError('Erro interno.', 500);
        } catch (Exception $e) {
            error_log($e->getMessage());
            $this->responseError('Não foi possível cadastrar.', 400);
        }

        $this->responseJSON([
            'ok'   => true,
            'id'   => $usuario->id,
            'nome' => $usuario->nome,
            'login' => $usuario->login,
        ], 201);
    }

    public function login() {
        $d    = $this->receiveJSON();
        $login = strtolower(trim($d['login'] ?? ''));
        $senha = $d['senha'] ?? '';

        $stmt = Conexao::getPDO()->prepare(
            'SELECT id, nome, login, senha FROM usuarios WHERE login = ?'
        );
        $stmt->execute([$login]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user || !password_verify($senha, $user['senha'])) {
            $this->responseError('Login ou senha incorretos.', 401);
        }

        session_regenerate_id(true);
        $_SESSION['usuario_id']   = $user['id'];
        $_SESSION['usuario_nome'] = $user['nome'];

        $this->responseJSON(['ok' => true, 'nome' => $user['nome'], 'login' => $user['login']]);
    }

    public function me() { //consulta sessão: tem alguém logado agr?
        if (empty($_SESSION['usuario_id'])) {
            $this->responseError('Não autenticado.', 401);
        }
        $this->responseJSON(['ok' => true, 'nome' => $_SESSION['usuario_nome']]);
    }

    public function logout() {
        $_SESSION = [];
        session_destroy();
        $this->responseJSON(['ok' => true]);
        $this->responseJSON([
            "ok" => true,
            "mensagem" => "usuário cadastrado com sucesso"
        ]);
    }
}