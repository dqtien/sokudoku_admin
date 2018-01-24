<?php
namespace App\Business;

use App\Admin;
use App\AdminProfile;
use App\ClassTable;
use App\OperatorAccountDataTable;
use App\OperatorClass;
use App\RoleUser;
use App\Traits\UploadFileHelper;
use App\User;
use App\UserClass;
use Illuminate\Support\Facades\Auth;

class OperatorAccountBusiness
{
    use UploadFileHelper;


    public function queryAccountForDataTable(OperatorAccountDataTable $dtModel)
    {
        // Set total record.
        $dtModel->set_iTotalRecords(Admin::count());

        // Get user list query by filter
        $query = $this->getListOperatorAccountByFilter($dtModel);

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

    public function getOperatorAccountById($id)
    {
        $user = Admin::where('id', $id)->with('adminProfile')->with('role')->first();
        return $user;
    }

    public function getListOperatorAccountByFilter(OperatorAccountDataTable $dtModel)
    {

        $query = Admin::select('admin.*')
            ->with('adminProfile')
            ->with('role');

        // Get filter data
        $class_name = $dtModel->class_name;
        $status = $dtModel->status;

        if ($status != 2) {
            $query->where('status', $status);
        }
        if (isset($class_name) && $class_name != "all") {
            $query->whereHas('operator', function ($q) use ($class_name) {
                $q->where('id', $class_name);
            });
        }
        $query->where('id', '!=', '1');


        return $query;
    }

    public function createOperatorAccount($data)
    {
        try {
            \DB::beginTransaction();
            $operator_account = new Admin();
            $operator_account->login_id = $data['login_id'];
            $operator_account->password = $data['password'];
            $operator_account->save();

            if ($operator_account) {
                //create role
                $operator_account->role()->attach($operator_account->id, ['role_id' => $data['role']]);
                //create profile
                $profile = new AdminProfile();
                $profile->admin_id = $operator_account->id;
                $profile->full_name = $data['full_name'];
                $profile->save();

                //get admin log in
                $admin_log_in = Auth::user();
                $admin_profile_name = AdminProfile::where('admin_id', $admin_log_in->id)->value('full_name');
                //create class
                $class = new ClassTable();
                $class->name = $data['class_name'];
                $class->author_name = $admin_profile_name;
                $class->save();

                //create operator class
                $operator_class = new OperatorClass();
                $operator_class->admin_id = $operator_account->id;
                $operator_class->class_id = $class->id;
                $operator_class->save();

            }
            \DB::commit();
            return $operator_account;
        } catch (\Exception $e) {
            \DB::rollBack();
            return $e;
        }
    }

    public function updateOperatorAccount($data)
    {
        try {
            $operator = Admin::find($data['id']);

            \DB::beginTransaction();

            $operator->updated_at = date('Y-m-d H:i:s', time());
            $operator->status = $data['status'];

            if (isset($data['password']) && $data['password'] != "") {
                $operator->password = $data['password'];
            }
//            if (isset($data['email']) && $data['email'] != "") {
//                $operator->email = $data['email'];
//            }
            $operator->save();

            //operator class update
//            if (isset($data['class_id']) && $data['class_id'] != "none") {
//                $check = OperatorClass::where('class_id', $data['class_id'])->where('admin_id', '!=', $data['id'])->first();
//                if ($check) {
//                    return "1";
//                } else {
//                    $operator->operator()->detach();
//                    $operator->operator()->attach($data['class_id']);
//                }
//            } elseif ($data['class_id'] == "none") {
//                $operator->operator()->detach();
//            }

//            $role_user = RoleUser::where('admin_id', $data['id'])->first();
//            $role_user->role_id = $data['role'];
//            $role_user->save();

            $profile = AdminProfile::where('admin_id', $data['id'])->first();

            if (isset($data['full_name']) && $data['full_name'] != "") {
                $profile->full_name = $data['full_name'];
            }
//            if (isset($data['phone']) && $data['phone'] != "") {
//                $profile->phone = $data['phone'];
//            }
//            if (isset($data['address']) && $data['address'] != "") {
//                $profile->address = $data['address'];
//            }
//            if (isset($data['memo']) && $data['memo'] != "") {
//                $profile->memo = $data['memo'];
//            }
//            if (isset($data['avatar'])) {
//                $profile->avatar = $data['avatar'];
//            }
            $profile->save();

            \DB::commit();

            return $operator;
        } catch
        (\Exception $e) {
            \DB::rollBack();
            return $e;
        }
    }

    public function deleteOperatorAccount($id)
    {
        try {
            \DB::beginTransaction();
            $operator_account = Admin::where('id', $id)->first();

            $delete_profile = AdminProfile::where('admin_id', $id)->delete();
            $operator_class = OperatorClass::where('admin_id', $id)->first();

            $class_user = UserClass::where('class_id', $operator_class->class_id)->delete();

            $delete_class = ClassTable::where('id', $operator_class->class_id)->delete();
            $delete_operator_class = $operator_account->operator()->where('admin_id', $id)->detach();


            if ($delete_profile && $delete_operator_class && $delete_class) {
                $operator_account->role()->where('admin_id', $operator_account->id)->detach();
                $operator_account->delete();

            }
            \DB::commit();
            return true;
        } catch (\Exception $e) {
            \DB::rollBack();
            return $e;
        }

    }
}