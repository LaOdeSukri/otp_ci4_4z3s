<?php

use App\Config\Otp;

if (!function_exists('generateOtp')) {
    function generateOtp($length = 6)
    {
        return str_pad(random_int(0, pow(10, $length) - 1), $length, '0', STR_PAD_LEFT);
    }
}

if (!function_exists('logOtp')) {
    function logOtp($email, $otp)
    {
        $config = new Otp();
        if ($config->mode === 'log') {
            $logFile = WRITEPATH . 'logs/otp_log.txt';
            $entry = date('Y-m-d H:i:s') . " - {$email} => {$otp}\n";
            file_put_contents($logFile, $entry, FILE_APPEND);
        }
    }
}
