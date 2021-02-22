<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', 'UserController@GetLoggedUser');

// Route::get('test', function() {
//     return 1;
//     // return Article::find($id);
// });


// not secured apis
Route::apiResources([
    'qtype' => QTypeController::class,
    'survey' => SurveyController::class,
    'question' => QuestionController::class,
    'answer' => AnswerController::class
]);

Route::get('survey2', 'SurveyController@index');
Route::get('possibleanswers/{id}', 'SurveyController@possibleAnswers');
Route::get('parentanswer/{id}', 'QuestionController@getParentAnswer');
Route::get('answers/{id}', 'QuestionController@getAnswers');
Route::get('surveydata/{id}', 'SurveyController@getSurveyApi');

Route::get('decisiontree/{id}', 'SurveyController@decisionTree');

Route::group(['middleware' => ['auth']], function () {
    Route::get('/user3', 'UserController@GetLoggedUser');
});

