<?php

namespace App\Http\Controllers;

use App\Business\ClassBusiness;
use App\Business\questionTypeBusiness;
use App\ClassDatatable;
use App\Http\Requests\CreateClassRequest;
use App\Http\Requests\CreateQuestionTypeRequest;
use App\QuestionDatatable;
use App\QuestionType;
use App\QuestionTypeDatatable;
use App\UserClass;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Created by PhpStorm.
 * User: Giang Nam
 * Date: 2/24/2017
 * Time: 10:55 AM
 */
class ClassController extends Controller
{
    private $classBusiness;

    public function __construct(ClassBusiness $classBusiness)
    {
        $this->classBusiness = $classBusiness;
    }

    protected function createNewClass(CreateClassRequest $request)
    {
        $data = array();
        $data['class_name'] = $request->get('class_name');

        //create question
        $question = $this->classBusiness->createClass($data);

        if ($question) {
            return "1";
        }
    }

    protected function edit($id)
    {
        $user = $this->classBusiness->getClassById($id);
        return $user;
    }

    public function index()
    {
        return view('class.index');
    }

    public function update(CreateClassRequest $request)
    {
        //prepare data
        $data = array();
        $data['id'] = $request->get('id');
        $data['class_name'] = $request->get('class_name');
        //update
        $question = $this->classBusiness->updateClass($data);

        return $question;
    }

    public function deleteClass(Request $request)
    {
        $delete_user = $this->classBusiness->deleteClass($request->get('id'));
        if ($delete_user == true) {
            return "1";
        }
    }

    public function loadClassDatabase(Request $request)
    {
        // Create dtModel from Input
        $dtModel = new ClassDatatable();
        $dtModel->set_sSearch($request->get('sSearch'));
        $dtModel->set_iDisplayStart($request->get('iDisplayStart'));
        $dtModel->set_iDisplayLength($request->get('iDisplayLength'));
        $dtModel->set_iSortingCols($request->get('iSortingCols'));
        $dtModel->set_iSortCol_0($request->get('iSortCol_0'));
        $dtModel->set_sSortDir_0($request->get('sSortDir_0'));
        $dtModel->set_iTotalRecords($request->get('iTotalRecords'));

        $dtModel->class_name = ($request->get('class_name'));

        $dtModel = $this->classBusiness->queryClassForDataTable($dtModel);

        if (sizeof($dtModel->aaData) > 0) {
            foreach ($dtModel->aaData as $item) {
                if ($item != null) {
                    $count = UserClass::where('class_id', $item->id)->count();
                    $item->count_user = $count;
                }
            }
        }

        return $dtModel->toJson();
    }

}