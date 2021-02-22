<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Survey;
use Illuminate\Support\Facades\DB;
use App\Answer;
use App\Question;
use App\QuestionAnswer;

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
        return Survey::find($id);
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
        //TODO::delete cascade all
        $survey = Survey::find($id);
        $survey->delete();
    }


    public function possibleAnswers($survey_id){
        return Answer::where('survey_id', $survey_id)->whereNull('child_question_id')->get();
    }


    public function decisionTree($id)
    {
        // return $this->testDT();
        $root = Question::where('survey_id', $id)
                    ->where('isRoot', 1)
                    ->get();

        if (empty($root[0])) {
            return null;
        }

        $node = ["type" => "q", "data" => $root[0]];
        return $this->buildTree($node, true);
    }


    public function buildTree($node, $root = false) {
        $branch = [];
        $type = $node['type'];

        if ($type === 'q') {
            $elements = Question::getAnswers($node['data']);
            $type = 'a';

        } elseif ($type === 'a') {
            $question = Question::find($node['data']['child_question_id']);
            if (!$question) {
                return null;
            }

            $elements = [$question];
            $type = 'q';

        }

        if ($elements === null or empty($elements)) {
            return null;    
        }

        foreach($elements as $element) {
            $newNode = ["type" => $type, "data" => $element];
            $children = $this->buildTree($newNode);
            if ($children) {
                $newNode['children'] = $children;
            }

            // $newNode['children'] = $children;
            $branch[] = $newNode;
        }

        if ($root) {
            return ["type" => "q", "data" => $node["data"], "children"  => $branch];
        }
        return $branch;
    }


    public function getSurveyApi($survey_id) {
        $survey = Survey::find($survey_id);
        if ($survey) {
            $data = $this->decisionTree($survey_id);
            $survey = ["data" => $data, "name" => $survey['name']];
            return $survey;
        } else {
            return [];
        }
    }
}
