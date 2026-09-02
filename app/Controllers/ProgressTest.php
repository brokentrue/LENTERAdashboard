<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Services\ProgressInitializer;

class ProgressTest extends BaseController
{
    public function initialize()
    {
        try {
            $initializer = new ProgressInitializer();

            $result = $initializer->initialize(
                1,
                1
            );

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Progress berhasil diinisialisasi.',
                'result'  => $result,
            ]);

        } catch (\Throwable $e) {

            return $this->response
                ->setStatusCode(500)
                ->setJSON([
                    'success' => false,
                    'error'   => get_class($e),
                    'message' => $e->getMessage(),
                    'file'    => $e->getFile(),
                    'line'    => $e->getLine(),
                    'trace'   => $e->getTraceAsString(),
                ]);
        }
    }
}