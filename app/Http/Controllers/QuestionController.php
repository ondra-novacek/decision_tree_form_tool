<?php

namespace App\Http\Controllers;

use App\Question;
use App\QuestionAnswer;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function index(Request $request)
    {
        return Question::where('survey_id', $request->survey_id)->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $question = new Question();

        $question->questionType_id = 1;
        $question->survey_id = $request->survey_id;
        $question->isRoot = $request->is_root;
        $question->text = $request->text;

        $question->save();

        if ($request->parent_answer !== "0") {
            $qa = new QuestionAnswer();
            $qa->question_id = $question->id;
            $qa->answer_id = $request->parent_answer;
            $qa->save();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        $question = Question::find($id);
        $question->delete();
    }
}
