<?php

namespace App\Models;

use CodeIgniter\Model;

class MenaraModel extends Model
{
    protected $table = "tb_site";
    protected $primaryKey = "id_site";
    protected $allowedFields = ["nama_site", "longitude", "latitude", "alamat", "nama_kelurahan", "nama_kecamatan"];
    protected $useTimestamps = false;

    public function get_menara()
    {
        return $this->db->table('tb_site')
        ->select('id_site, nama_site, longitude, latitude, alamat, nama_kelurahan, nama_kecamatan')
        ->get()->getResultArray();
    }
      
}