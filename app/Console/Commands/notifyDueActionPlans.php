<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Mail;
use App\ActionPlan;
use App\CoachingForm;
use App\Employee;


class notifyDueActionPlans extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mis:notifyDueActionPlans';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '(MIS-EWS) Notify creators and superiors of due action plans this day.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    
    public function handle()
    {
       $date_today = \Carbon\Carbon::now()->format('Y-m-d');
       $this->info($date_today);
       $action_plans = ActionPlan::where('target_date', $date_today)->where('status','Ongoing')->get();
       foreach($action_plans as $action_plan)
       {
           $this->info($action_plan);
           $cid = $action_plan->coachingform_id;
           $action = ActionPlan::findOrFail($action_plan->id);
           $form = CoachingForm::findOrFail($cid);
           $agent_id = $form->agent_id;
           $agent = Employee::findOrFail($agent_id);
           $creator = $form->createdBy;
           //sendmail to supervisor for due to target action plans
           sendMail("coachingform.dueActionPlanSupMail",
           $creator,
           array($agent),
           $action_plan);
           //sendmail to agent for due to target action plans
           sendMail("coachingform.dueActionPlanAgentMail",
           $agent,
           array($creator),
           $action_plan);
       }
       
       $action_plans = ActionPlan::where('followup_date', $date_today)->where('status','Ongoing')->get();
       foreach($action_plans as $action_plan)
       {
           $this->info($action_plan);
           $cid = $action_plan->coachingform_id;
           $form = CoachingForm::findOrFail($cid);
           $agent_id = $form->agent_id;
           $agent = Employee::findOrFail($agent_id);
           $creator = $form->createdBy;
           //sendmail to supervisor for due follow up action plans
           sendMail("coachingform.followupActionPlanSupMail",
           $creator,
           array($agent),
           $action_plan);
           
           //sendmail to agent for due follow up action plans
           sendMail("coachingform.followupActionPlanAgentMail",
           $agent,
           array($creator),
           $action_plan);
       }
    }
}