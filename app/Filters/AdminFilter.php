<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AdminFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (!session()->get('is_logged_in')) {
            return redirect()->to('/login');
        }

        $userId = session()->get('user_id');

        $user = db_connect()
            ->table('users')
            ->select('users.id, users.is_active, roles.name AS role_name')
            ->join('roles', 'roles.id = users.role_id')
            ->where('users.id', $userId)
            ->get()
            ->getRowArray();

        if (!$user || (int) $user['is_active'] !== 1) {
            session()->destroy();
            return redirect()->to('/login');
        }

        if ($user['role_name'] !== 'Admin') {
            return service('response')
                ->setStatusCode(403)
                ->setBody('Akses ditolak. Halaman ini hanya untuk Admin.');
        }
    }

    public function after(
        RequestInterface $request,
        ResponseInterface $response,
        $arguments = null
    ) {
        //
    }
}
