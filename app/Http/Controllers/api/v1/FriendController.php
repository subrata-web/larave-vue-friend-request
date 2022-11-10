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

    /**
     * get list of friends of my friend list and my friend list depends on params
     * @param int $id
     * @return array|json
     */
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

    /**
     * add friend/friend request
     * @param int friend_id
     * @return array|json
     */
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

    /**
     * remove friend from my network
     * @param int friend_id
     * @return array|json
     */
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

    /**
     * friend request accept or delete friend request
     * @param int friend_id
     * @return array|json
     */
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

    /**
     * get list of users/friends, wheather the user/friend is my network or not. to send the friend request
     * @param null
     * @param Request
     * @return array|json
     */
    public function getList(Request $request)
    {
        try {
            $name = $request->has('name') ? $request->get('name') : null;
            $id = auth()->check() ? auth()->user()->id : null;
            $list = $this->friendService->getAllFriends($id, $name);
            return $this->responseJson(false, $list['msg'], null, $list['payload']);
        } catch (\Exception $ex) {
            $message = $ex->getMessage();
            if (env('APP_ENV') === "production") {
                $message = 'Something went wrong.';
            }
            return $this->responseJson(true, $message);
        }
    }
}