<?php
declare(strict_types=1);

class DashboardController extends Controller
{
    public function index(): void
    {
        if (!isset($_SESSION['user'])) {
            $this->redirect('/login');
        }
        $role = $_SESSION['user']['role'];
        if ($role === 'admin') {
            $this->view('admin/dashboard');
            return;
        }
        if ($role === 'staff') {
            $this->view('staff/dashboard');
            return;
        }
        $this->view('client/dashboard');
    }
}

