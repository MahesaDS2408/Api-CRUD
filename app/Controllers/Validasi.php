<?php

namespace App\Controllers;

use App\Models\MenaraModel;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
class Validasi extends ResourceController
{
    // use ResponseTrait;

    // login terlebih dahulu
    public function login()
    {
        $model = new MenaraModel();
        $data = [
            'nama_site' => $this->request->getVar('nama_site'),
            'alamat'  => $this->request->getVar('alamat'),
        ];
        echo $data['nama_site'];
        // $model->insert($data);
        // $response = [
        //     'status'   => 201,
        //     'error'    => null,
        //     'messages' => [
        //         'success' => 'Data produk berhasil ditambahkan.'
        //     ]
        // ];
        // return $this->respondCreated($response);
    }
}
