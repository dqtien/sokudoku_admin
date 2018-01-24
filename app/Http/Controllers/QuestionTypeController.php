<?php

namespace App\Http\Controllers;

use App\Business\QuestionTypeBusiness;
use App\Http\Requests\CreateQuestionTypeRequest;
use App\QuestionDatatable;
use App\QuestionType;
use App\QuestionTypeDatatable;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Created by PhpStorm.
 * User: Giang Nam
 * Date: 2/24/2017
 * Time: 10:55 AM
 */
class QuestionTypeController extends Controller
{
    private $questionTypeBusiness;

    public function __construct(QuestionTypeBusiness $questionTypeBusiness)
    {
        $this->questionTypeBusiness = $questionTypeBusiness;
    }

    protected function edit($id)
    {
        $question = $this->questionTypeBusiness->getQuestionTypeById($id);
        return $question;
    }

    protected function createNewQuestionType(CreateQuestionTypeRequest $request)
    {
        $data = array();
        $data['question_type_name'] = $request->get('question_type_name');

        //create question
        $question = $this->questionTypeBusiness->createQuestionType($data);

        if ($question) {
            return "1";
        }
    }

    public function index()
    {
        return view('question_type.index');
    }

    public function update(Request $request)
    {
        //prepare data
        $data = array();
        $data['id'] = $request->get('id');
        $data['question_type_name'] = $request->get('question_type_name');
        //update
        $question = $this->questionTypeBusiness->updateQuestionType($data);

        return $question;
    }

    public function deleteQuestionType(Request $request)
    {
        $delete_user = $this->questionTypeBusiness->deleteQuestionType($request->get('id'));
        if ($delete_user == true) {
            return "1";
        }
    }

    public function loadQuestionTypeDatabase(Request $request)
    {
        // Create dtModel from Input
        $dtModel = new QuestionTypeDatatable();
        $dtModel->set_sSearch($request->get('sSearch'));
        $dtModel->set_iDisplayStart($request->get('iDisplayStart'));
        $dtModel->set_iDisplayLength($request->get('iDisplayLength'));
        $dtModel->set_iSortingCols($request->get('iSortingCols'));
        $dtModel->set_iSortCol_0($request->get('iSortCol_0'));
        $dtModel->set_sSortDir_0($request->get('sSortDir_0'));
        $dtModel->set_iTotalRecords($request->get('iTotalRecords'));

        $dtModel->display_name = ($request->get('question_type_name'));

        $dtModel = $this->questionTypeBusiness->queryQuestionTypeForDataTable($dtModel);

        return $dtModel->toJson();
    }

}