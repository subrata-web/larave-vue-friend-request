<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\BaseController;
use App\Services\FriendService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FriendController extends BaseController {

    private $friendService;

    public function __construct(FriendService $friendService)
    {
        $this->friendService = $friendService;
    }

    public function showFriends(Request $request)
    {
        try {
            $id = $request->has('id') ? $request->get('id') : auth()->user()->id;
            $friends = $this->friendService->getFriends($id);
            return $this->responseJson(false, "Success", null, $friends['payload']);
        } catch (\Exception $ex) {
            $message = $ex->getMessage();
            if (env('APP_ENV') === "production") {
                $message = 'Something went wrong.';
            }
            return $this->responseJson(true, $message);
        }
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'friend_id' => 'required'
            ]);
            if ($validator->fails()) {
                return $this->responseJson(true, 'Validation failed', $validator->errors());
            }
            $id = auth()->user()->id;
            $friendId = $request->friend_id;
            $res = $this->friendService->store($id, $friendId);
            if ($res['success'] && $res['payload'] != null) {
                return $this->responseJson(false, "Success");
            }
            return $this->responseJson(false, "Something went wrong.");
        } catch (\Exception $ex) {
            $message = $ex->getMessage();
            if (env('APP_ENV') === "production") {
                $message = 'Something went wrong.';
            }
            return $this->responseJson(true, $message);
        }
    }

    public function removeFriend(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'friend_id' => 'required'
            ]);
            if ($validator->fails()) {
                return $this->responseJson(true, 'Validation failed', $validator->errors());
            }
            $friendId = $request->friend_id;
            $res = $this->friendService->remove($friendId);
            if ($res['success'] && $res['payload'] != null) {
                return $this->responseJson(false, "Success");
            }
            return $this->responseJson(false, "Something went wrong.");
        } catch (\Exception $ex) {
            $message = $ex->getMessage();
            if (env('APP_ENV') === "production") {
                $message = 'Something went wrong.';
            }
            return $this->responseJson(true, $message);
        }
    }

    public function requestAC(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'user_id' => 'required',
                'accept' => 'required'
            ]);
            if ($validator->fails()) {
                return $this->responseJson(true, 'Validation failed', $validator->errors());
            }
            $req = $this->friendService->requestFriend($request->user_id, $request->accept);
            return $this->responseJson(false, $req['msg']);
        } catch (\Exception $ex) {
            $message = $ex->getMessage();
            if (env('APP_ENV') === "production") {
                $message = 'Something went wrong.';
            }
            return $this->responseJson(true, $message);
        }
    }
}