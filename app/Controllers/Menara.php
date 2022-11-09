<?php

namespace App\Controllers;

use App\Models\MenaraModel;
use App\Models\UserModel;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
class Menara extends BaseController
{
    use ResponseTrait;

	// all users
    // public function index()
    // {
    //     $model = new MenaraModel();
    //     $data['Respons'] = $model->orderBy('id_site', 'DESC')->findAll();
    //     return $this->respond($data);
    // }
    public function get_data()
    {
        //api GET

        // $this->userModel = new UserModel();
		// $user = $this->userModel->where('user_api', $data['username'])->first();


		$request = service('request');
        $data = [
            'token' => $request->header('Menara-Token'),
            'secret'  => $request->header('Menara-Secret'),
        ];
        $token = preg_replace("/Menara-Token: /","", $data['token']);
        $secret = preg_replace("/Menara-Secret: /","", $data['secret']);
        $this->userModel = new UserModel();
		$valid = $this->userModel->where('token_api', $token)->first();
        if($valid){
            if($valid['status'] == 'aktif'){

                if($valid['secret_api'] == $secret){
                    $model = new MenaraModel();
                    $respons['success'] = true;
                    $respons['data'] = $model->get_menara();
                    $respons['metadata'] = [
                        'message' => "OK.",
                        'code' => "200"
                    ];
                    return $this->respond($respons);
                }else{
                    $respons['success'] = false;
                    $respons['metadata'] = [
                        'message' => "APermission Denied."
                    ];
                    return $this->respond($respons);
                }
            }else{
                // tidak aktif
                $respons['success'] = false;
                $respons['metadata'] = [
                    'message' => "APermission Denied."
                ];
                return $this->respond($respons);
            }
        }else{
            $respons['success'] = false;
            $respons['metadata'] = [
                'message' => "APermission Denied."
            ];
            return $this->respond($respons);
        }        
    }
}
