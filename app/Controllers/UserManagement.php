<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class UserManagement extends BaseController
{
    public function index()
    {
        $db = db_connect();

        $users = $db->table('users')
            ->select(
                'users.id, users.name, users.username,
                 users.role_id, users.sub_wilayah_id,
                 users.is_active, users.created_at,
                 roles.name AS role_name,
                 sub_wilayah.name AS sub_wilayah_name'
            )
            ->join('roles', 'roles.id = users.role_id')
            ->join(
                'sub_wilayah',
                'sub_wilayah.id = users.sub_wilayah_id',
                'left'
            )
            ->orderBy('users.created_at', 'DESC')
            ->get()
            ->getResultArray();

        $wilayah = $db->table('sub_wilayah')
            ->select('id, name')
            ->orderBy('id', 'ASC')
            ->get()
            ->getResultArray();

        return view('admin/users/index', [
            'title'   => 'Manajemen Pengguna LENTERA',
            'users'   => $users,
            'wilayah' => $wilayah,
        ]);
    }

    public function approve($id)
    {
        $db = db_connect();

        $user = $db->table('users')
            ->select('id, role_id, is_active')
            ->where('id', (int) $id)
            ->get()
            ->getRowArray();

        if (!$user) {
            return redirect()->to('/admin/users')
                ->with('error', 'Pengguna tidak ditemukan.');
        }

        // Hanya akun dengan role User yang boleh
        // ditetapkan menjadi Koordinator.
        $userRole = $db->table('roles')
            ->where('name', 'User')
            ->get()
            ->getRowArray();

        $koordinatorRole = $db->table('roles')
            ->where('name', 'Koordinator')
            ->get()
            ->getRowArray();

        if (!$userRole || !$koordinatorRole) {
            return redirect()->to('/admin/users')
                ->with('error', 'Konfigurasi role belum tersedia.');
        }

        if ((int) $user['role_id'] !== (int) $userRole['id']) {
            return redirect()->to('/admin/users')
                ->with('error', 'Akun ini tidak dapat ditetapkan melalui proses ini.');
        }

        $wilayahId = filter_var(
            $this->request->getPost('sub_wilayah_id'),
            FILTER_VALIDATE_INT
        );

        if (!$wilayahId) {
            return redirect()->to('/admin/users')
                ->with('error', 'Silakan pilih Sub Wilayah.');
        }

        $wilayah = $db->table('sub_wilayah')
            ->where('id', $wilayahId)
            ->get()
            ->getRowArray();

        if (!$wilayah) {
            return redirect()->to('/admin/users')
                ->with('error', 'Sub Wilayah tidak valid.');
        }

        $userModel = new UserModel();

        $updated = $userModel->update((int) $id, [
            'role_id'        => (int) $koordinatorRole['id'],
            'sub_wilayah_id' => (int) $wilayahId,
            'is_active'      => 1,
        ]);

        if (!$updated) {
            return redirect()->to('/admin/users')
                ->with('error', 'Penetapan Koordinator gagal.');
        }

        return redirect()->to('/admin/users')
            ->with(
                'success',
                'Akun berhasil ditetapkan sebagai Koordinator ' .
                $wilayah['name'] . '.'
            );
    }
}
