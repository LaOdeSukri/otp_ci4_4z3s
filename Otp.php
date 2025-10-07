<?php

namespace App\Config;

use CodeIgniter\Config\BaseConfig;

class Otp extends BaseConfig
{
    public string $mode = 'log'; // 'email' untuk kirim via email, 'log' untuk testing
    public int $expiryMinutes = 5; // OTP valid 5 menit
    public int $resendDelaySeconds = 60; // Batas resend OTP
}
