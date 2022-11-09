<?php

namespace App\Controllers;

use App\Models\MenaraModel;
use App\Models\UserModel;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
class Auth extends BaseController
{
    use ResponseTrait;
    private function hash_password($pass_user){
        return password_hash($pass_user, PASSWORD_BCRYPT);
    }
    public function test_password()
    {
        $pass = $this->hash_password('123');
        echo $pass;
    }
    public function hasil_test_password()
    {
        $hasil = "$2y$10$9/AB.j8gxS/viDBg.TJw8ONpf5X4Z6hodffJ/guhjun4eBbFYyqLK"; // password di database
        $password = "123"; // password inputan
        if(password_verify($password,$hasil)){//dibandingkan
            echo 'Selamat , Password Valid !';
        }else{
            echo 'Maaf , Password Tidak Valid';
        }
    }
    public function create_token()
    {
        
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $char_token = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
 
			function generate_token($input, $strength = 16) {
				$input_length = strlen($input);
				$random_string = '';
				for($i = 0; $i < $strength; $i++) {
					$random_character = $input[mt_rand(0, $input_length - 1)];
					$random_string .= $random_character;
				}
			
				return $random_string;
			}
			
			// Output: Jp8iVNhZXhUdSlPi1sMNF7hOfmEWYl2UIMO9YqA4faJmS52iXdtlA3YyCfSlAbLYzjr0mzCWWQ7M8AgqDn2aumHoamsUtjZNhBfU
			$token =  generate_token($char_token, 40);
            echo $token;
    }
    public function create_secret()
    {
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $char_token = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
 
			function generate_secret($input, $strength = 16) {
				$input_length = strlen($input);
				$random_string = '';
				for($i = 0; $i < $strength; $i++) {
					$random_character = $input[mt_rand(0, $input_length - 1)];
					$random_string .= $random_character;
				}
			
				return $random_string;
			}
			
			// Output: Jp8iVNhZXhUdSlPi1sMNF7hOfmEWYl2UIMO9YqA4faJmS52iXdtlA3YyCfSlAbLYzjr0mzCWWQ7M8AgqDn2aumHoamsUtjZNhBfU
			$token =  generate_secret($permitted_chars, 300);
            echo $token;
    }
	public function login()
	{
        // di gunakan untuk login
        
		$data = [
            'username' => $this->request->getVar('username'),
            'password'  => $this->request->getVar('password'),
        ];
        $this->userModel = new UserModel();
		$user = $this->userModel->where('user_api', $data['username'])->first();
        if($user){
            if($user['status'] == 'aktif'){

                if(password_verify($data['password'],$user['password_api'])){
                    $respons['success'] = true;
                    $respons['data'] = [
                        'token' => $user['token_api'],
                        'secret' => $user['secret_api']
                    ];
                    $respons['metadata'] = [
                        'message' => "Authentication Successfully.",
                        'code' => "200"
                    ];
                    return $this->respond($respons);
                }else{
                    // Password Salah
                    $respons['success'] = false;
                    $respons['metadata'] = [
                        'message' => "Authentication Failed."
                    ];
                    return $this->respond($respons);
                }

            }else{

                // Akun Mati
                $respons['success'] = false;
                $respons['metadata'] = [
                    'message' => "Permission Denied."
                ];
                return $this->respond($respons);
            }
            
        }else{
             // Akun tidak ada
             $respons['success'] = false;
             $respons['metadata'] = [
                 'message' => "Access Denied."
             ];
             return $this->respond($respons);
        }
        
	}
}
