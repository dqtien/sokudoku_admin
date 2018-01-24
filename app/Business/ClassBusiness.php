<?php
namespace App\Business;

use App\AdminProfile;
use App\ClassDatatable;
use App\ClassTable;
use App\OperatorClass;
use App\Question;
use App\QuestionAnswer;
use App\QuestionDatatable;
use App\QuestionType;
use App\QuestionTypeDatatable;
use App\UserClass;
use Illuminate\Support\Facades\Auth;

/**
 * Created by PhpStorm.
 * User: Giang Nam
 * Date: 2/24/2017
 * Time: 10:58 AM
 */
class ClassBusiness
{
    public function queryClassForDataTable(ClassDatatable $dtModel)
    {
        // Set total record.
        $dtModel->set_iTotalRecords(ClassTable::count());

        // Get user list query by filter
        $query = $this->getListClassByFilter($dtModel);

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

    public function getClassById($id)
    {
        $class = ClassTable::where('id', $id)->first();
        return $class;
    }

    public function deleteClass($id)
    {
        try {
            \DB::beginTransaction();
            OperatorClass::where('class_id', $id)->delete();
            UserClass::where('class_id', $id)->delete();
            ClassTable::where('id', $id)->delete();
            \DB::commit();
            return true;
        } catch (\Exception $e) {
            \DB::rollBack();
            return $e;
        }

    }

    public function updateClass($data)
    {
        try {
            $class = ClassTable::find($data['id']);

            \DB::beginTransaction();
            $class->updated_at = date('Y-m-d H:i:s', time());

            if (isset($data['class_name']) && $data['class_name'] != "") {
                $class->name = $data['class_name'];
            }
            $current_admin = Auth::user();
            $admin_name = AdminProfile::where('admin_id', $current_admin->id)->value('full_name');
            if ($admin_name != null && $admin_name != "") {
                $class->author_name = $admin_name;
            }
            $class->save();

            \DB::commit();

            return $class;
        } catch (\Exception $e) {
            \DB::rollBack();
            return $e;
        }
    }

    public function getListClassByFilter(ClassDatatable $dtModel)
    {

        $query = ClassTable::select('class.*');

        // Get filter data
        $class_name = $dtModel->class_name;

        if ($class_name != "" && isset($class_name)) {
            $query->where('name', 'LIKE', "%{$class_name}%");
        }

        return $query;
    }

    public function createClass($data)
    {
        try {
            \DB::beginTransaction();
            $class_name = $data['class_name'];

            $class = new ClassTable();

            if (isset($data['class_name']) && $data['class_name'] != "") {
                $class->name = $class_name;
            }
            $current_admin = Auth::user();
            $admin_name = AdminProfile::where('admin_id', $current_admin->id)->value('full_name');
            if ($admin_name != null && $admin_name != "") {
                $class->author_name = $admin_name;
            }
            $class->save();

            \DB::commit();
            return $class;
        } catch (\Exception $e) {
            \DB::rollBack();
            return $e;
        }

    }
}