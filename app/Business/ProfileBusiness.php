<?php
namespace App\Business;

use App\Admin;
use App\AdminProfile;
use App\Traits\UploadFileHelper;

class ProfileBusiness
{
    use UploadFileHelper;

    public function updateUserProfile($data)
    {
        try {
            $user = Admin::find($data['id']);

            \DB::beginTransaction();

            $user->updated_at = date('Y-m-d H:i:s', time());

            if (isset($data['password']) && $data['password'] != "") {
                $user->password = $data['password'];
            }
            if (isset($data['email']) && $data['email'] != "") {
                $user->email = $data['email'];
            }
            $user->save();

            $profile = AdminProfile::where('admin_id', $data['id'])->first();

            if ($data['memo'] != "" && isset($data['memo'])) {
                $profile->memo = $data['memo'];
            }
            if ($data['phone'] != "" && isset($data['phone'])) {
                $profile->phone = $data['phone'];
            }
            if ($data['address'] != "" && isset($data['address'])) {
                $profile->address = $data['address'];
            }
            if (isset($data['full_name']) && $data['full_name'] != "") {
                $profile->full_name = $data['full_name'];
            }
            if (isset($data['avatar'])) {
                $profile->avatar = $data['avatar'];
            }
            $profile->save();

            \DB::commit();

            return $user;
        } catch (\Exception $e) {
            \DB::rollBack();
            return $e;
        }
    }


}