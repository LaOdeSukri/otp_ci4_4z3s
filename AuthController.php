<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Backend\UsersModel;

class AuthController extends BaseController
{
    protected $users;

    public function __construct()
    {
        $this->users = new UsersModel();
    }

    public function login()
    {
        return view('auth/login');
    }

    public function doLogin()
    {
        $email = $this->request->getPost('email');
        $user = $this->users->where('email', $email)->first();

        if (!$user) {
            return redirect()->back()->with('error', 'Email tidak terdaftar.');
        }

        $otp = generateOtp();
        $expired = date('Y-m-d H:i:s', strtotime('+5 minutes'));

        $this->users->update($user['id'], [
            'otp_code' => $otp,
            'otp_expired' => $expired
        ]);

        logOtp($email, $otp);

        session()->set('otp_email', $email);

        return redirect()->to('/auth/verify');
    }

    public function verify()
    {
        return view('auth/verify_otp');
    }

    public function doVerify()
    {
        $email = session()->get('otp_email');
        $otp = $this->request->getPost('otp');

        $user = $this->users->where('email', $email)->first();

        if (!$user || $user['otp_code'] !== $otp || strtotime($user['otp_expired']) < time()) {
            return redirect()->back()->with('error', 'OTP salah atau kadaluarsa.');
        }

        // Hapus OTP setelah berhasil
        $this->users->update($user['id'], [
            'otp_code' => null,
            'otp_expired' => null
        ]);

        session()->set('isLoggedIn', true);
        session()->set('userData', $user);

        return redirect()->to('/dashboard');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/auth/login');
    }

    public function dashboard()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/auth/login');
        }

        return view('auth/dashboard', ['user' => session()->get('userData')]);
    }
}
