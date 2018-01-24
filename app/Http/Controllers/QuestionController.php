<?php

namespace App\Http\Controllers;

use App\Business\QuestionBusiness;
use App\QuestionDatatable;
use App\QuestionType;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Created by PhpStorm.
 * User: Giang Nam
 * Date: 2/24/2017
 * Time: 10:55 AM
 */
class QuestionController extends Controller
{
    private $questionBusiness;

    public function __construct(QuestionBusiness $questionBusiness)
    {
        $this->questionBusiness = $questionBusiness;
    }

    protected function edit($id)
    {
        $question = $this->questionBusiness->getQuestionById($id);
        return $question;
    }

    protected function createNewQuestion(Request $request)
    {
        $data = array();
        $data['question_type'] = $request->get('question_type');
        $data['question_content'] = $request->get('question_content');
        $data['question_answer'] = $request->get('question_answer');
        $data['level'] = $request->get('level');
        $data['writing'] = $request->get('writing');
        $data['line_type'] = $request->get('line_type');

        //create question
        $question = $this->questionBusiness->createQuestion($data);

        if ($question) {
            return "1";
        }
    }

    protected function create()
    {
        $question_type = QuestionType::all();
        $question_type_arr = array();
        foreach ($question_type as $item) {
            $question_type_arr[$item->id] = $item->display_name;
        }
        return view('question.create', compact('question_type_arr'));
    }

    public function index()
    {
        $question_type = QuestionType::all();
        $question_type_arr = array();
        $question_type_arr_edit = array();
        $question_type_arr['all'] = "All";
        foreach ($question_type as $item) {
            $question_type_arr[$item->id] = $item->display_name;
            $question_type_arr_edit[$item->id] = $item->display_name;
        }
        
        $level_arr_edit = array('1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5');
        $writing_arr_edit = array('vertical' => '縦', 'horizon' => '横');
        $line_type_arr_edit = array('single' => '1行', 'multiple' => '複数行');
        
        return view('question.index', compact('question_type_arr', 'question_type_arr_edit', 'level_arr_edit', 'writing_arr_edit', 'line_type_arr_edit'));
    }

    public function update(Request $request)
    {
        //prepare data
        $data = array();
        $data['id'] = $request->get('id');
        $data['question_type'] = $request->get('question_type');
        $data['question_content'] = $request->get('question_content');
        $data['question_answer'] = $request->get('question_answer');
        $data['level'] = $request->get('level');
        $data['writing'] = $request->get('writing');
        $data['line_type'] = $request->get('line_type');
        $data['status'] = $request->get('status');

        //update
        $question = $this->questionBusiness->updateQuestion($data);

        return $question;
    }

    public function deleteQuestion(Request $request)
    {
        $delete_user = $this->questionBusiness->deleteQuestion($request->get('id'));
        if ($delete_user == true) {
            return "1";
        }
    }

    public function loadQuestionDatabase(Request $request)
    {
        // Create dtModel from Input
        $dtModel = new QuestionDatatable();
        $dtModel->set_sSearch($request->get('sSearch'));
        $dtModel->set_iDisplayStart($request->get('iDisplayStart'));
        $dtModel->set_iDisplayLength($request->get('iDisplayLength'));
        $dtModel->set_iSortingCols($request->get('iSortingCols'));
        $dtModel->set_iSortCol_0($request->get('iSortCol_0'));
        $dtModel->set_sSortDir_0($request->get('sSortDir_0'));
        $dtModel->set_iTotalRecords($request->get('iTotalRecords'));

        $dtModel->question_type = ($request->get('question_type'));
        $dtModel->status = ($request->get('status'));

        $dtModel = $this->questionBusiness->queryQuestionForDataTable($dtModel);

        return $dtModel->toJson();
    }

}