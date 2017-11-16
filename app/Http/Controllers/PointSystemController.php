<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Auth;
use Mail;
use App\Employee;
use App\Department;
use App\PointSystem;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Input;

class PointSystemController extends Controller {

    private $teams;
    private $exemptions;

    public function __construct() {
        $this->middleware('auth');
        if (Auth::check()) {
            $_team = Auth::user()->teams();
            if ($_team->count() == 1 && $_team->first()->departmentid = 21395000)
                $this->teams = \App\Department::where('name', 'like', 'U%')->get();
            else
                $this->teams = $_team;
            $this->exemptions = Auth::user()->settings()->type('filtered_list')->first() ?
                    json_decode(Auth::user()->settings()->type('filtered_list')->first()->entries) : [];
        }
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return view('pointsystem.home', $data);
    }

    public function home(Request $request) {
        $pointsystem = new PointSystem();
        $breakdown = [
            'name' => 'Point System Tool',
            'headers' => ['Agent name', 'Kudos', 'CRR', 'NPS', 'AHT', 'SAS', 'Agent Postive Feedback', 'No late', 'No absent', 'OOTD', 'Trivia', 'Total points'],
            'headerStyle' => ['', '', '', '', '', '', '', '', '', '', '', ''],
            'data' => []
        ];

        $data['breakdown'] = $breakdown;
        $data['page_title'] = 'Point System Tool';
        $data['perfurl'] = 'pointsystem';

        $data['rows'] = Auth::user()->subordinates();
        return view('pointsystem.home', $data);
    }

    public function retrieve($personid) {
        $pointsystem = new PointSystem();
//        
        $get_info = DB::table("pointsystem")
                ->where("personid", $personid)  
                ->get();
        $data['content'] = $get_info;
        $data['rows'] = $pointsystem->get();
        $data['page_title'] = 'Point System Tool';
        $data['perfurl'] = 'pointsystem';
        $data['personid'] = $personid;
        return view('pointsystem.edit', $data);
    }

    public function update(Request $request, $personid) {

        $holder = date('Y-m-d');
        $wkholder = date("W", strtotime($holder));
        $personid = $request->get('personid');
        $updateData = array(
            'personid' => $request->get('personid'),
            'kudos' => $request->get('kudos'),
            'crr' => $request->get('crr'),
            'nps' => $request->get('nps'),
            'aht' => $request->get('aht'),
            'sas' => $request->get('sas'),
            'agentposfb' => $request->get('agentposfb'),
            'nolate' => $request->get('nolate'),
            'noabsent' => $request->get('noabsent'),
            'ootd' => $request->get('ootd'),
            'trivia' => $request->get('trivia'),
            'updated_at' => date('Y-m-d', strtotime($request->get('updated_at'))),
            'week' => $wkholder
        );

        PointSystem::where('personid', $personid)->update($updateData);
        //PointSystem::create($updateData);
        return redirect('pointsystem/home');
    }

}
