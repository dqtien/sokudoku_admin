<?php

namespace App\Http\Controllers;

use App\Business\UserBusiness;
use App\ClassTable;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\OperatorClass;
use App\UserClass;
use App\UserDataTable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    private $userBusiness;

    public function __construct(UserBusiness $userBusiness)
    {
        $this->userBusiness = $userBusiness;
    }

    protected function index()
    {

        $last_operator = DB::table('users')->where('id', DB::raw("(select max(`id`) from users)"))->first();
        $max_id = 0;
        if ($last_operator) {
            $max_id = $last_operator->id + 1;
        }

        $class_id = 0;
        //check user admin or operator
        $user_login = Auth::user();
        if ($user_login->id != 1) {
            $operator_class = OperatorClass::where('admin_id', $user_login->id)->first();
            if ($operator_class) {
                $class_id = $operator_class->class_id;
            }
        }

        $arr_class = array();
        $arr_class_search = array();
        $arr_class['none'] = "None";
        $arr_class_search['all'] = "All";
        if ($class_id != 0) {
            $class = ClassTable::where('id', $class_id)->get();
        } else {
            $class = ClassTable::all();
        }

        if (sizeof($class) > 0) {
            foreach ($class as $item) {
                $arr_class[$item->id] = $item->name;
                $arr_class_search[$item->id] = $item->name;
            }
        }
        return view('user.index', compact('arr_class', 'max_id', 'class_id', 'arr_class_search'));
    }

    protected function create()
    {
        $class = ClassTable::All();
        $arr_class = array();
        $arr_class['none'] = "None";
        if (sizeof($class) > 0) {
            foreach ($class as $item) {
                $arr_class[$item->id] = $item->name;
            }
        }
        return view('user.create', compact('arr_class'));
    }

    protected function store(CreateUserRequest $request)
    {
        return redirect()->back();
    }

    protected function edit($id)
    {
        $user = $this->userBusiness->getUserById($id);
        $user_class = UserClass::where('user_id', $user->id)->first();
        if ($user_class) {
            $class_id = $user_class->class_id;
            $user->class_id = $class_id;
        } else {
            $user->class_id = "none";
        }
        return $user;
    }

    public function deleteUser(\Symfony\Component\HttpFoundation\Request $request)
    {
        $delete_user = $this->userBusiness->deleteUser($request->get('id'));
        if ($delete_user == true) {
            return "1";
        }
    }

    protected function createNewUser(CreateUserRequest $request)
    {
        $data = array();
        $data['password'] = $request->get('password');
        $data['full_name'] = $request->get('user_name');
        $data['login_id'] = $request->get('login_id');
        $data['class_id'] = $request->get('class_id');


        //update category
        $operator_account = $this->userBusiness->createUser($data);
        if ($operator_account) {
            $last_operator = DB::table('users')->where('id', DB::raw("(select max(`id`) from users)"))->first();
            $max_id = 0;
            if ($last_operator) {
                $max_id = $last_operator->id + 1;
            }
            $operator_account->max_id = $max_id;
        }
        return $operator_account;
    }

    protected function update(UpdateUserRequest $request)
    {
        //prepare data
        $data = array();
        $data['id'] = $request->get('id');
//        $data['email'] = $request->get('email');
        $data['password'] = $request->get('password');
        $data['full_name'] = $request->get('full_name');
        $data['status'] = $request->get('status');
//        $data['phone'] = $request->get('phone');
//        $data['address'] = $request->get('address');
//        $data['memo'] = $request->get('memo');
        $data['class_id'] = $request->get('class_id');


        //check file avatar
//        if ($request->hasFile('avatar')) {
//            //move file upload
////            list($url, $file_name) = $this->moveFile($request->file('avatar'));
//            $file_name = $this->userBusiness->moveFile($request->file('avatar'));
//            $data['avatar'] = $file_name;
//        }
        //update
        $user = $this->userBusiness->updateUser($data);

        return $user;
    }

    /**
     * load data for DataTable
     * @param Request $request
     * @return string
     */
    public function loadUserDatabase(Request $request)
    {
        // Create dtModel from Input
        $dtModel = new UserDataTable();
        $dtModel->set_sSearch($request->get('sSearch'));
        $dtModel->set_iDisplayStart($request->get('iDisplayStart'));
        $dtModel->set_iDisplayLength($request->get('iDisplayLength'));
        $dtModel->set_iSortingCols($request->get('iSortingCols'));
        $dtModel->set_iSortCol_0($request->get('iSortCol_0'));
        $dtModel->set_sSortDir_0($request->get('sSortDir_0'));
        $dtModel->set_iTotalRecords($request->get('iTotalRecords'));

        $dtModel->full_name = ($request->get('user_name'));
        $dtModel->status = ($request->get('status'));
        $dtModel->class_name = ($request->get('class_name'));

        $dtModel = $this->userBusiness->queryUserForDataTable($dtModel);
        if (sizeof($dtModel->aaData) > 0) {
            foreach ($dtModel->aaData as $item) {
                if ($item != null) {
                    $user_class = UserClass::where('user_id', $item->id)->first();
                    if ($user_class) {
                        $class_name = ClassTable::where('id', $user_class->class_id)->value('name');
                        $item->class_name = $class_name;
                    } else {
                        $item->class_name = "None";
                    }

                }
            }
        }
        return $dtModel->toJson();
    }
}