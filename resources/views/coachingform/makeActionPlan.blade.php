<div>

    <div>
        <p style="font-family: Cambria; font-size: 18px;">Hi, {{$form->agent->name}}!<br>
            A coaching form has been created for you by {{ $form->createdBy->name }}. <br>
            Please do fill up your action plan/s.</p>
    </div>
    
    <div style="font-family: Cambria; font-size: 16px">
        Click the link below to add an action plan. <br>
<!--            link of the form-->
            <a href="{{ url('coachingform/'.$form->id.'/editForm')}}">{{ url('coachingform/'.$form->id.'/editForm')}}</a>
    </div>
    <br>
    <br>
    <div>
        <small style='font-family: Cambria;'>
            This message is automatically generated by the 1&1 Coaching Tool.<br>
            If you have received this email in error, please notify the IT Department and delete the email.
        </small>
    </div>
</div>


