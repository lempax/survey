<?php

namespace App\Http\Controllers;

use App\Survey;
use App\Question;
use Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use App\Http\Requests;

class QuestionController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    public function store(Request $request, Survey $survey) {
        $arr = $request->all();
        $arr['user_id'] = Auth::id();

        $survey->questions()->create($arr);
        return back();
    }

    public function edit(Question $question) {
        $page_title = 'Survey Tool';
        $page_desc = 'Allows authorized users to manage questions, answers, etc to surveys';
        return view('survey.question.edit', compact('question', 'page_title', 'page_desc'));
    }

    public function update(Request $request, Question $question) {
        if(!in_array($request->get('question_type'), array('radio', 'checkbox'))){
            $request->request->add(['option_name' => NULL]);
        }
        $question->update($request->all());
        return redirect()->action('SurveyController@detail_survey', [$question->survey_id]);
    }
    
    public function delete_question(Question $question){
        Question::destroy($question->id);
        return redirect()->action('SurveyController@detail_survey', [$question->survey_id]);
    }

}
