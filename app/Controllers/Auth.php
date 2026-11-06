<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Auth extends BaseController
{
    public function index()
    {
        if (session()->get('is_logged_in')) {
            return redirect()->to('/dashboard');
        }

        return view('auth/login');
    }

    public function login()
    {
        $rules = [
            'username' => 'required',
            'password' => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->to('/login')
                ->with('error', 'Username dan password wajib diisi.');
        }

        $username = trim((string) $this->request->getPost('username'));
        $password = (string) $this->request->getPost('password');

        $userModel = new UserModel();

        $user = $userModel
            ->where('username', $username)
            ->first();

        if (!$user || !password_verify($password, $user['password'])) {
            return redirect()->to('/login')
                ->with('error', 'Username atau password salah.');
        }

        if ((int) $user['is_active'] !== 1) {
            return redirect()->to('/login')
                ->with('error', 'Akun belum disetujui Admin.');
        }

        // Mencegah session fixation
        session()->regenerate(true);

        session()->set([
            'user_id'      => $user['id'],
            'username'     => $user['username'],
            'name'         => $user['name'],
            'role_id'      => $user['role_id'],
            'is_logged_in' => true,
        ]);

        return redirect()->to('/dashboard');
    }

    public function logout()
    {
        session()->destroy();

        return redirect()->to('/login');
    }

    public function register()
    {
        if (session()->get('is_logged_in')) {
            return redirect()->to('/dashboard');
        }

        return view('auth/register');
    }

    public function storeRegister()
    {
        $rules = [
            'name' => 'required|min_length[3]|max_length[100]',
            'username' => 'required|alpha_numeric|min_length[4]|max_length[50]|is_unique[users.username]',
            'password' => 'required|min_length[12]|max_length[72]',
            'password_confirm' => 'required|matches[password]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->to('/register')
                ->with('errors', $this->validator->getErrors());
        }

        $db = db_connect();

        $role = $db->table('roles')
            ->where('name', 'User')
            ->get()
            ->getRowArray();

        if (!$role) {
            return redirect()->to('/register')
                ->with('error', 'Role pendaftaran belum tersedia.');
        }

        $userModel = new UserModel();

        $saved = $userModel->insert([
            'name' => trim((string) $this->request->getPost('name')),
            'username' => trim((string) $this->request->getPost('username')),
            'password' => password_hash(
                (string) $this->request->getPost('password'),
                PASSWORD_DEFAULT
            ),
            'role_id' => $role['id'],
            'is_active' => 0,
        ]);

        if ($saved === false) {
            return redirect()->to('/register')
                ->with('error', 'Registrasi gagal. Silakan coba kembali.');
        }

        return redirect()->to('/login')
            ->with(
                'success',
                'Registrasi berhasil. Akun menunggu persetujuan Admin.'
            );
    }
}
