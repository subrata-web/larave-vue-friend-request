<?php 

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\BaseController;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends BaseController {

    private $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function signin(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required'
            ]);
            if ($validator->fails()) {
                return $this->responseJson(true, 'Validation failed', $validator->errors());
            }
            $values = $request->only('email', 'password');
            $authenticated = $this->authService->doLogin($values);
            if ($authenticated['success'] && $authenticated['payload'] != null) {
                return $this->responseJson(false, "Logged In", null, $authenticated['payload']);
            }
            return $this->responseJson(false, 'Unauthorised');
        } catch (\Exception $ex) {
            $message = $ex->getMessage();
            if (env('APP_ENV') === "production") {
                $message = 'Something went wrong.';
            }
            return $this->responseJson(true, $message);
        }
    }

    public function signup(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required',
                'confirm_password' => 'required|same:password',
            ]);
    
            if ($validator->fails()) {
                return $this->responseJson(true, 'Validation failed', $validator->errors());
            }
    
            $values = $request->only('name', 'email', 'password');
            
            $register = $this->authService->doRegister($values);
            
            if ($register['success']) {
                return $this->responseJson(false, "User created successfully.");
            }
            return $this->responseJson(false, 'User not created.');
        }  catch (\Exception $ex) {
            $message = $ex->getMessage();
            if (env('APP_ENV') === "production") {
                $message = 'Something went wrong.';
            }
            return $this->responseJson(true, $message);
        }
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();
        return $this->responseJson(false, 'Tokens Revoked');
    }
}