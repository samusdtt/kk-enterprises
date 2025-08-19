<?php
declare(strict_types=1);

class ProfileController extends Controller
{
    public function showClient(): void
    {
        $this->requireRole(['client']);
        $user = User::findById((int)$_SESSION['user']['id']);
        $this->view('client/profile', compact('user'));
    }

    public function updateClient(): void
    {
        $this->requireRole(['client']);
        $id = (int)$_SESSION['user']['id'];
        User::updateProfile($id, [
            'name' => trim($_POST['name'] ?? ''),
            'email' => trim($_POST['email'] ?? ''),
            'address' => trim($_POST['address'] ?? ''),
        ]);
        $_SESSION['user'] = array_merge($_SESSION['user'], [
            'name' => $_POST['name'] ?? '',
            'email' => $_POST['email'] ?? '',
            'address' => $_POST['address'] ?? '',
        ]);
        $this->redirect('/client/profile');
    }

    public function changePassword(): void
    {
        $this->requireRole(['client', 'staff', 'admin']);
        $id = (int)$_SESSION['user']['id'];
        $new = (string)($_POST['new_password'] ?? '');
        if (strlen($new) < 6) {
            echo 'Password too short';
            return;
        }
        User::changePassword($id, $new);
        $role = $_SESSION['user']['role'];
        $this->redirect($role === 'client' ? '/client/profile' : ($role === 'staff' ? '/staff/profile' : '/admin/clients'));
    }
}

