<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Employee;
use App\CoachingForm;
use App\Comment;
use App\Department;
use App\Http\Requests;
use App\ActionPlan;
use Mail;
use File;
use App\Coachingtarget;
use Excel;
use App\Irform;


class CoachingFormController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        if(\Auth::check() == null)
        {
            return redirect('login');
        }
    }
    public function index(Request $request)
    {
        if (\Auth::user()->roles == "IT")
        {
            $forms = CoachingForm::all();
            $page_title = "Coaching Form Tool";
            $sortForm = null;
            $monthForm = null;
            $agentForm = null;
            return view('coachingform.index' , compact('page_title','forms','sortForm','monthForm','agentForm'));
        }
        if($request->input('chooseForm') == 'Completed')
        $page_title = "Completed Coaching Forms";
        else if($request->input('chooseForm') == 'Pending')
        $page_title = "Pending Coaching Forms";
        else if($request->input('chooseForm') == 'Ongoing')
        $page_title = "Ongoing Coaching Forms";
        else
        $page_title = "All Coaching Forms";
        //$agents = Employee::where('roles','agent')->where('active','1')->where()->orderBy('lname','asc')->get();
        if (\Auth::user()->roles == "SUPERVISOR")
        {
            $agents = \Auth::user()->subordinates();
        }
        else if (\Auth::user()->roles == "L2")
        {
            $userDepartment = \Auth::user()->department()->get()->lists('market');
            $market = $userDepartment[0];
            $agents = Employee::join('departments', 'employees.departmentid', '=', 'departments.departmentid')->where('roles', 'agent')->where('active', '1')->where('market', $market)->orderBy('lname','asc')->get();
        }
        //-----------------
        // form Sort
        //------------------
        // if agent
        if($request->input('chooseFormAgent'))
        {
            if($request->input('chooseFormAgent') == 'All')
            {
                $forms = CoachingForm::where('agent_id',\Auth::user()->uid)->where('rstatus', 1)->with('createdBy')->with('agent')->orderBy('id', 'desc')->get();
            }
            else if($request->input('chooseFormAgent'))
            {
                $forms = CoachingForm::where('agent_id',\Auth::user()->uid)->where('status',$request->input('chooseFormAgent'))->where('rstatus', 1)->with('createdBy')->with('agent')->orderBy('id', 'desc')->get();
            }
            else
            {
                $forms = CoachingForm::where('agent_id',\Auth::user()->uid)->where('rstatus', 1)->with('createdBy')->orWhere('creator',\Auth::user()->uid)->where('rstatus', 1)->with('agent')->orderBy('id', 'desc')->get();
            }
        }
        //----------------------------------------------------------------------------------------------------------------------------------------------------------------------
        // if not agent
        
        else if ($request->input('chooseForm'))
        {
            $teams = \Auth::user()->teams();
            $nit = array("UK Offshore Support Team 02", "UK Offshore Support Team 01", "Customer Service Offshore US 02",
            "Customer Service Offshore US 01", "UK Training Team", "Cebu Sales After Support - UK", "Special Task Cebu - UK",
            "Customer Service Offshore UK");
            $inTeams = array();
            foreach($teams as $team)
            {
                if(!in_array($team->name,$nit))
                {
                    array_push($inTeams,$team->admin);
                }
            }
            array_push($inTeams,\Auth::user()->uid);
            
            if($request->input('chooseForm') == 'All')
            {
                if($request->input('agentForm'))
                {
                    if($request->input('monthForm'))
                    {
                        //query all report->with selected agent->with selected month
                        $forms = CoachingForm::whereMonth('created_at', '=', $request->input('monthForm'))->where('creator', $request->input('agentForm'))->orWhere('agent_id', $request->input('agentForm'))->whereMonth('created_at', '=', $request->input('monthForm'))->with('createdBy')->with('agent')->orderBy('id', 'desc')->get();
                    }
                    else
                    {
                        //query all report->with selected agent
                        $forms = CoachingForm::where('agent_id', $request->input('agentForm'))->where('creator', $request->input('agentForm'))->with('createdBy')->with('agent')->orderBy('id', 'desc')->get();
                    }
                        
                }
                else if($request->input('monthForm'))
                { 
                    if($request->input('agentForm'))
                    {
                        //query all report->with selected agent->with selected month
                        $forms = CoachingForm::whereMonth('created_at', '=', $request->input('monthForm'))->where('creator', $request->input('agentForm'))->orWhere('agent_id', $request->input('agentForm'))->whereMonth('created_at', '=', $request->input('monthForm'))->with('createdBy')->with('agent')->orderBy('id', 'desc')->get();
                    }
                    else
                    {
                        //query all report->with selected month
                        $forms = CoachingForm::whereIn('creator', $inTeams)->whereMonth('created_at', '=', $request->input('monthForm'))->orWhereIn('agent_id', $inTeams)->whereMonth('created_at', '=', $request->input('monthForm'))->orderBy('id', 'desc')->get();
                    }
                }
                else
                {
                    //query all report
                    $forms = CoachingForm::whereIn('creator', $inTeams)->orWhereIn('agent_id', $inTeams)->orderBy('id', 'desc')->get();
                }
            }
            else if($request->input('chooseForm'))
            {
                if($request->input('agentForm'))
                {
                    if($request->input('monthForm'))
                    {
                        //query report with selected status->with selected agent->selected Month
                        $forms = CoachingForm::where('status',$request->input('chooseForm'))->where('agent_id', $request->input('agentForm'))->whereMonth('created_at', '=', $request->input('monthForm'))->orWhere('status',$request->input('chooseForm'))->where('creator', $request->input('agentForm'))->whereMonth('created_at', '=', $request->input('monthForm'))->with('createdBy')->with('agent')->orderBy('id', 'desc')->get();
                    }
                    else
                    {
                        //query report with selected status->with selected agent
                        $forms = CoachingForm::where('status',$request->input('chooseForm'))->where('agent_id', $request->input('agentForm'))->orWhere('status',$request->input('chooseForm'))->where('creator', $request->input('agentForm'))->with('createdBy')->with('agent')->orderBy('id', 'desc')->get();
                    }
                        
                }
                else if($request->input('monthForm'))
                {
                    if($request->input('agentForm'))
                    {
                        //query report with selected status->with selected month->with selected agent
                        $forms = CoachingForm::where('status',$request->input('chooseForm'))->where('agent_id', $request->input('agentForm'))->whereMonth('created_at', '=', $request->input('monthForm'))->orWhere('status',$request->input('chooseForm'))->where('creator', $request->input('agentForm'))->whereMonth('created_at', '=', $request->input('monthForm'))->with('createdBy')->with('agent')->orderBy('id', 'desc')->get();
                    }
                    else
                    {
                        //query report with selected status->with selected month
                        $forms = CoachingForm::whereIn('creator', $inTeams)->whereMonth('created_at', '=', $request->input('monthForm'))->where('status', $request->input('chooseForm'))->orWhereIn('agent_id', $inTeams)->whereMonth('created_at', '=', $request->input('monthForm'))->where('status', $request->input('chooseForm'))->orderBy('id', 'desc')->get();
                    }
                }
                else
                {
                    //query report with selected status
                    $forms = CoachingForm::whereIn('creator', $inTeams)->where('status', $request->input('chooseForm'))->orWhereIn('agent_id', $inTeams)->where('status', $request->input('chooseForm'))->orderBy('id', 'desc')->get();
                }
                
            }
            else
            {
                if(\Auth::user()->roles == "AGENT")
                {
                    //query all report for the agent
                    $forms = CoachingForm::where('agent_id',\Auth::user()->uid)->with('createdBy')->with('agent')->orderBy('id', 'desc')->get();                   
                }
                else
                {
                    //querry all report
                    $forms = CoachingForm::whereIn('creator', $inTeams)->orWhereIn('agent_id', $inTeams)->orderBy('id', 'desc')->get();
                }
            }
        }
        
        else if($request->input('monthForm'))
        {
            $teams = \Auth::user()->teams();
            $nit = array("UK Offshore Support Team 02", "UK Offshore Support Team 01", "Customer Service Offshore US 02",
            "Customer Service Offshore US 01", "UK Training Team", "Cebu Sales After Support - UK", "Special Task Cebu - UK",
            "Customer Service Offshore UK");
            $inTeams = array();
            foreach($teams as $team)
            {
                if(!in_array($team->name,$nit))
                {
                    array_push($inTeams,$team->admin);
                }
            }
            array_push($inTeams,\Auth::user()->uid);
            if($request->input('chooseForm'))
            {
                if($request->input('chooseForm') == "All")
                {
                    if($request->input('agentForm'))
                    {
                        //query all report->with selected month->with selected agent
                        $forms = CoachingForm::whereMonth('created_at', '=', $request->input('monthForm'))->where('creator', $request->input('agentForm'))->orWhere('agent_id', $request->input('agentForm'))->whereMonth('created_at', '=', $request->input('monthForm'))->with('createdBy')->with('agent')->orderBy('id', 'desc')->get();
                    }
                    else
                    {
                        //query all report -> with selected month
                        $forms = CoachingForm::whereIn('creator', $inTeams)->whereMonth('created_at', '=', $request->input('monthForm'))->orWhereIn('agent_id', $inTeams)->whereMonth('created_at', '=', $request->input('monthForm'))->orderBy('id', 'desc')->get();
                    }
                }
                else if ($request->input('chooseForm'))
                {
                    if($request->input('agentForm'))
                    {
                        //query report with selected status->with selected month-> with selected agent
                        $forms = CoachingForm::where('status',$request->input('chooseForm'))->where('agent_id', $request->input('agentForm'))->whereMonth('created_at', '=', $request->input('monthForm'))->orWhere('status',$request->input('chooseForm'))->where('creator', $request->input('agentForm'))->whereMonth('created_at', '=', $request->input('monthForm'))->with('createdBy')->with('agent')->orderBy('id', 'desc')->get();
                    }
                    else
                    {
                        //query report with selected status->with selected month
                        $forms = CoachingForm::whereIn('creator', $inTeams)->whereMonth('created_at', '=', $request->input('monthForm'))->where('status', $request->input('chooseForm'))->orWhereIn('agent_id', $inTeams)->whereMonth('created_at', '=', $request->input('monthForm'))->where('status', $request->input('chooseForm'))->orderBy('id', 'desc')->get();
                    }
                }
                else
                {
                    //query all report with selected month
                   $forms = CoachingForm::whereIn('creator', $inTeams)->whereMonth('created_at', '=', $request->input('monthForm'))->orWhereIn('agent_id', $inTeams)->whereMonth('created_at', '=', $request->input('monthForm'))->orderBy('id', 'desc')->get();
                }
            }
            else if ($request->input('agentForm'))
            {
                //query report for selected agent with selected month
                $forms = CoachingForm::whereMonth('created_at', '=', $request->input('monthForm'))->where('creator', $request->input('agentForm'))->orWhere('agent_id', $request->input('agentForm'))->whereMonth('created_at', '=', $request->input('monthForm'))->with('createdBy')->with('agent')->orderBy('id', 'desc')->get();
            }
            else
            {
                //query all report with selected month
                $forms = CoachingForm::whereIn('creator', $inTeams)->whereMonth('created_at', '=', $request->input('monthForm'))->orWhereIn('agent_id', $inTeams)->whereMonth('created_at', '=', $request->input('monthForm'))->orderBy('id', 'desc')->get();                
            }
        }
        else if($request->input('agentForm'))
        {
            $teams = \Auth::user()->teams();
            $nit = array("UK Offshore Support Team 02", "UK Offshore Support Team 01", "Customer Service Offshore US 02",
            "Customer Service Offshore US 01", "UK Training Team", "Cebu Sales After Support - UK", "Special Task Cebu - UK",
            "Customer Service Offshore UK");
            $inTeams = array();
            foreach($teams as $team)
            {
                if(!in_array($team->name,$nit))
                {
                    array_push($inTeams,$team->admin);
                }
            }
            array_push($inTeams,\Auth::user()->uid);
            if($request->input('chooseForm'))
            {
                if($request->input('chooseForm') == "All")
                {
                    if($request->input('monthForm'))
                    {
                        //query all report->with selected agent->with month
                        $forms = CoachingForm::whereMonth('created_at', '=', $request->input('monthForm'))->where('creator', $request->input('agentForm'))->orWhere('agent_id', $request->input('agentForm'))->whereMonth('created_at', '=', $request->input('monthForm'))->with('createdBy')->with('agent')->orderBy('id', 'desc')->get();
                    }
                    else
                    {
                        //query all report with selected agent
                        $forms = CoachingForm::where('creator', $request->input('agentForm'))->orWhere('agent_id', $request->input('agentForm'))->with('createdBy')->with('agent')->orderBy('id', 'desc')->get(); 
                    }
                }
                else if ($request->input('chooseForm'))
                {
                    if($request->input('monthForm'))
                    {
                        //query report with selected status->with agent ->with month
                        $forms = CoachingForm::where('status',$request->input('chooseForm'))->where('agent_id', $request->input('agentForm'))->whereMonth('created_at', '=', $request->input('monthForm'))->orWhere('status',$request->input('chooseForm'))->where('creator', $request->input('agentForm'))->whereMonth('created_at', '=', $request->input('monthForm'))->with('createdBy')->with('agent')->orderBy('id', 'desc')->get();
                    }
                    else
                    {
                        //query report wit hselected statys -> with agent
                        $forms = CoachingForm::where('status',$request->input('chooseForm'))->where('agent_id', $request->input('agentForm'))->orWhere('status',$request->input('chooseForm'))->where('creator', $request->input('agentForm'))->with('createdBy')->with('agent')->orderBy('id', 'desc')->get();
                    }
                }
                else
                {
                   if($request->input('monthForm'))
                   {
                       
                       $forms = CoachingForm::whereMonth('created_at', '=', $request->input('monthForm'))->where('agent_id', $request->input('agentForm'))->with('createdBy')->with('agent')->orderBy('id', 'desc')->get(); 
                   }
                   else
                   {
                        $forms = CoachingForm::where('agent_id', $request->input('agentForm'))->with('createdBy')->with('agent')->orderBy('id', 'desc')->get(); 
                   }
                }
            }
            else if ($request->input('monthForm'))
            {
                $forms = CoachingForm::whereMonth('created_at', '=', $request->input('monthForm'))->where('agent_id', $request->input('agentForm'))->with('createdBy')->with('agent')->orderBy('id', 'desc')->get();                    
            }
            else
            {
                $forms = CoachingForm::where('agent_id', $request->input('agentForm'))->orWhere('creator',$request->input('agentForm'))->with('createdBy')->with('agent')->orderBy('id', 'desc')->get();                    
            }
        } 
        else
            {
            $teams = \Auth::user()->teams();
            $nit = array("UK Offshore Support Team 02", "UK Offshore Support Team 01", "Customer Service Offshore US 02",
            "Customer Service Offshore US 01", "UK Training Team", "Cebu Sales After Support - UK", "Special Task Cebu - UK",
            "Customer Service Offshore UK");
            $inTeams = array();
            foreach($teams as $team)
            {
                if(!in_array($team->name,$nit))
                {
                    array_push($inTeams,$team->admin);
                }
            }
            array_push($inTeams,\Auth::user()->uid);
                if(\Auth::user()->roles == "AGENT")
                {
                    $forms = CoachingForm::where('agent_id',\Auth::user()->uid)->where('rstatus', 1)->with('createdBy')->orderBy('id', 'desc')->with('agent')->get();                   
                }
                else
                {
                    //1
                    $forms = CoachingForm::whereIn('creator', $inTeams)->orWhereIn('agent_id', $inTeams)->orderBy('id', 'desc')->get();
                }
            }
        
        // end of form sort
        if($request->input('chooseForm'))
            $sortForm = $request->input('chooseForm');
        else
            $sortForm = null;
        if($request->input('monthForm'))
            $monthForm = $request->input('monthForm');
        else
            $monthForm = null;
        if($request->input('agentForm'))
            $agentForm = $request->input('agentForm');
        else
            $agentForm = null;
        return view('coachingform.index' , compact('page_title','agents','forms','sortForm','monthForm','agentForm'));
    }
    
    
    public function createForm(Request $request)
    {  
        $form = null;
        $role = \Auth::user()->roles;
        $page_title = $request->input('type');
        $agent_id = $request->input('agent_id');
        $agent = Employee::findOrFail($agent_id);
        $userMarket = $agent->department()->get()->lists('market')->first();   
        if ($request->input('type') == "Generic Form")
        {
            return view('coachingform.genericForm' , compact('page_title','agent','form', 'userMarket'));
        }
        else
        {
            return view('coachingform.statisticsform' , compact('page_title','agent','form', 'role','userMarket'));
        } 
    }
    public function addForm(Request $request)
    {
        $type = $request->input('type');
        /* -----------------------------------------*/
        $agent_id = $request->input('agent_id');
        $agent = Employee::findOrFail($agent_id);
        /* -----------------------------------------*/
        $creator = \Auth::user()->uid;
        $superior = $agent->superior->uid;
        $manager = $agent->superior->superior->uid;
        if($type == 'Statistics Form')
        $cont = json_encode(array($request->input('content'),$request->input('comments'),$request->input('factors')));
        else
        $cont = $request->input('content');
        $content = $cont;
        $status = 'Pending';
        $file = $request->file('attachments');
        $filesArray = $this->uploadMultipleFiles($file);
        $files = json_encode($filesArray);
        $tag = $request->input('tag');
        $resp = CoachingForm::create([
            'type' => $type,
            'agent_id' => $agent_id,
            'creator' => $creator,
            'superior' => $superior,
            'manager' => $manager,
            'content' => $content,
            'status' => $status,
            'attachment' => $files,
            'tag' => $tag,
            'rstatus' => 1
        ]);
        
        $form = CoachingForm::find($resp->id);
        sendMail("coachingform.formCreatedMail",
            \Auth::user(),
            array($agent),
            $form 
        );
        sendMail("coachingform.makeActionPlan",
            $agent,
            array(\Auth::user()),
            $form
        );
        return redirect('coachingform');
    }
    
    public function viewForm($id)
    {
        $form = CoachingForm::where('id',$id)->first();
        $userMarket = \Auth::user()->department()->get()->lists('market')->first();
        
        $include_list = array(
            $form->agent->uid,
            $form->createdBy->uid,
            $form->createdBy->superior->uid,
            $form->createdBy->superior->superior->uid
        );
        
        if($form->createdBy->roles == 'L2'){
            array_push($include_list,$form->createdBy->superior->superior->superior->uid);
            }
       
        if(!in_array(\Auth::user()->uid, $include_list)) 
        {
            if (\Auth::user()->roles == "IT")
            {
                $page_title = $form->type;
                $actions = ActionPlan::where('coachingform_id',$id)->get();
                $comments = Comment::where('coachingform_id',$id)->with('createdBy')->get();
                $content = json_decode($form->content);
                $attachments = json_decode($form->attachment);
                if($form->type == 'Generic Form')
                {
                    return view('coachingform.genericForm', compact('form','actions','comments', 'attachments','page_title', 'userMarket', 'agent'));
                }
                else
                {
                    return view('coachingform.statisticsform', compact('form','actions','comments','content', 'attachments','page_title', 'userMarket', 'agent'));
                }
            }
            else
            {
                return redirect("/coachingform");
            }
            
        }
        else
        {
            $page_title = $form->type;
            $actions = ActionPlan::where('coachingform_id',$id)->get();
            $comments = Comment::where('coachingform_id',$id)->with('createdBy')->get();
            $content = json_decode($form->content);
            $attachments = json_decode($form->attachment);
            if($form->type == 'Generic Form')
            {
                return view('coachingform.genericForm', compact('form','actions','comments', 'attachments','page_title', 'userMarket', 'agent'));
            }
            else
            {
                return view('coachingform.statisticsform', compact('form','actions','comments','content', 'attachments','page_title', 'userMarket', 'agent'));
            }
        }
    }
    
    public function deleteForm(Request $request)
    {
        $id = $request->input('id');
        $var = CoachingForm::destroy($id);
        
        return response ()->json ($var);
    }
    
    public function addActionPlan($request, $id)
    {
        $resp = ActionPlan::create([
            'coachingform_id' => $id,
            'status' => 'Pending',
            'text' => $request['text'],
            'target_date' => date("Y-m-d",strtotime($request['target_date'])),
            'followup_date' => date("Y-m-d",strtotime($request['followup_date']))
        ]);
        
        
        return response ()->json ( $resp );
    }
    
    public function delActionPlan($id)
    {
        $form = ActionPlan::where('coachingform_id',$id)->delete();
        return response ()->json ( $form );
    }
    
    public function addComment(Request $request,$id)
    {
        $resp = Comment::create([
            'coachingform_id' => $id,
            'uid' => \Auth::user()->uid,
            'comment' => $request->input('content'),
            'status' => $request->input('stats')
         ]);
       
        $creator = $resp->createdBy;
        
        $form = coachingForm::findOrFail($id);
        $agent = Employee::findOrFail($form->agent_id);
        $creator = Employee::findOrFail($form->creator);
        
        $com = Comment::find($resp->id);
        if(\Auth::user()->roles == "AGENT" || \Auth::user()->roles == "L2")
        {
            $to = $creator;
            $ccs = array(\Auth::user(),$creator->superior);
        }
        else if(\Auth::user()->roles == "SUPERVISOR")
        {
            $to = $agent;
            $ccs = array(\Auth::user(),\Auth::user()->superior);
        }
        else if (\Auth::user()->roles == "SOM")
        {
            $to = $creator;
            $ccs = array(\Auth::user(),$agent);
        }
        sendMail("coachingform.newCommentMail",
        $to,
        $ccs,
        $com
        );
       
        return response ()->json (['data' => $resp, 'creator' => $creator]);
    }
    
    public function delComment(Request $request,$id)
    {
        $form = Comment::destroy($id);
        return response ()->json ( $form );
    }
    public function editForm($id)
    {
       
        $role = \Auth::user()->roles;
        $form = CoachingForm::where('id',$id)->first();
        $actions = ActionPlan::where('coachingform_id',$id)->get();
        $comments = Comment::where('coachingform_id',$id)->with('createdBy')->get();
        $agent = $form->agent;
        $content = json_decode($form->content,true);
        $page_title = $form->type;
        $attachments = json_decode($form->attachment);
        $userMarket = \Auth::user()->department()->get()->lists('market')->first();
        if($form->type == 'Generic Form')
        {
            return view('coachingform.editGeneric', compact('form','role','actions','comments','attachments','page_title','agent', 'userMarket'));
        }
        else
        {
            return view('coachingform.editstatisticsform', compact('page_title','agent','form','role','content','actions','comments','attachments', 'userMarket'));
        }
    }
    
    public function updateForm(Request $request,$id)
    {
        $type = $request->input('type');
        $form = CoachingForm::where('id',$id)->first();
        $tag = $request->input('tag');
        if(\Auth::user()->uid  == $request->input("agent_id"))
        {
            $this->delActionPlan($id);
              if($request->input('actionplan'))
               {
               $actionplans = $request->input('actionplan');
               foreach($actionplans as $actionplan)
               {
                   $this->addActionPlan($actionplan,$id);
               }
               }
               
            $form = coachingForm::findOrFail($id);
            $agent = Employee::findOrFail($form->agent_id);
            $creator = Employee::findOrFail($form->creator);

            if(\Auth::user()->roles == "AGENT" || \Auth::user()->roles == "L2")
            {
                $to = $creator;
                $ccs = array(\Auth::user(),$creator->superior);
            }
            else if(\Auth::user()->roles == "SUPERVISOR")
            {
                $to = $agent;
                $ccs = array(\Auth::user(),\Auth::user()->superior);
            }
            else if (\Auth::user()->roles == "SOM")
            {
                $to = $creator;
                $ccs = array(\Auth::user(),$agent);
            }
            else if (\Auth::user()->roles == "MANAGER")
            {
                $to = $creator;
                $ccs = array(\Auth::user(),$agent);
            }
            sendMail("coachingform.actionPlanAdded",
            $to,
            $ccs,
            $form
            );
        }
        else 
        {
            if($type == 'Statistics Form')
            $cont = json_encode(array($request->input('content'),$request->input('comments'),$request->input('factors')));
            else
            $cont = $request->input('content');
            
        $content = $cont;
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
        
        $rstatus = $form->rstatus;
        
        $resp = CoachingForm::where('id', $id)->update([
            'content' => $content,
            'attachment' => $files,
            'tag' => $tag,
            'rstatus' => 1
        ]);
        
        $form = coachingForm::findOrFail($id);
        $agent = Employee::findOrFail($form->agent_id);
        $creator = Employee::findOrFail($form->creator);
        
        if(\Auth::user()->roles == "AGENT" || \Auth::user()->roles == "L2")
        {
            $to = $creator;
            $ccs = array(\Auth::user(),$creator->superior);
        }
        else if(\Auth::user()->roles == "SUPERVISOR")
        {
            $to = $agent;
            $ccs = array(\Auth::user(),\Auth::user()->superior);
        }
        else if (\Auth::user()->roles == "SOM")
        {
            $to = $creator;
            $ccs = array(\Auth::user(),$agent);
        }
        else if (\Auth::user()->roles == "MANAGER")
        {
            $to = $creator;
            $ccs = array(\Auth::user(),$agent);
        }
        sendMail("coachingform.formUpdatedMail",
        $to,
        $ccs,
        $form
        );
        //send mail if newly updated gikan sa ir
            if($rstatus == 0)
            {
            sendMail("coachingform.makeActionPlan",
            $agent,
            array(\Auth::user()),
            $form
            );
            }
        }
        
        return redirect('coachingform');   
    }
    
       public function updateStatus($id)
    {
         
        $form = CoachingForm::where('id',$id)->first();
        
        if($form->status == 'Pending')
        {
            $coaching = CoachingForm::findOrFail($id)->update([
            'status' => 'Ongoing'
        ]);
         
            $actionplan = ActionPlan::where('coachingform_id',$id)->update([
             'status' => 'Ongoing'
         ]);
            if($form->irid != 0){
                $irform = Irform::find($form->irid)->update([
                    "status" => 'Ongoing'
                ]);
            }
            
         
        }
        else{
            $coaching = CoachingForm::findOrFail($id)->update([
               'status' => 'Complete' 
            ]);
            
            if($form->irid != 0){
                $irform = Irform::find($form->irid)->update([
                    "status" => 'Complete'
                ]);
                
            }
            
       
        }
        
        $agent = Employee::findOrFail($form->agent_id);
        $creator = Employee::findOrFail($form->creator);
        sendMail("coachingform.statusChangedMail",
        $agent,
        array($creator),
        $form
        );
        
        if($form->irid != 0){
        $ir = Irform::find($form->irid);
        $rta = Employee::find($ir->creator);
        
        sendIrMail('irform.irformstatuschange', 
                $agent, 
                array(\Auth::user(), $rta), 
                $ir);
        }
      
         return redirect('coachingform');
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
                    $destinationPath = resource_path(). '/file_attachments/';
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
        $file_path = resource_path('file_attachments/'.$file);
        
        if(file_exists($file_path))
        {
            return response()->download($file_path);
        }
        else
        {
           
        }
    }
    
    public function getMembers(Request $request)
    {
        $dept = Department::find($request->input('id'));
        $members = $dept->members->active()->get();
        return response ()->json ( $members);
    }
    
    public function coachingTargetIndex()
    {
        if(\Auth::user()->roles == "SUPERVISOR")
        {
            $page_title = "Coaching Target";
            $reports = Coachingtarget::where('created_by', \Auth::user()->uid)->with('createdBy')->get();
            
            return view('coachingform.coachingtargetindex', compact('page_title','reports'));
        }
        else if (\Auth::user()->roles == "SOM" || \Auth::user()->roles == "MANAGER")
        {
            $page_title = "Coaching Target";
            $supervisors = Employee::find(\Auth::user()->uid)->subordinates()->where('roles', 'SUPERVISOR')->where('active', 1)->sortBy('lname');
            $reports = array();
            $teams = \Auth::user()->teams();
            foreach($supervisors as $supervisor)
            {
                $report = Coachingtarget::where('created_by', $supervisor->uid)->get();
                if(!$report->isEmpty())
                {
                    array_push($reports,$report);
                    
                }
            }
            $nit = array("UK Offshore Support Team 02", "UK Offshore Support Team 01", "Customer Service Offshore US 02",
                "Customer Service Offshore US 01", "UK Training Team", "Cebu Sales After Support - UK", "Special Task Cebu - UK",
                "Customer Service Offshore UK");
                $teamReports = array();
                $teamAdmins = array();
                foreach($teams as $team)
                {
                    if(in_array($team->name, $nit))
                    {

                    }
                    else
                    {
                        if(in_array($team->admin, $teamAdmins))
                        {
                            
                        }
                        else
                        {
                            $teamAdmin = $team->admin;
                            array_push($teamAdmins,$teamAdmin);
                            $teamReport = Coachingtarget::where('created_by', $teamAdmin)->get();
                            if(!$teamReport->isEmpty())
                            array_push($teamReports,$teamReport);
                        }
                    } 
                }
                //dd($teamReports);
            return view('coachingform.coachingtargetteamview', compact('page_title','reports','supervisors','teams','teamReports'));
        }
        else
        {
            return redirect('coachingform');
        }
            
    }
    
    public function createCoachingTarget(Request $request)
    {
        $type = $request->input('type');
        $page_title = "Create ".$type." Target";
        
        $agents = \Auth::user()->subordinates()->sortBy('lname')->where('active', 1);
        return view('coachingform.coachingtargetcreate', compact('page_title', 'type', 'agents'));
    }
    
    public function storeCoachingTarget(Request $request)
    {
        $content = json_encode(array($request->input('content'),$request->input('totalq1'),$request->input('totalq2'),
            $request->input('totalq3'),$request->input('totalq4'),$request->input('totalrq1'),$request->input('totalrq2'),
            $request->input('totalrq3'),$request->input('totalrq4'),$request->input('totalrq1p'),$request->input('totalrq2p'),
            $request->input('totalrq3p'),$request->input('totalrq4p')));
        
        $coachingTarget = Coachingtarget::create
                ([
                   'created_by' => \Auth::user()->uid,
                   'content' => $content
                ]);
        
        return redirect('coachingtarget');
    }
    
    public function createCoachingTargetForSup($supId)
    {
        $sup = Employee::find($supId);
        $page_title = "Create Target Report for ".$sup->name;
        
        $agents = $sup->subordinates()->sortBy('lname')->where('active', 1);
        return view('coachingform.coachingtargetcreate', compact('page_title', 'agents', 'supId'));
    }
    public function storeCoachingTargetForSup(Request $request)
    {
        $content = json_encode(array($request->input('content'),$request->input('totalq1'),$request->input('totalq2'),
            $request->input('totalq3'),$request->input('totalq4'),$request->input('totalrq1'),$request->input('totalrq2'),
            $request->input('totalrq3'),$request->input('totalrq4'),$request->input('totalrq1p'),$request->input('totalrq2p'),
            $request->input('totalrq3p'),$request->input('totalrq4p')));
        
        $coachingTarget = Coachingtarget::create
                ([
                   'created_by' => $request->input('supId'),
                   'content' => $content
                ]);
        
        return redirect('coachingtarget');
    }
    
    public function coachingTargetView($id)
    {
        $report = Coachingtarget::find($id);
        $content = json_decode($report->content, true);
        //dd($content);
        $creatorId = $report->created_by;
        $creator = Employee::find($creatorId);   
        $agents = $creator->subordinates()->sortBy('lname')->where('active', 1);
        $page_title =  $report->type.' Coaching Target by '.$creator->name;
        
        $include_list = array
        (
            $report->created_by,
            $creator->superior->uid,
            $creator->superior->superior->uid
        );

        $agentQ = array();
        foreach($content[0] as $agent)
        {
            array_push($agentQ, $agent['uid']);
        }
        
        $auids = array();
        foreach($agents as $agent)
        {
            array_push($auids, $agent->uid);
        }
        $newAgents = array_diff($auids,$agentQ);
        $nAgents = Employee::whereIn('uid', $newAgents)->get();
        if(!in_array(\Auth::user()->uid, $include_list)) 
        {
            return redirect('coachingtarget');
        }
        else
        {
            return view('coachingform.coachingtargetview', compact('report', 'content','agents', 'page_title', 'nAgents'));
        }
    }
    
    public function coachingTargetTeamView()
    {
        $page_title = "Team List";
        $teams = \Auth::user()->teams();
        
        $nit = array("UK Offshore Support Team 02", "UK Offshore Support Team 01", "Customer Service Offshore US 02",
        "Customer Service Offshore US 01", "UK Training Team", "Cebu Sales After Support - UK", "Special Task Cebu - UK",
        "Customer Service Offshore UK");
        foreach($teams as $team)
        {
            if($team->name == in_array($team->name, $nit))
            {
                
            }
            else
            {
                $teamAdmin = $team->admin;
                $report = Coachingtarget::where('created_by', $teamAdmin);
                dd($report);
                
            } 
        }

        return view('coachingform.coachingtargetteamview', compact('teams','page_title','nTeams'));
    }
    
    public function coachingTargetEditView($id)
    {
        $report = Coachingtarget::find($id);
        $content = json_decode($report->content, true);
        $creatorId = $report->created_by;
        $creator = Employee::find($creatorId);   
        $agents = $creator->subordinates()->sortBy('lname')->where('active', 1);
        $page_title =  $report->type.' made by '.$creator->name;
        
        $agentQ = array();
        foreach($content[0] as $agent)
        {
            array_push($agentQ, $agent['uid']);
        }
        
        $auids = array();
        foreach($agents as $agent)
        {
            array_push($auids, $agent->uid);
        }
        $newAgents = array_diff($auids,$agentQ);
        $nAgents = Employee::whereIn('uid', $newAgents)->get();
        
        $include_list = array
        (
            $report->created_by,
            $creator->superior->uid,
            $creator->superior->superior->uid
        );
        if(!in_array(\Auth::user()->uid, $include_list)) 
        {
            return redirect('coachingtarget');
        }
        else
        {
            return view('coachingform.coachingtargetedit', compact('report', 'content','agents', 'page_title','nAgents'));
        }   
    }
    
    public function coachingTargetEdit($id, Request $request)
    {
        $content = json_encode(array($request->input('content'),$request->input('totalq1'),$request->input('totalq2'),
            $request->input('totalq3'),$request->input('totalq4'),$request->input('totalrq1'),$request->input('totalrq2'),
            $request->input('totalrq3'),$request->input('totalrq4'),$request->input('totalrq1p'),$request->input('totalrq2p'),
            $request->input('totalrq3p'),$request->input('totalrq4p')));
        
        $coachingTarget = Coachingtarget::where("id", $id)->update
                ([
                   'content' => $content,
                ]);
        
        return redirect('coachingtarget');
    }
    
    public function selectTeam(Request $request) {
        $agentForm = $request->input('agentForm');
        $teamId = Department::find($agentForm);
        $teamAdmin = $teamId->admin;
        
        $coachingTarget = CoachingTarget::where('created_by', $teamAdmin)->get();
        //dd($coachingTarget);
        
        if(!$coachingTarget->isEmpty()){
            return redirect('coachingtarget/'.$coachingTarget[0]->id);
        }else {
            return redirect('coachingtarget/createtarget/'.$teamAdmin);
        }
    }
    
    public function coachingTargetDelete($id, Request $request){
        $target = CoachingTarget::destroy($id);
        
        return redirect('coachingtarget');
    }
    
    
    public function coachingTargetGenerate(){
 

        Excel::create('Coaching Targets', function($excel){
            $excel->sheet('CoachingTarget', function($sheet){
                $nit = array("UK Offshore Support Team 02", "UK Offshore Support Team 01", "Customer Service Offshore US 02",
                "Customer Service Offshore US 01", "UK Training Team", "Cebu Sales After Support - UK", "Special Task Cebu - UK",
                "Customer Service Offshore UK");
                $teams = \Auth::user()->teams();
                 $teamReports = array();
                $teamAdmins = array();
                foreach($teams as $team)
                {
                    if(in_array($team->name, $nit))
                    {

                    }
                    else
                    {
                        if(in_array($team->admin, $teamAdmins))
                        {
                            
                        }
                        else
                        {
                            $teamAdmin = $team->admin;
                            array_push($teamAdmins,$teamAdmin);
                            $teamReport = Coachingtarget::where('created_by', $teamAdmin)->get();
                            if(!$teamReport->isEmpty())
                            array_push($teamReports,$teamReport);
                        }
                    }
                    
                }
                $sheet->loadView('coachingform.generatetable', compact('page_title','reports','supervisors','teams','teamReports'));
            });
    })->export('xlsx');
    }
    
    
     public function coachingTargetTeamGenerate($id) {
        
        Excel::create('Coaching Targets Team', function($excel) use($id) {
            $excel->sheet('Coaching Targets Team', function($sheet) use($id){
                $report = Coachingtarget::find($id);
                $content = json_decode($report->content, true);
                $creatorId = $report->created_by;
                $creator = Employee::find($creatorId);   
                $agents = $creator->subordinates()->sortBy('lname')->where('active', 1);
                $page_title =  $report->type.' made by '.$creator->name;

                $include_list = array
                (
                    $report->created_by,
                    $creator->superior->uid,
                    $creator->superior->superior->uid
                );
                $sheet->loadView('coachingform.generateteam', compact('report', 'content','agents', 'page_title'));

            });
    })->export('xlsx');
        
    }
    
    public function showGraph()
    {
        // for joe
        // sample -- $report = Coachingtarget::find($id);
        // $report = object sa report 
        $content = json_decode($report->content, true);
    }
    
}
    

