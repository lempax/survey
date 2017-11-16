<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Employee;
use App\Department;
use App\UsSasLogger;

class UsSasLoggerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        if(\Auth::check() == null)
        {
            return redirect('login');
        }
    }
    
    public function index()
    {
        if(\Auth::user()->roles == 'AGENT' && \Auth::user()->department->market == 'US'){
        
        $page_title = "US SAS Logger";
        $usloggers = UsSasLogger::where('agent', \Auth::user()->uid)->with('usagent')->with('dept')->orderBy('id', 'desc')->get(); 

        return view('uslogger.index', compact('page_title', 'usloggers'));
        
        }else if(\Auth::user()->uid == '21244728' || \Auth::user()->uid == '21389390' || \Auth::user()->uid == '21431625' || \Auth::user()->uid == '21191899'){
           
        $page_title = "US SAS Logger";
        $usloggers = UsSasLogger::all(); 

        return view('uslogger.index', compact('page_title', 'usloggers'));
            
        }else{
             return redirect ('/');
        }
        
    }
    
    public function create(){
        
        if(\Auth::user()->roles == 'AGENT' && \Auth::user()->department->market == 'US'){
        $page_title = "Create SAS Logger";
        $agentid = \Auth::user()->uid;
        $agent = Employee::where('uid', $agentid)->first();
        
        $teamid = \Auth::user()->department->gid;
        $team = Department::where('gid', $teamid)->first();
        
        return view('uslogger.createlogger', compact('page_title', 'team', 'agent'));
        
        }else{
            return redirect('/uslogger');
        }
        
    }
    
    public function store(Request $request){
        
        $team = $request->input('team');
        $agent = $request->input('name');
        $orderdate = $request->input('orderdate');
        $caseid = $request->input('caseid');
        $contractid = $request->input('contractid');
        $desc = $request->input('desc');
        
        $uslogger = UsSasLogger::create([
           "team" => $team,
            "agent" => $agent,
            "orderdate" => $orderdate,
            "caseid" => $caseid,
            "contractid" => $contractid,
            "desc" => $desc
        ]);
        
        $report = UsSasLogger::find($uslogger->id);
        $agentname = Employee::find($agent);
        
        sendUsLoggerMail('uslogger.usloggeremail',
                $agentname,
                array(\Auth::user(), $agentname->superior),
                $report);
        
     
        return redirect('/uslogger');
    }
    
    public function view($id){
        $uslogger = UsSasLogger::where('id', $id)->first();
        $agent = Employee::find($uslogger->agent);
        
        if(\Auth::user()->uid == $uslogger->agent 
                || \Auth::user()->uid == '21244728' 
                || \Auth::user()->uid == '21389390' 
                || \Auth::user()->uid == '21431625' 
                || \Auth::user()->uid == '21191899'){
        
            $page_title = "Create SAS Logger";
        $agentid = \Auth::user()->uid;
        $agent = Employee::where('uid', $agentid)->first();
        
        $teamid = \Auth::user()->department->gid;
        $team = Department::where('gid', $teamid)->first();
        
        return view('uslogger.view', compact('page_title', 'team', 'agent', 'uslogger'));
        
        }else{
            return redirect('/uslogger');
        }
    }
    
    public function editView($id){
        
         $uslogger = UsSasLogger::where('id', $id)->first();
        
        if(\Auth::user()->roles == 'AGENT' && \Auth::user()->department->market == 'US'){
        $page_title = "Create SAS Logger";
        $agentid = \Auth::user()->uid;
        $agent = Employee::where('uid', $agentid)->first();
        
        $teamid = \Auth::user()->department->gid;
        $team = Department::where('gid', $teamid)->first();
        
        return view('uslogger.edit', compact('page_title', 'team', 'agent', 'uslogger'));
        
        }else{
            return redirect('/uslogger');
        }
    }
    
    public function edit($id, Request $request){
        $orderdate = $request->input('orderdate');
        $caseid = $request->input('caseid');
        $contractid = $request->input('contractid');
        $desc = $request->input('desc');
        
        $uslogger = UsSasLogger::where("id", $id)->update([
            "orderdate" => $orderdate,
            "caseid" => $caseid,
            "contractid" => $contractid,
            "desc" => $desc
        ]);
     
        return redirect('/uslogger');
    }
    
    public function delete($id, Request $request){
        
        $uslogger = UsSasLogger::destroy($id);
        return redirect ('/uslogger');
    }
    
}
