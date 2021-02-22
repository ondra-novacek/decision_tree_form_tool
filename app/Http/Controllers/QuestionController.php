<?php

namespace App\Http\Controllers;

use App\Answer;
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
        if (($request->is_root) and ($this->rootExists($request->survey_id))) {
            return "Root question already exists";
        }
        $question = new Question();

        $question->questionType_id = 1;
        $question->survey_id = $request->survey_id;
        $question->isRoot = $request->is_root;
        $question->text = $request->text;

        $question->save();

        if ($request->parent_answer !== "0") {
            $answer = Answer::find($request->parent_answer);
            $answer->child_question_id = $question->id;
            $answer->save();
            // $qa = new QuestionAnswer();
            // $qa->question_id = $question->id;
            // $qa->answer_id = $request->parent_answer;
            // $qa->save();
        }
    }


    public function rootExists($id)
    {
        $questions = Question::where('survey_id', $id)
            ->where('isRoot', 1)->get()->toArray();

        return !empty($questions);   
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

        $parent_answer = Answer::where('child_question_id', $id)->first();

        if (!is_null($parent_answer)){
            $parent_answer->child_question_id = null;
            $parent_answer->save();
        } 

        // $answers 

        $question->delete();
    }


    public function getParentAnswer($id) {
        $parent = Answer::where('child_question_id', $id)->first();
        if (is_null($parent)) {
            $root = new \stdClass();
            $root->id = "root";
            return response()->json($root);
        } 
        return $parent;
    }


    public function getAnswers($id) {
        $qas = QuestionAnswer::where('question_id', $id)->get()->toArray();
        $answerIds = [];
        foreach ($qas as $qa) {
            $answerIds[] = $qa['answer_id'];
        }
        $answers = Answer::whereIn('id', $answerIds)->get()->toArray();
        return $answers;
    }
}
