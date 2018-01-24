<?php
namespace App\Business;

use App\Question;
use App\QuestionAnswer;
use App\QuestionDatatable;
use App\QuestionType;
use App\QuestionTypeDatatable;

/**
 * Created by PhpStorm.
 * User: Giang Nam
 * Date: 2/24/2017
 * Time: 10:58 AM
 */
class QuestionTypeBusiness
{
    public function queryQuestionTypeForDataTable(QuestionTypeDatatable $dtModel)
    {
        // Set total record.
        $dtModel->set_iTotalRecords(QuestionType::count());

        // Get user list query by filter
        $query = $this->getListQuestionTypeByFilter($dtModel);

        //Save to session
        \Session::put('question_type_filter_query', $dtModel);

        // Get total display record
        $dtModel->set_iTotalDisplayRecords($query->count());

        // Get data
        $listQueryData = $query->skip($dtModel->get_iDisplayStart())->take($dtModel->get_iDisplayLength())->orderBy('updated_at', 'desc')->get();
        // Set to dtModel
        $dtModel->set_aaData($listQueryData);

        return $dtModel;
    }

    public function getQuestionTypeById($id)
    {
        $question_type = QuestionType::where('id', $id)->first();
        return $question_type;
    }

    public function deleteQuestionType($id)
    {
        try {
            \DB::beginTransaction();
            QuestionType::where('id', $id)->delete();
            \DB::commit();
            return true;
        } catch (\Exception $e) {
            \DB::rollBack();
            return $e;
        }

    }

    public function updateQuestionType($data)
    {
        try {
            $question_type = QuestionType::find($data['id']);

            \DB::beginTransaction();
            $question_type->updated_at = date('Y-m-d H:i:s', time());

            if (isset($data['question_type_name']) && $data['question_type_name'] != "") {
                $question_type->display_name = $data['question_type_name'];
            }
            $question_type->save();

            \DB::commit();

            return $question_type;
        } catch (\Exception $e) {
            \DB::rollBack();
            return $e;
        }
    }

    public function getListQuestionTypeByFilter(QuestionTypeDatatable $dtModel)
    {

        $query = QuestionType::select('question_type.*');

        // Get filter data
        $question_type_name = $dtModel->display_name;

        if ($question_type_name != "" && isset($question_type_name)) {
            $query->where('display_name', 'LIKE', "%{$question_type_name}%");
        }

        return $query;
    }

    public function createQuestionType($data)
    {
        try {
            \DB::beginTransaction();
            $question_type_name = $data['question_type_name'];

            $question_type = new QuestionType();

            if (isset($data['question_type_name']) && $data['question_type_name'] != "") {
                $question_type->display_name = $question_type_name;
            }
            $question_type->save();

            \DB::commit();
            return $question_type;
        } catch (\Exception $e) {
            \DB::rollBack();
            return $e;
        }

    }
}