<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Auth extends BaseController
{
    public function index()
    {
        if (session()->get('is_logged_in')) {
            $role = session()->get('role');
            return redirect()->to('/' . $role . '/dashboard');
        }

        return view('auth/login');
    }

    public function login()
    {
        $session = session();
        $model = new UserModel();

        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');

        $user = $model->where('username', $username)->first();

        if ($user) {
            if (password_verify($password, $user['password'])) {
                $sessData = [
                    'id'            => $user['id'],
                    'nama_lengkap'  => $user['nama_lengkap'],
                    'username'      => $user['username'],
                    'role'          => $user['role'],
                    'foto'          => $user['foto'],
                    'is_logged_in'  => true
                ];
                $session->set($sessData);

                return redirect()->to('/' . $user['role'] . '/dashboard');
            } else {
                $session->setFlashdata('error', 'Password salah.');
                return redirect()->to('/auth');
            }
        } else {
            $session->setFlashdata('error', 'Username tidak ditemukan.');
            return redirect()->to('/auth');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/auth');
    }
}