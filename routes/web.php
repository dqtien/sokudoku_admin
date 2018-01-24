<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//route for authentication
\Illuminate\Support\Facades\Auth::routes();

//change method of default request logout
Route::get('logout', 'Auth\LoginController@logout')->name('out');

//route require authentication
Route::group(['middleware' => ['auth']], function () {

    //home index
    Route::get('/', 'HomeController@index')->name('home');

    //profile setting
    Route::post('profile/update', 'ProfileController@updateProfile')->name('profile.update');
    Route::get('profile/index', 'ProfileController@index')->name('profile.index');


    Route::group(['middleware' => 'role:super_admin'], function () {
        //operator
        Route::get('user_admin/index', 'OperatorAccountController@index')->name('user_admin.index');
        Route::get('user_admin/create', 'OperatorAccountController@create')->name('user_admin.create_view');
        Route::get('user_admin/{id}', 'OperatorAccountController@edit')->name('user_admin.edit_in_modal');
        Route::post('user_admin/update', 'OperatorAccountController@update')->name('user_admin.update_operator');
        Route::post('user_admin/create_operator_account', 'OperatorAccountController@createNewOperator')->name('user_admin.create_operator');
        Route::post('user_admin/delete_operator', 'OperatorAccountController@deleteOperator')->name('user_admin.delete_operator');
        Route::post('user_admin/load_datatable', 'OperatorAccountController@loadOperatorAccountDatabase')->name('user_admin.load_data');

        //question
        Route::get('question/index', 'QuestionController@index')->name('question.index');
        Route::get('question/create', 'QuestionController@create')->name('question.create_view');
        Route::get('question/{id}', 'QuestionController@edit')->name('question.edit_in_modal');
        Route::post('question/update', 'QuestionController@update')->name('question.update_question');
        Route::post('question/create_question', 'QuestionController@createNewQuestion')->name('question.create_question');
        Route::post('question/delete_question', 'QuestionController@deleteQuestion')->name('question.delete_question');
        Route::post('question/load_datatable', 'QuestionController@loadQuestionDatabase')->name('question.load_data');


        //class
        Route::get('class/index', 'ClassController@index')->name('class.index');
        Route::post('class/load_datatable', 'ClassController@loadClassDatabase')->name('class.load_data');
        Route::post('class/create_class', 'ClassController@createNewClass')->name('class.create_class');
        Route::get('class/{id}', 'ClassController@edit')->name('class.edit_in_modal');
        Route::post('class/update', 'ClassController@update')->name('class.update_class');
        Route::post('class/delete_class', 'ClassController@deleteClass')->name('class.delete_class');

        //question type
        Route::get('question_type/index', 'QuestionTypeController@index')->name('question_type.index');
//        Route::get('question_type/create', 'QuestionTypeController@create')->name('question_type.create_view');
//        Route::get('question_type/{id}', 'QuestionTypeController@edit')->name('question_type.edit_in_modal');
//        Route::post('question_type/update', 'QuestionTypeController@update')->name('question_type.update_question_type');
//        Route::post('question_type/create_question_type', 'QuestionTypeController@createNewQuestionType')->name('question_type.create_question_type');
//        Route::post('question_type/delete_question_type', 'QuestionTypeController@deleteQuestionType')->name('question_type.delete_question_type');
        Route::post('question_type/load_datatable', 'QuestionTypeController@loadQuestionTypeDatabase')->name('question_type.load_data');
    });

    //user
    Route::get('user/index', 'UserController@index')->name('user.index');
    Route::get('user/create', 'UserController@create')->name('user.create_view');
    Route::get('user/{id}', 'UserController@edit')->name('user.edit_in_modal');
    Route::post('user/update', 'UserController@update')->name('user.update_user');
    Route::post('user/create_user', 'UserController@createNewUser')->name('user.create_user');
    Route::post('user/delete_user', 'UserController@deleteUser')->name('user.delete_user');
    Route::post('user/load_datatable', 'UserController@loadUserDatabase')->name('user.load_data');


});