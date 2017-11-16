<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Http\Requests;
use App\CoachingForm;
use App\Comment;
use App\ActionPlan;


class FormController extends Controller
{
    public function index()
    {
        $coachingForms = CoachingForm::latest()->get();
        
        return view ('form.index', compact('coachingForms'));
    }
    
    public function create()
    {
        return view ('form.create');
    }
    
    public function store(Request $request)
    {
        $type = $request->input('type');
        $agent_id = $request->input('agent_id');
        $creator = $request->input('creator');
        $supervisor = 2222222;
        $manager = 1111111;
        $content = $request->input('content');
        $status = 'Pending';
        $attachment = "";
        
        CoachingForm::create([
            'type' => $type,
            'agent_id' => $agent_id,
            'creator' => $creator,
            'superior' => $supervisor,
            'manager' => $manager,
            'content' => $content,
            'status' => $status,
            'attachment' => $attachment
                ]);
        
        return redirect('form');
    }
    
    public function show($id)
    {
        $form = CoachingForm::with('actionPlans','comments')->findOrFail($id);
        return view('form.show', compact('form'));
    }
    
    
    public function destroy($id)
    {
        CoachingForm::destroy($id);
        
        return redirect('form');
    }
    
    public function edit($id)
    {
        $form = CoachingForm::findOrFail($id);
        $comments = $form->comments;
        return view('form.edit', compact('form','comments'));
    }
    
    
    public function update(Request $request, $id) // request data is post data of the form. id is the id of the coaching form
    {
        $form = CoachingForm::findOrFail($id);
        $form->update($request->all());
        
        return redirect('form');
    }
    
    public function addActionPlan(Request $request, $id)
    {
        $form = CoachingForm::findOrFail($id);
        ActionPlan::create([
            'coachingform_id' => $id,
            'content' => $request->input('content'),
            'target_date' => $request->input('target_date'),
            'followup_date' => $request->input('followup_date')
        ]);
        return redirect('form/'.$id);
    }
    public function deleteActionPlan($id)
    {
        $form = CoachingForm::findOrFail($id);
        ActionPlan::destroy($id);
        return redirect('form');
    }
    public function editActionPlan(Request $request, $id)
    {
        $form = CoachingForm::findOrFail($id);
        $form->update($request->all());
    }
}
