<?php

namespace App;

class Question extends BaseModel
{
    protected $table = 'dt_questions';

    public static function getAnswers($question) {
        $questionAnswer = QuestionAnswer::where('question_id', $question['id'])->get();

        $answers = [];
        foreach ($questionAnswer as $questionanswer) {
            $answer = Answer::find($questionanswer['answer_id']);
            $answers[] = $answer;
        }
        return $answers;
    }
}
