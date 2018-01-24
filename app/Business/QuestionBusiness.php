<?php
namespace App\Business;

use App\Question;
use App\QuestionAnswer;
use App\QuestionDatatable;

/**
 * Created by PhpStorm.
 * User: Giang Nam
 * Date: 2/24/2017
 * Time: 10:58 AM
 */
class QuestionBusiness
{
    public function queryQuestionForDataTable(QuestionDatatable $dtModel)
    {
        // Set total record.
        $dtModel->set_iTotalRecords(Question::count());

        // Get user list query by filter
        $query = $this->getListQuestionByFilter($dtModel);

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

    public function getQuestionById($id)
    {
        $question = Question::where('id', $id)->with('question_answer')->with('question_type')->first();
        return $question;
    }

    public function deleteQuestion($id)
    {
        try {
            \DB::beginTransaction();
            $question = Question::where('id', $id)->first();

            $delete_answer = QuestionAnswer::where('questions_id', $id)->delete();

            if ($delete_answer) {
                $question->delete();
            }
            \DB::commit();
            return true;
        } catch (\Exception $e) {
            \DB::rollBack();
            return $e;
        }

    }

    public function updateQuestion($data)
    {
        try {
            $question = Question::find($data['id']);

            \DB::beginTransaction();
            $question->updated_at = date('Y-m-d H:i:s', time());
            $question->question_type_id = $data['question_type'];
            $question->status = $data['status'];
            $question->level = $data['level'];
            $question->writing = $data['writing'];
            $question->line_type = $data['line_type'];

            if (isset($data['question_content']) && $data['question_content'] != "") {
                $question->content = $data['question_content'];
            }
            $question->save();

            if ($question) {
                $question_answer = QuestionAnswer::where('questions_id', $data['id'])->first();
                if (isset($data['question_answer']) && $data['question_answer'] != "") {
                    $question_answer->content = $data['question_answer'];
                }
                $question_answer->save();
            }
            \DB::commit();

            return $question;
        } catch (\Exception $e) {
            \DB::rollBack();
            return $e;
        }
    }

    public function getListQuestionByFilter(QuestionDatatable $dtModel)
    {

        $query = Question::select('questions.*')
            ->with('question_answer')
            ->with('question_type');

        // Get filter data
        $question_type = $dtModel->question_type;
        $status = $dtModel->status;

        if ($question_type != "all") {
            $query->where('question_type_id', $question_type);
        }
        if ($status != "0") {
            $query->where('status', $status);
        }

        return $query;
    }

    public function createQuestion($data)
    {
        try {
            \DB::beginTransaction();
            $question_type = $data['question_type'];
            $question_content = $data['question_content'];
            $question_answer = $data['question_answer'];

            $question = new Question();
            $question->question_type_id = $question_type;
            $question->level = $data['level'];
            $question->writing = $data['writing'];
            $question->line_type = $data['line_type'];
            if (isset($data['question_content']) && $data['question_content'] != "") {
                $question->content = $question_content;
            }
            $question->save();

            if ($question) {
                $question_answer_new = new QuestionAnswer();
                if (isset($data['question_answer']) && $data['question_answer'] != "") {
                    $question_answer_new->content = $question_answer;
                }
                $question_answer_new->questions_id = $question->id;
                $question_answer_new->save();
            }
            \DB::commit();
            return $question;
        } catch (\Exception $e) {
            \DB::rollBack();
            return $e;
        }

    }
}