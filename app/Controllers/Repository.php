<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use Config\Database;
use CodeIgniter\HTTP\ResponseInterface;

class Repository extends BaseController
{
    private function currentUser(): ?array
    {
        $id = (int) (
            session()->get('user_id')
            ?: session()->get('id')
        );

        if ($id <= 0) {
            return null;
        }

        $db = Database::connect();

        $user = $db->table('users')
            ->select('users.id, users.name, users.sub_wilayah_id,
                      users.is_active, roles.name AS role_name')
            ->join('roles', 'roles.id = users.role_id')
            ->where('users.id', $id)
            ->get()
            ->getRowArray();

        if (!$user || (int) $user['is_active'] !== 1) {
            return null;
        }

        if (!in_array($user['role_name'], ['Admin', 'Koordinator'], true)) {
            return null;
        }

        if (
            $user['role_name'] === 'Koordinator'
            && empty($user['sub_wilayah_id'])
        ) {
            return null;
        }

        return $user;
    }

    private function storagePath(): string
    {
        return WRITEPATH . 'uploads/repository/';
    }

    public function index()
    {
        $user = $this->currentUser();
        if (!$user) return redirect()->to(site_url('login'));
        $db = Database::connect();
        $isAdmin = $user['role_name'] === 'Admin';
        $wilayahList = $db->table('sub_wilayah')->orderBy('id', 'ASC')->get()->getResultArray();
        $selected = (int) $this->request->getGet('sub_wilayah');
        if (!$isAdmin) $selected = (int) $user['sub_wilayah_id'];
        $allowedIds = array_map(static fn($w) => (int) $w['id'], $wilayahList);
        if ($selected && !in_array($selected, $allowedIds, true)) {
            return $this->response->setStatusCode(404)->setBody('Sub Wilayah tidak ditemukan.');
        }
        $keyword = trim((string) $this->request->getGet('q'));
        $query = $db->table('repository_files rf')
            ->select('rf.*, sw.name AS wilayah_name, u.name AS uploader_name, ms.tahun, ms.nomor AS masa_sidang_nomor')
            ->join('sub_wilayah sw', 'sw.id = rf.sub_wilayah_id')
            ->join('users u', 'u.id = rf.uploaded_by')
            ->join('masa_sidang ms', 'ms.id = rf.masa_sidang_id');
        if (!$isAdmin) $query->where('rf.sub_wilayah_id', (int) $user['sub_wilayah_id']);
        if ($selected) $query->where('rf.sub_wilayah_id', $selected);
        if ($keyword !== '') $query->like('rf.original_name', $keyword);
        $files = $query->orderBy('rf.id', 'DESC')->limit(200)->get()->getResultArray();
        $countsQuery = $db->table('repository_files')->select('sub_wilayah_id, COUNT(*) AS total')->groupBy('sub_wilayah_id');
        if (!$isAdmin) $countsQuery->where('sub_wilayah_id', (int) $user['sub_wilayah_id']);
        $counts = [];
        foreach ($countsQuery->get()->getResultArray() as $row) $counts[(int) $row['sub_wilayah_id']] = (int) $row['total'];
        return view('repository/index', compact('user', 'isAdmin', 'wilayahList', 'selected', 'keyword', 'files', 'counts'));
    }

    public function download($id)
    {
        $user = $this->currentUser();

        if (!$user) {
            return $this->response
                ->setStatusCode(403)
                ->setBody('Akses ditolak.');
        }

        $db = Database::connect();

        $query = $db->table('repository_files')
            ->where('id', (int) $id);

        if ($user['role_name'] !== 'Admin') {
            $query->where(
                'sub_wilayah_id',
                (int) $user['sub_wilayah_id']
            );
        }

        $file = $query->get()->getRowArray();

        if (!$file) {
            return $this->response
                ->setStatusCode(404)
                ->setBody('Dokumen tidak ditemukan.');
        }

        $path = $this->storagePath() . basename($file['stored_name']);

        if (!is_file($path)) {
            return $this->response
                ->setStatusCode(404)
                ->setBody('File fisik tidak ditemukan.');
        }

        $name = str_replace(
            ["\r", "\n", '"', '\\'],
            '',
            $file['original_name']
        );

        return $this->response
            ->download($path, null)
            ->setFileName($name);
    }

public function preview($id)
{
    $user = $this->currentUser();

    if (!$user) {
        return $this->response
            ->setStatusCode(403)
            ->setBody('Akses ditolak.');
    }

    $db = \Config\Database::connect();

    $query = $db->table('repository_files')
        ->where('id', (int) $id);

    if ($user['role_name'] !== 'Admin') {
        $query->where(
            'sub_wilayah_id',
            (int) $user['sub_wilayah_id']
        );
    }

    $file = $query->get()->getRowArray();

    if (!$file) {
        return $this->response
            ->setStatusCode(404)
            ->setBody('Dokumen tidak ditemukan.');
    }

    $allowedMime = [
        'application/pdf',
        'image/jpeg',
        'image/png',
    ];

    if (!in_array($file['mime_type'], $allowedMime, true)) {
        return $this->response
            ->setStatusCode(415)
            ->setBody('Format ini tidak mendukung preview.');
    }

    $path = $this->storagePath()
        . basename($file['stored_name']);

    if (!is_file($path)) {
        return $this->response
            ->setStatusCode(404)
            ->setBody('File tidak ditemukan di penyimpanan.');
    }

    $name = str_replace(["\r", "\n", '"', "\\"], '', (string) $file['original_name']);
   return $this->response
    ->setStatusCode(200)
    ->setHeader('Content-Type', 'application/pdf')
    ->setHeader('Content-Disposition', 'inline; filename="preview.pdf"')
    ->setHeader('X-Content-Type-Options', 'nosniff')
    ->setHeader('Content-Security-Policy', "default-src 'none'; sandbox")
    ->setHeader('Cache-Control', 'private, no-store')
    ->setBody(file_get_contents($path));
}

}
