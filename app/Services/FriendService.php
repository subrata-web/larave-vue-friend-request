<?php 

namespace App\Services;

use App\Models\Friend;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class FriendService {

    protected $userModel;
    protected $friendModel;

    public function __construct(User $user, Friend $friend)
    {
        $this->userModel = $user;
        $this->friendModel = $friend;
    }

    public function getFriends($id = null)
    {
        $resp = ['success' => false, 'payload' => null];
        if (isset($id)) {
            $result = $this->userModel->with(['friends' => function ($query) {
                $query->where('accepted', '=', true)->with('user2');
            }])->find($id);
            
            if ($result) {
                $resp['success'] = true;
                $resp['payload'] = $result;
            }
        }
        return $resp;
    }

    public function store($id = null, $friend_id = null)
    {
        $resp = ['success' => false, 'payload' => null];
        $result = $this->friendModel->create([
            'user_id' => $id,
            'friend_id' => $friend_id
        ]);
        if ($result) {
            $resp['success'] = true;
            $resp['payload'] = $result;
        }
        return $resp;
    }

    public function remove( $friend_id = null)
    {
        $friend = $this->friendModel->all()->where('user_id', '=', auth()->user()->id)->where('friend_id', '=', $friend_id)->first();
        if ($friend) {
            $friend->delete();
            return ['success' => true, 'payload' => $friend];
        }
        return ['success' => false, 'payload' => null];
    }

    public function requestFriend($user_id = null, $isRequest = false) 
    {
        $user = $this->friendModel->all()->where('friend_id', '=', auth()->user()->id)->where('user_id', '=', $user_id)->first();
        if ($user && $isRequest) {
            $user->accepted = true;
            $user->save();
            return [
                'success' => true,
                'msg' => "You are now friends."
            ];
        }
        if  ($user) {
            $user->delete();
            return [
                'success' => true,
                'msg' => "You cancelled the friend request."
            ];
        }
        return [
            'success' => false,
            'msg' => "Not found"
        ];
    }

    public function getAllFriends($id = null)
    {
        $query = $this->userModel->query();
        if ($id) {
            $query->where('id', '!=', $id);
        }
        $results = $query->orderBy('name', 'ASC')->get()->toArray();
        return ['msg' => 'Success.', 'payload' => $results];
    }
}