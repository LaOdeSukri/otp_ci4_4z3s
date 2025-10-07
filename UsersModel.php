<?php

namespace App\Models\Backend;

use CodeIgniter\Model;

class UsersModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'email', 'nama', 'password', 'otp_code', 'otp_expired', 'role', 'is_active'
    ];
    protected $useTimestamps = true;
}
