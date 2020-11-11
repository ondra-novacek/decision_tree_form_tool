<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Survey;
use Illuminate\Support\Facades\DB;
use App\Answer;

class SurveyController extends Controller
{
    
    public function index(Request $request)
    {
        return Survey::where('user_id', $request->user_id)->get();
    }


    public function store(Request $request)
    {
        $survey = new Survey;

        $survey->name = $request->name;
        $survey->user_id = $request->user_id;

        $survey->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // return $id;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        $survey = Survey::find($id);
        $survey->delete();
    }


    public function possibleAnswers($survey_id){
        return Answer::where('survey_id', $survey_id)->whereNull('child_question_id')->get();
    }
}
