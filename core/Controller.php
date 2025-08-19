<?php
declare(strict_types=1);

class Controller
{
    protected function view(string $template, array $data = []): void
    {
        extract($data, EXTR_OVERWRITE);
        $viewFile = __DIR__ . '/../views/' . $template . '.php';
        $layoutFile = __DIR__ . '/../views/layout.php';
        ob_start();
        if (file_exists($viewFile)) {
            require $viewFile;
        } else {
            echo "View not found: " . htmlspecialchars($template);
        }
        $content = ob_get_clean();
        require $layoutFile;
    }

    protected function redirect(string $path): void
    {
        header('Location: ' . $path);
        exit;
    }

    protected function requireRole(array $roles): void
    {
        if (!isset($_SESSION['user'])) {
            $this->redirect('/login');
        }
        $user = $_SESSION['user'];
        if (!in_array($user['role'], $roles, true)) {
            http_response_code(403);
            echo 'Forbidden';
            exit;
        }
    }
}

