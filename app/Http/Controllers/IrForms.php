<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Employee;
use App\Department;
use App\Irform;
use App\CoachingForm;

class IrForms extends Controller
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
        $page_title = "IR Forms";
        
        $irforms = Irform::where('creator', \Auth::user()->uid)->with('agent')->with('sup')->with('dept')->orderBy('id', 'desc')->get();
        
        return view('irform.index', compact('page_title', 'irforms'));
    }
    
    
    public function create()
    {//diri ang pag view sa pag create na form
        
        if(\Auth::user()->roles == 'RTA'){
        $page_title = "Create IR Report";
        $departments = Department::where('market', 'UK')->get();
        $dids = array();
        
        foreach($departments as $department){
            array_push($dids, $department->departmentid);   
        }
        
        $agents = Employee::whereIn('departmentid', $dids)->where('roles', 'agent')->get()->sortBy('lname');
        return view('irform.create', compact('page_title', 'agents'));
        
        }else{
            return redirect('/irforms');
        }
            
    }
    
    public function store(Request $request)
    {
        $agent = $request->input('agent');
        $supid = $request->input('supervisor_id');
        $type = $request->input('type');
        $team = $request->input('team_id');
        $summary = $request->input('summary');
        $minutes = $request->input('minutes');
        $file = $request->file('attachments');
        $filesArray = $this->uploadMultipleFiles($file);
        $files = json_encode($filesArray);
        
        $irid = Irform::create([
            "agentid" => $agent,
            "supid" => $supid,
            "type" => $type,
            "team" => $team,
            "summary" => $summary,
            "attachments" => $files,
            "minutes" => $minutes,
            "creator" => \Auth::user()->uid,
            "status" => 'Pending'
                ])->id;
        
        $report = Irform::find($irid);
        
        $agentsom = Employee::find($agent);
        
        CoachingForm:: create([
            "type" => "Generic Form",
            "agent_id" => $agent,
            "creator" => $supid,
            "superior" => $agentsom->superior->superior->uid,
            "manager" => $agentsom->superior->superior->superior->uid,
            "status" => "Pending",
            "tag" => $type,
            "irid" => $irid
        ]);
        
        $agentreports = Irform::where('agentid', $agent)->get();
        $reportcount = count($agentreports); 
        sendIrMail('irform.irformcreatedmail', 
                $agentsom, 
                array(\Auth::user(), $agentsom->superior), 
                $report); 
        $mins = 0;
        foreach($agentreports as $agentreport)
        {
            $mins = $mins + $agentreport->minutes;
        }
        
        if($reportcount >= 3){
            if($mins >= 15)
            {
                // exceed for count of reports and minutes
                sendIrMail('irform.irformexceedmail', 
                $agentsom, 
                array(\Auth::user(), $agentsom->superior), 
                $agentreports);
            }
            else
            {
                // exceed for count of reports only
                sendIrMail('irform.irformexceedrepmail', 
                $agentsom, 
                array(\Auth::user(), $agentsom->superior), 
                $agentreports);
            }
        }
        else
        {
            if($mins >= 15)
            {
                // exceed for minutes only
                sendIrMail('irform.irformexceedminmail', 
                $agentsom, 
                array(\Auth::user(), $agentsom->superior), 
                $agentreports);
            }
        }
        
        return redirect('/irforms');
        
    }
    
     public function editView($id){
        $irform = Irform::where('id', $id)->first();
        
        if(\Auth::user()->uid == $irform->creator){
        $page_title = "IR Forms";
        $departments = Department::where('market', 'UK')->get();
        $dids = array();
        $attachments = json_decode($irform->attachments);
        
        foreach($departments as $department){
            array_push($dids, $department->departmentid);   
        }
        
        $agents = Employee::whereIn('departmentid', $dids)->where('roles', 'agent')->get()->sortBy('lname');
        
        return view('irform.edit', compact('page_title', 'irform', 'agents', 'attachments'));
        
        }else{
            return redirect(url('/irforms'));
        }
        
    }
    
    public function edit($id, Request $request){
        $type = $request->input('type');
        $summary = $request->input('summary');
        $minutes = $request->input('minutes');
        $file = $request->file('attachments');
        $file2 = $request->input('attachments');
        
        if($file[0] != null)
        {
            $filesArray = $this->uploadMultipleFiles($file);
             if($request->input('attachments'))
            {
                foreach($file2 as $file)
                {
                    array_push($filesArray,$file);
                }
            }
            $files = json_encode($filesArray);
        }
        else
        {
            $files = json_encode($file2);
            
        }
        
          $irform = Irform::where("id", $id)->update([
            "type" => $type,
            "summary" => $summary,
            "attachments" => $files,
            "minutes" => $minutes
        ]);
          
          return redirect('/irforms');
        
    }
    
    public function delete($id, Request $request){
        $irforms = Irform::destroy($id);
        
        return redirect('/irforms');
    }
    
    public function getAgent(Request $request)
    {
        $agentid = $request->input('id');
        $agent = Employee::find($agentid);
        
        $supervisor = $agent->superior;
        $teamid = $agent->departmentid;
        $team = Department::where('departmentid', $teamid)->first();
        
        return ['success' => true, 'supervisor' => $supervisor, 'team' => $team];
    }
    
    public function getType(Request $request)
    {
        $type = $request->input('type');
        $violation1 = 'Overbreak';
        $violation2 = 'Overlunch';
        
        if($type == 3){
            return ['success' => true, 'violation' => $violation1];
        }else{
            return ['success' => true, 'violation' => $violation2];
        }
        
    }


    public function view($id){
        $irform = Irform::where('id', $id)->first();

        if(\Auth::user()->uid == $irform->creator){
        $page_title = "IR Forms";
        $departments = Department::where('market', 'UK')->get();
        $dids = array();
        $attachments = json_decode($irform->attachments);
        
        foreach($departments as $department){
            array_push($dids, $department->departmentid);   
        }
        
        $agents = Employee::whereIn('departmentid', $dids)->where('roles', 'agent')->get()->sortBy('lname');
        
        return view('irform.view', compact('page_title', 'irform', 'agents', 'attachments'));
        
        
        }else{
            return redirect(url('/irforms'));
        }
        
    }
    
    public function uploadMultipleFiles($files)
    { 
        if($files[0] != null)
        {
            $insertData = array();
            foreach($files as $file)
            {
                $extension = $file->clientExtension();
                if($extension != "bin" )
                {
                    $destinationPath = resource_path(). '/file_attachments/irforms';
                    $filename = $file->getClientOriginalName();
                    $id = uniqid();
                    $file->move($destinationPath, $id.$filename);
                    array_push($insertData,$id.$filename);
                }
            }
            $files = $insertData;
        }
        else
        {
            $files = "";
        }
        return $files;
    }
    
    public function getDownload($file)
    {
        $file_path = resource_path('file_attachments/irforms'.$file);
        
        if(file_exists($file_path))
        {
            return response()->download($file_path);
        }
        else
        {
           
        }
    }
    
}
