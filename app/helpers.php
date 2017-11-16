<?php

function sendMail($view,$to,$ccs,$file)
{
    if($file->creator)
    {
        $data['form'] = $file;
    }
    else
    {
        $data['com'] = $file;
    }
    
           
    Mail::send($view, $data, function ($message) use ($to,$ccs) {
    $message->from('no-reply@mis-ews.ph.schlund.net', 'MIS-EWS Coaching');
    $message->to( $to->email )->subject('1&1 Coaching');
    foreach($ccs as $cc)
    {
        $message->cc( $cc->email );
    }
    });
}

function sendIrMail($view,$to,$ccs,$file)
{
    //$view = blade view
    //$to = send email to
    //$ccs = ccs for the email
    //$file = irform/coaching

        //else $file = IR form
        $data['ir'] = $file;
           
    Mail::send($view, $data, function ($message) use ($to,$ccs) {
    $message->from('no-reply@mis-ews.ph.schlund.net', 'MIS-EWS IR');
    $message->to( $to->email )->subject('1&1 IR Form');
    foreach($ccs as $cc)
    {
        $message->cc( $cc->email );
    }
    });
}

function sendUsLoggerMail($view,$to,$ccs,$file)
{
    //$view = blade view
    //$to = send email to
    //$ccs = ccs for the email
    //$file = irform/coaching

        //else $file = IR form
        $data['uslogger'] = $file;
           
    Mail::send($view, $data, function ($message) use ($to,$ccs) {
    $message->from('no-reply@mis-ews.ph.schlund.net', 'MIS-EWS US Sas Logger');
    $message->to( $to->email )->subject('1&1 US SAS Logger');
    foreach($ccs as $cc)
    {
        $message->cc( $cc->email );
    }
    });
}