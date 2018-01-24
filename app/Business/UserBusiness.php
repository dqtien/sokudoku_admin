<?php
namespace App\Business;

use App\OperatorClass;
use App\Profile;
use App\Traits\UploadFileHelper;
use App\User;
use App\UserClass;
use App\UserDataTable;
use Illuminate\Support\Facades\Auth;

class UserBusiness
{
    use UploadFileHelper;

    public function updateUser($data)
    {
        try {
            $user = User::find($data['id']);

            \DB::beginTransaction();

            $user->updated_at = date('Y-m-d H:i:s', time());
            $user->status = $data['status'];

            if (isset($data['password']) && $data['password'] != "") {
                $user->password = $data['password'];
            }
//            if (isset($data['email']) && $data['email'] != "") {
//                $user->email = $data['email'];
//            }
            $user->save();

            //update user class
            if (isset($data['class_id']) && $data['class_id'] != "none") {
                $user->user_class()->detach();
                $user->user_class()->attach($data['class_id']);
            } elseif ($data['class_id'] == "none") {
                $user->user_class()->detach();
            }

            $profile = Profile::where('users_id', $data['id'])->first();

//            if ($data['memo'] != "" && isset($data['memo'])) {
//                $profile->memo = $data['memo'];
//            }
//            if ($data['phone'] != "" && isset($data['phone'])) {
//                $profile->phone = $data['phone'];
//            }
//            if ($data['address'] != "" && isset($data['address'])) {
//                $profile->address = $data['address'];
//            }
            if (isset($data['full_name']) && $data['full_name'] != "") {
                $profile->full_name = $data['full_name'];
            }
//            if (isset($data['avatar'])) {
//                $profile->avatar = $data['avatar'];
//            }
            $profile->save();

            \DB::commit();

            return $user;
        } catch (\Exception $e) {
            \DB::rollBack();
            return $e;
        }
    }

    public function getUserById($id)
    {
        $user = User::where('id', $id)->with('profile')->first();
        return $user;
    }

    public function queryUserForDataTable(UserDataTable $dtModel)
    {
        // Set total record.
        $dtModel->set_iTotalRecords(User::count());

        // Get user list query by filter
        $query = $this->getListUserByFilter($dtModel);

        //Save to session
        \Session::put('user_filter_query', $dtModel);

        // Get total display record
        $dtModel->set_iTotalDisplayRecords($query->count());

        // Get data
        $listQueryData = $query->skip($dtModel->get_iDisplayStart())->take($dtModel->get_iDisplayLength())->orderBy('updated_at', 'desc')->get();
        // Set to dtModel
        $dtModel->set_aaData($listQueryData);

        return $dtModel;
    }

    public function getListUserByFilter(UserDataTable $dtModel)
    {

        $query = User::select('users.*')
            ->with('profile');

        $user_login = Auth::user();
        if ($user_login->id != 1) {
            $operator_class = OperatorClass::where('admin_id', $user_login->id)->first();
            if ($operator_class) {
                $class_id = $operator_class->class_id;
                $query->whereHas('user_class', function ($q) use ($class_id) {
                    $q->where('id', $class_id);
                });
            }
        }

        // Get filter data
        $full_name = $dtModel->full_name;
        $status = $dtModel->status;
        $class_name = $dtModel->class_name;

        if ($status != 2) {
            $query->where('status', $status);
        }
        if (isset($class_name) && $class_name != "all") {
            $query->whereHas('user_class', function ($q) use ($class_name) {
                $q->where('id', $class_name);
            });
        }
        if (isset($full_name) && $full_name != "") {
            $query->whereHas('profile', function ($q) use ($full_name) {
                $q->where('full_name', 'LIKE', "%{$full_name}%");
            });
        }

        return $query;
    }

    public function deleteUser($id)
    {
        try {
            \DB::beginTransaction();
            $user = User::where('id', $id)->first();

            Profile::where('users_id', $id)->delete();
            UserClass::where('user_id', $id)->delete();

            $user->delete();
            \DB::commit();
            return true;
        } catch (\Exception $e) {
            \DB::rollBack();
            return $e;
        }

    }

    public function createUser($data)
    {
        try {
            \DB::beginTransaction();
            $user = new User();
            $user->user_login_id = $data['login_id'];
            $user->password = $data['password'];
            $user->save();
            if ($user) {
                if ($data['class_id'] != "none" && isset($data['class_id'])) {
                    $user->user_class()->attach($data['class_id']);
                }
                //create profile
                $profile = new Profile();
                $profile->users_id = $user->id;
                if ($data['full_name'] != "" && isset($data['full_name'])) {
                    $profile->full_name = $data['full_name'];
                }
                $profile->save();
            }
            \DB::commit();
            return $user;
        } catch (\Exception $e) {
            \DB::rollBack();
            return false;
        }
    }
}