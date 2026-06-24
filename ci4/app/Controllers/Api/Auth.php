<?php
namespace App\Controllers\Api;
use CodeIgniter\RESTful\ResourceController;
use App\Models\UserModel;

class Auth extends ResourceController
{
    protected $format = 'json';

    public function login()
    {
        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');
        $model = new UserModel();

        $user = $model->where('username', $username)
                      ->orWhere('useremail', $username)
                      ->first();

        if ($user) {
            if ($password === $user['userpassword'] || 
                password_verify($password, $user['userpassword'])) {
                return $this->respond([
                    'status' => 200,
                    'error' => null,
                    'messages' => 'Login Berhasil',
                    'data' => [
                        'id' => $user['id'],
                        'username' => $user['username'],
                        'token' => base64_encode("TOKEN-SECRET-" . $user['username'])
                    ]
                ], 200);
            }
        }

        return $this->failUnauthorized('Username atau Password yang Anda masukkan salah.');
    }
}