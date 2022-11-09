<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = "user_api";
    protected $primaryKey = "id_user_api";
    protected $allowedFields = ["user_api", "password_api", "email_instansi", "nama_penanggung_jawab", "nama_instansi", "token_api", "secret_api", "status"];
    protected $useTimestamps = false;

    
      
}