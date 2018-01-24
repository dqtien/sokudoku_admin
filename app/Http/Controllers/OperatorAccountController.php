<?php

namespace App\Http\Controllers;

use App\Admin;
use App\AdminProfile;
use App\Business\OperatorAccountBusiness;
use App\ClassTable;
use App\Http\Requests\CreateOperatorAccountRequest;
use App\Http\Requests\UpdateOperatorAccountRequest;
use App\OperatorAccountDataTable;
use App\OperatorClass;
use App\Role;
use App\Traits\UploadFileHelper;
use App\UserClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OperatorAccountController extends Controller
{
    private $operatorBusiness;

    public function __construct(OperatorAccountBusiness $operatorBusiness)
    {
        $this->operatorBusiness = $operatorBusiness;
    }

    protected function index()
    {
        $role = Role::all();
        $array_role_name = array();
        foreach ($role as $item) {
            $array_role_name[$item->id] = $item->display_name;
        }

        $last_operator = DB::table('admin')->where('id', DB::raw("(select max(`id`) from admin)"))->first();
        $max_id = 0;
        if ($last_operator) {
            $max_id = $last_operator->id + 1;
        }
//        $operator_class_id = OperatorClass::pluck('class_id');
        $class = ClassTable::all();
        $arr_class = array();
        $arr_class_search = array();
        $arr_class['none'] = "None";
        $arr_class_search['all'] = "All";
        if (sizeof($class) > 0) {
            foreach ($class as $item) {
                $arr_class[$item->id] = $item->name;
                $arr_class_search[$item->id] = $item->name;
            }
        }
        return view('operator_account.index', compact(['array_role_name', 'arr_class', 'max_id','arr_class_search']));
    }

    protected function create()
    {
        $role = Role::all();
        $array_role_name = array();
        foreach ($role as $item) {
            $array_role_name[$item->id] = $item->display_name;
        }

        $class = ClassTable::All();
        $arr_class = array();
        $arr_class['none'] = "None";
        if (sizeof($class) > 0) {
            foreach ($class as $item) {
                $arr_class[$item->id] = $item->name;
            }
        }
        return view('operator_account.create', compact(['array_role_name', 'arr_class']));
    }

    protected function createNewOperator(CreateOperatorAccountRequest $request)
    {
        $data = array();
        $data['class_name'] = $request->get('class_name');
        $data['login_id'] = $request->get('login_id');
        $data['password'] = $request->get('password');
        $data['role'] = $request->get('role');
        $data['full_name'] = $request->get('full_name');

        $operator_account = $this->operatorBusiness->createOperatorAccount($data);

        if ($operator_account) {
            $last_operator = DB::table('admin')->where('id', DB::raw("(select max(`id`) from admin)"))->first();
            $max_id = 0;
            if ($last_operator) {
                $max_id = $last_operator->id + 1;
            }
            $operator_account->max_id = $max_id;
        }
        return $operator_account;

    }

    protected function edit($id)
    {
        $operator_account = $this->operatorBusiness->getOperatorAccountById($id);

        $operator_class = OperatorClass::where('admin_id', $operator_account->id)->first();
        if ($operator_class) {
            $class_id = $operator_class->class_id;
            $operator_account->class_id = $class_id;
        } else {
            $operator_account->class_id = "none";
        }
        return $operator_account;
    }

    public function update(UpdateOperatorAccountRequest $request)
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
//        $data['role'] = $request->get('role');
//        $data['class_id'] = $request->get('class_id');

        //check file avatar
//        if ($request->hasFile('avatar')) {
//            //move file upload
////            list($url, $file_name) = $this->moveFile($request->file('avatar'));
//            $file_name = $this->operatorBusiness->moveFile($request->file('avatar'));
//            $data['avatar'] = $file_name;
//        }
        //update
        $user = $this->operatorBusiness->updateOperatorAccount($data);

        return $user;
    }

    public function deleteOperator(\Symfony\Component\HttpFoundation\Request $request)
    {
        $delete_user = $this->operatorBusiness->deleteOperatorAccount($request->get('id'));
        if ($delete_user == true) {
            return "1";
        }
    }

    /**
     * load data for DataTable
     * @param Request $request
     * @return string
     */
    public function loadOperatorAccountDatabase(Request $request)
    {
        // Create dtModel from Input
        $dtModel = new OperatorAccountDataTable();
        $dtModel->set_sSearch($request->get('sSearch'));
        $dtModel->set_iDisplayStart($request->get('iDisplayStart'));
        $dtModel->set_iDisplayLength($request->get('iDisplayLength'));
        $dtModel->set_iSortingCols($request->get('iSortingCols'));
        $dtModel->set_iSortCol_0($request->get('iSortCol_0'));
        $dtModel->set_sSortDir_0($request->get('sSortDir_0'));
        $dtModel->set_iTotalRecords($request->get('iTotalRecords'));

        $dtModel->class_name = ($request->get('class_name'));
        $dtModel->status = ($request->get('status'));

        $dtModel = $this->operatorBusiness->queryAccountForDataTable($dtModel);
        if (sizeof($dtModel->aaData) > 0) {
            foreach ($dtModel->aaData as $item) {
                if ($item != null) {
                    $operator_class = OperatorClass::where('admin_id', $item->id)->first();
                    if ($operator_class) {
                        $class = ClassTable::where('id', $operator_class->class_id)->first();
                        $item->class_name = $class->name;
                        $admin = AdminProfile::where('admin_id', $operator_class->admin_id)->first();
                        $item->admin_name = $admin->full_name;

                        $count = UserClass::where('class_id', $class->id)->count();
                        $item->users = $count;

                    } else {
                        $item->class_name = "None";
                    }

                }
            }
        }
        return $dtModel->toJson();
    }
}