<?php

namespace App\Http\Controllers;

use Auth;
use Mail;
use File;
use Excel;
use App\Survey;
use App\Answer;
use App\Question;
use App\Employee;
use Dompdf\Dompdf;
use App\Department;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\URL;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Barryvdh\DomPDF\Facade as PDF;

class SurveyController extends Controller {

    private $teams;
    private $exemptions;

    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {
        return Redirect::to("/survey/home");
    }

    public function home(Request $request) {
        if (in_array(Auth::user()->roles, array('MANAGER', 'SUPERVISOR', 'SOM', 'SAS', 'IT'))) {
            $agents = Employee::where('active', 1)->get();

            foreach ($agents AS $agent) {
                if ($agent->email != '') {
                    $emails[] = '"' . $agent->email . '"';
                }
            }

            $_emails = implode(",", $emails);
            $surveys = Survey::where('user_id', Auth::user()->uid)->get();
            $page_title = '1&1 Survey Management System';
            $page_desc = 'Allows authorized users to manage questions, answers, etc to surveys';
            return view('survey.home', compact('surveys', 'page_title', 'page_desc', 'perfurl', '_emails'));
        }
    }

    public function create(Request $request, Survey $survey) {
        $ids = explode(',', $request->get('invited'));

        foreach ($ids AS $id) {
            $uid = \App\Employee::where('email', $id)->first();
            $uids[] = $uid->uid;
        }

        $request->request->add(['status' => 'true',
            'invited' => json_encode($uids)]);
        $arr = $request->all();
        $arr['user_id'] = Auth::id();
        $surveyItem = $survey->create($arr);

        $this->email($ids, $surveyItem->id, $request->get('title'));
        return Redirect::to("/survey/home");
    }

    public function email($emails, $insert_id, $title) {
        $data['url'] = '<a href="/survey/view/' . $insert_id . '"></a>';
        $data['title'] = '1&1 Survey Management System';
        $data['survey_name'] = ucwords($title);
        foreach ($emails AS $email) {
            $user = \App\Employee::where('email', $email)->first();
            $data['name'] = $user->fname;
            Mail::send('survey.survey.email', $data, function ($message) use ($user) {
                $message->from('no-reply@mis-ews.ph.schlund.net', 'MIS-EWS');
                $message->to($user->email, $user->name)->subject('1&1 Survey System');
            });
        }
    }

    public function detail_survey(Survey $survey, Question $question) {
        if (in_array(Auth::user()->roles, array('MANAGER', 'SUPERVISOR', 'SOM', 'SAS', 'IT'))) {
            $page_title = '1&1 Survey Management System';
            $page_desc = 'Allows Authorized users to create and manage questions for surveys.';
            $survey->load([
                'questions' => function($query) {
                    $query->orderBy('order', 'ASC');
                }]);
            return view('survey.survey.detail', compact('survey', 'page_title', 'page_desc', 'question'));
        }
    }

    public function edit(Survey $survey) {
        return view('survey.survey.edit', compact('survey'));
    }

    public function update(Request $request, Survey $survey) {
        $survey->update($request->only(['title', 'description']));
        return redirect()->action('SurveyController@detail_survey', [$survey->id]);
    }

    public function view_survey(Survey $survey) {
        $page_title = '1&1 Survey Management System';
        $page_desc = 'Allows users to start taking the survey.';
        //if (in_array(Auth::user()->roles, array('MANAGER', 'SUPERVISOR', 'SOM', 'SAS', 'IT', 'AGENT', 'L2'))) {
            $is_answered = Answer::where('user_id', Auth::user()->uid)->where('survey_id', $survey->id)->first();

            if (isset($is_answered)) {
                return Redirect::to("/survey/success");
            } else {
                $survey_mail = array();
                $questions = (array) $survey->questions;

                shuffle($questions);
                $_questions = $questions[0];

                for ($x = 0; $x < count($_questions); $x++) {
                    $survey_mail[] = $_questions[$x];
                }

//                if (in_array(Auth::user()->departmentid, array(21386573, 21386574, 21440024, 21191177, 21241963))) {
//                    shuffle($survey_mail);
//                }

                if($survey->id == 9){
                    $view = 'sga_view';
                }else{
                    $view = 'mail_view';
                }
            }
//        } else {
//            $survey->option_name = unserialize($survey->option_name);
//            $view = 'view';
//        }
        return view('survey.survey.' . $view . '', compact('survey', 'page_title', 'page_desc', 'survey_mail'));
    }

    public function view_survey_answers(Survey $survey) {
        if (in_array(Auth::user()->roles, array('MANAGER', 'SUPERVISOR', 'SOM', 'SAS', 'IT'))) {
            $page_title = '1&1 Survey Management System';
            $page_desc = 'Allows users to start taking the survey.';
            $exam_answers = Answer::where('survey_id', $survey->id)->groupBy('answer_id')->get();
            $survey->load('questions.answers');
            return view('survey.answer.mail_exam_view', compact('survey', 'page_title', 'page_desc', 'exam_answers'));
        }
    }
    
    public function view_scores(Survey $survey){
        if (in_array(Auth::user()->roles, array('MANAGER', 'SUPERVISOR', 'SOM', 'SAS', 'IT'))) {
            $page_title = '1&1 Survey Management System';
            $page_desc = 'Allows users to start taking the survey.';
            $survey->load('questions.answers');
            return view('survey.answer.view', compact('survey', 'page_title', 'page_desc', 'exam_answers'));
        }
    }

    public function open_answer($answer_id, $user_id) {
        if (in_array(Auth::user()->roles, array('MANAGER', 'SUPERVISOR', 'SOM', 'SAS', 'IT'))) {
            $page_title = '1&1 Survey Management System';
            $page_desc = 'You may view survey answers for specific employee.';
            $test = Answer::where('answer_id', $answer_id)->where('user_id', $user_id)->orderBy('question_id', 'ASC')->get();
            $time_answered = '';
            $exam_answers = array();
            foreach ($test AS $_test) {
                $question = Question::where('id', $_test->question_id)->where('survey_id', $_test->survey_id)->first();
                $exam_answers[] = array(
                    'title' => $question->title,
                    'answer' => $_test->answer,
                    'optional_answer' => $_test->optional_answer
                );
                $time_answered = $_test->created_at;
                $survey_id = $_test->survey_id;
            }

            $agent = Employee::where('uid', $user_id)->first();
            if($survey_id == 8){
                return view('survey.answer.open_answer_uk', compact('page_title', 'page_desc', 'exam_answers', 'agent', 'time_answered'));
            }else{
                return view('survey.answer.open_answer', compact('page_title', 'page_desc', 'exam_answers', 'agent', 'time_answered'));
            }
        }
    }

    public function delete_survey(Survey $survey) {
        $survey->delete();
        return Redirect::to("/survey/home");
    }

    public function thankyou() {
        $page_title = '1&1 Survey Management System';
        $page_desc = 'Allows users to start taking the survey.';
        return view('survey.answer.thankyou', compact('page_title', 'page_desc'));
    }

    public function sort_order(Survey $survey, Request $request) {
        foreach ($request->order AS $key => $order) {
            Question::where('id', $order)->update(['order' => $key]);
        }
        return redirect()->action('SurveyController@detail_survey', [$survey->id]);
    }

    public function set_status(Request $request) {
        Survey::where('id', $request->get('id'))->update(['status' => $request->get('status')]);
    }

    public function charts() {
        $page_title = 'Survey Answer Charts';
        $page_desc = 'Displays charts for all the answers to specific survey.';
        return view('survey.chart', compact('page_title', 'page_desc'));
    }
    
    public function generate_pdf($answer_id, $user_id){
        $data['page_title'] = '1&1 Survey Management System';
        $data['page_desc'] = 'You may view exam answers for specific employee.';
        $test = Answer::where('answer_id', $answer_id)->where('user_id', $user_id)->orderBy('question_id', 'ASC')->get();
        $data['time_answered'] = '';
        $data['exam_answers'] = array();
        foreach ($test AS $_test) {
            $question = Question::where('id', $_test->question_id)->where('survey_id', $_test->survey_id)->first();
            $data['exam_answers'][] = array(
                'title' => $question->title,
                'answer' => $_test->answer,
                'optional_answer' => $_test->optional_answer
            );
            $data['time_answered'] = $_test->created_at;
            $survey_id = $_test->survey_id;
        }

        if(strpos(Auth::user()->department->name, 'mail') !== false){
            $image = 'mailcom.jpg';
        }else if(strpos(Auth::user()->department->name, 'fasthost') !== false){
            $image = 'fasthosts.jpg';
        }else{
            $image = '1and1.jpg';
        }

        $data['agent'] = Employee::where('uid', $user_id)->first();
        $data['image'] = $image;
        $pdf = PDF::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);
        if($survey_id == 8){
            $pdf = PDF::loadView('survey.answer.pdf_uk', $data);
        }else{
            $pdf = PDF::loadView('survey.answer.pdf', $data);
        }
        
        return $pdf->download(''.$data["agent"]->lname.'-'.$data["agent"]->fname.'.pdf');
    }
    
    public function generate_excel($id){
        $data['page_title'] = '1&1 Survey Management System';
        $data['page_desc'] = 'You may view exam answers for specific employee.';
        
        Excel::create('Survey Answers', function($excel) use($id) {
            $excel->sheet('Survey Answers', function($sheet) use($id) {
                $surveyid = $id;
                $employees = array();
                $arr_values = array();
                $headers = array();

                $questions = Question::where('survey_id', $id)->get();

                $headers[] = 'Employee Name';
                $headers[] = 'Team';
                $row = 1;

                foreach($questions AS $question){
                    $headers[] =  'Question'.$row;
                    $row++;
                }
              //  $headers[] = 'Optional Answer';
                $excel = Answer::where('survey_id', $surveyid)->groupBy('answer_id')->get();

                foreach($excel AS $_excel){
                    $employees[] = $_excel->user_id;
                }

                foreach($employees AS $employee){
                    $emp = Employee::where('uid', $employee)->first();
                    $answers = Answer::where('survey_id', $surveyid)->where('user_id', $employee)->orderBy('question_id', 'ASC')->get();
                    $team = Department::where('departmentid', $emp->departmentid)->first();
                    $arr_values[] = array(
                        'uid' => $emp->name,
                        'team' => $team->name,
                        'answers' => $answers->pluck('answer'),
                        'optional_answers' => $answers->pluck('optional_answer')
                    );
                }
                
                $sortArray = array();

                foreach($arr_values as $person){ 
                    foreach($person as $key=>$value){
                        if(!isset($sortArray[$key])){
                            $sortArray[$key] = array();
                        }
                        $sortArray[$key][] = $value;
                    }
                }
                
                array_multisort($sortArray['team'],SORT_DESC,$arr_values); 
                if($surveyid == 26){
                    $_view = 'uk_excel_view';
                }else{
                    $_view = "excel_view";
                }
                
            $sheet->loadView('survey.answer.'.$_view.'', compact('page_title', 'page_desc', 'arr_values', 'headers'));
            });

            $excel->sheet('Survey Questions', function($sheet2) use($id) {
                $questions = Question::where('survey_id', $id)->get();

                $row = 1;
                foreach($questions AS $question){
                    $headers[] =  array(
                        'title' => $question->title,
                        'id' => 'Question '. $row
                        );
                    $row++;
                }

            $sheet2->loadView('survey.answer.excel_questions', compact('page_title', 'page_desc', 'headers'));
            });
        })->export('xlsx');
    }
    
    public function edit_answer(Survey $survey){
        $page_title = '1&1 Survey Management System';
        $page_desc = 'Allows users to start taking the survey.';

        $answer = Answer::where('user_id', Auth::user()->uid)->where('survey_id', 8)->where('question_id', 51)->get();
        $survey_mail = array();
        $questions = (array) $answer;
        shuffle($questions);
        $_questions = $questions[0];

        for ($x = 0; $x < count($_questions); $x++) {
            $survey_mail[] = $_questions[$x];
        }

        if (in_array(Auth::user()->departmentid, array(21386573, 21386574, 21440024, 21191177, 21241963))) {
            shuffle($survey_mail);
        }

        $view = 'edit_answer';
        return view('survey.survey.' . $view . '', compact('survey', 'page_title', 'page_desc', 'survey_mail'));
    }
}