<?php
declare(strict_types=1);

class AuthController extends Controller
{
    public function showLogin(): void
    {
        if (isset($_SESSION['user'])) {
            $this->redirect('/');
        }
        $this->view('auth/login');
    }

    public function login(): void
    {
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';
        $user = User::findByUsername($username);
        if (!$user || !password_verify($password, $user['password'])) {
            $this->view('auth/login', ['error' => 'Invalid credentials']);
            return;
        }
        $_SESSION['user'] = [
            'id' => (int)$user['id'],
            'username' => $user['username'],
            'role' => $user['role'],
            'name' => $user['name'],
            'email' => $user['email'],
            'address' => $user['address'],
            'login_hours_enabled' => (int)$user['login_hours_enabled'] === 1,
        ];
        $this->redirect('/');
    }

    public function logout(): void
    {
        session_destroy();
        $this->redirect('/login');
    }
}

