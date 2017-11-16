<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Survey;
use App\Answer;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;

class AnswerController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    public function store(Request $request, Survey $survey) {
        $arr = $request->except('_token');
//var_dump($arr);
//                        exit;
        foreach ($arr as $key => $value) {
            $newAnswer = new Answer();
            if (!isset($value['answer'])) {
                continue;
            }

            if (!is_array($value)) {
                $newValue = $value['answer'];
            } else {
                if (isset($value['answer'])) {
                    $newValue = json_encode($value['answer']);
                }
                
//                if($key == 51){
                    if(isset($arr["ques_text_$key"]["text-answer"])){
                        
                        $newAnswer->optional_answer = json_encode($arr["ques_text_$key"]["text-answer"]);
                    }
//                }
            }

            if (isset($value['optional_answer'])) {
                $newAnswer->optional_answer = $value['optional_answer'];
            }

            $newAnswer->answer = str_replace('"', "", $newValue);
            $newAnswer->question_id = $key;
            $newAnswer->user_id = Auth::id();
            $newAnswer->survey_id = $survey->id;
            $newAnswer->answer_id = $request->get('answer_id');
            $newAnswer->save();
            $answerArray[] = $newAnswer;
        }
        return Redirect::to("/survey/success");
    }
    
    public function update(Request $request, Survey $survey){
        $arr = $request->except('_token');

        $data = array(
            'optional_answer' => json_encode($arr["ques_text_51"]["text-answer"])
        );

        Answer::where('survey_id', 8)->where('user_id', Auth::user()->uid)->where('question_id', 51)->update($data);
        return Redirect::to("/survey/success");
    }

}
