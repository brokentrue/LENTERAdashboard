<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Database;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Pastikan pengguna sudah login.
        if (
            !session()->get('is_logged_in') ||
            !session()->get('user_id')
        ) {
            return redirect()->to('/login');
        }

        $userId = (int) session()->get('user_id');

        // Periksa ulang status akun dari database.
        $user = Database::connect()
            ->table('users')
            ->select('id, is_active')
            ->where('id', $userId)
            ->get()
            ->getRowArray();

        // Tolak sesi jika akun dihapus atau dinonaktifkan.
        if (!$user || (int) $user['is_active'] !== 1) {
            session()->destroy();

            return redirect()->to('/login')
                ->with('error', 'Sesi berakhir. Silakan login kembali.');
        }
    }

    public function after(
        RequestInterface $request,
        ResponseInterface $response,
        $arguments = null
    ) {
        // Tidak diperlukan proses tambahan.
    }
}
