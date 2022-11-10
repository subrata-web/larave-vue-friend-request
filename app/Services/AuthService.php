<?php 

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthService {

    protected $userModel;

    public function __construct(User $user)
    {
        $this->userModel = $user;
    }

    public function doLogin($values = [])
    {
        $resp = ['success' => false, 'payload' => null];

        if (Auth::attempt($values)) {
            $authUser = Auth::user();
            $resp['success'] = true;
            $resp['payload'] = [
                'token' => $authUser->createToken('codelogicX')->plainTextToken,
                'user' => $authUser
            ];
        }
        return $resp;
    }

    public function doRegister($values = [])
    {
        $resp = ['success' => false, 'payload' => null];
        if (is_array($values) && !empty($values)) {
            $values['password'] = bcrypt($values['password']);
            $user = $this->userModel->create($values);
            $resp['success'] = true;
            $resp['payload'] = $user;
        }
        return $resp;
    }
}