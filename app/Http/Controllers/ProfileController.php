<?php

namespace App\Http\Controllers;

use App\AdminProfile;
use App\Business\ProfileBusiness;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Request;

class ProfileController extends Controller
{
    private $profileBusiness;

    public function __construct(ProfileBusiness $profileBusiness)
    {
        $this->profileBusiness = $profileBusiness;
    }

    protected function index()
    {
        $curent_user = Auth::user();
        $id = $curent_user->id;
        $email = $curent_user->email;

        $curent_user_profile = AdminProfile::where('admin_id', $id)->first();
        $avatar = $curent_user_profile->avatar;
        $full_name = $curent_user_profile->full_name;
        $address = $curent_user_profile->address;
        $phone = $curent_user_profile->phone;
        $memo = $curent_user_profile->memo;

        return view('setting_profile.create', compact(['id', 'email', 'avatar', 'full_name', 'address', 'phone', 'memo']));
    }

    protected function updateProfile(UpdateProfileRequest $request)
    {
        //prepare data
        $data = array();
        $data['id'] = $request->get('id');
        $data['email'] = $request->get('email');
        $data['password'] = $request->get('password');
        $data['full_name'] = $request->get('full_name');
        $data['phone'] = $request->get('phone');
        $data['address'] = $request->get('address');
        $data['memo'] = $request->get('memo');

        //check file avatar
        if ($request->hasFile('avatar')) {
            //move file upload
//            list($url, $file_name) = $this->moveFile($request->file('avatar'));
            $file_name = $this->profileBusiness->moveFile($request->file('avatar'));
            $data['avatar'] = $file_name;
        }
        //update
        $user = $this->profileBusiness->updateUserProfile($data);

        return $user;
    }

}