<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class RoleAuth implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();

        if (!$session->get('is_logged_in')) {
            return redirect()->to('/auth')->with('error', 'Silakan login terlebih dahulu.');
        }

        if (!empty($arguments)) {
            $requiredRole = $arguments[0];
            $userRole = $session->get('role');

            if ($userRole != $requiredRole) {
                switch ($userRole) {
                    case 'admin':
                        return redirect()->to('/admin/dashboard');
                    case 'walas':
                        return redirect()->to('/walas/dashboard');
                    case 'siswa':
                        return redirect()->to('/siswa/dashboard');
                }
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}