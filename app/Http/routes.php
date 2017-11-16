<?php

/*
  |--------------------------------------------------------------------------
  | Routes File
  |--------------------------------------------------------------------------
  |
  | Here is where you will register all of the routes in an application.
  | It's a breeze. Simply tell Laravel the URIs it should respond to
  | and give it the controller to call when that URI is requested.
  |
 */

/*
  |--------------------------------------------------------------------------
  | Application Routes
  |--------------------------------------------------------------------------
  |
  | This route group applies the "web" middleware group to every route
  | it contains. The "web" middleware group is defined in your HTTP
  | kernel and includes session state, CSRF protection, and more.
  |
 */

Route::group(['middleware' => 'web'], function () {
    Route::auth();
    Route::get('/', 'HomeController@index');
    Route::get('profile_img/{id}', 'HomeController@show_profile_image');
    Route::get('dashboard/{wk?}', 'HomeController@index');
    Route::get('productivity', 'PerformanceController@prod');
    Route::get('feedbacks', 'PerformanceController@crr');
    Route::get('sasupsells', 'PerformanceController@sales');
    Route::get('blacklist', 'PerformanceController@blacklists');
    Route::get('show', 'HomeController@test');
    Route::get('imap', 'HomeController@imap_test');
    Route::get('overallweekly', 'HomeController@weeklydata');
    Route::post('usersettings', 'HomeController@usersettings');
    Route::get('notify', 'HomeController@notify');
    Route::get('imp/{uid}', 'HomeController@impersonate');
    Route::get('cosmocom', 'PerformanceController@cosmocom');
    Route::get('roles/{msg}', 'HomeController@assignrole');
    Route::post('roles/update', 'HomeController@updaterole');
    
    Route::get('masterreport', 'MasterReportController@create');
    Route::post('masterreport/store', 'MasterReportController@store');
    Route::get('masterreport/view/{id}/{action}', 'MasterReportController@view');
    Route::get('masterreport/final/{id}', 'MasterReportController@final_view');
    Route::post('cases/store', 'CaseLoggerController@store');
    Route::get('cases/loadform', 'CaseLoggerController@loadform');
    Route::get('cases/admin', 'CaseLoggerController@admin');
    Route::post('cases/generate', 'CaseLoggerController@generate_csv');
    Route::get('sas/gofo', 'SalesController@go_fo');
    Route::get('sas', 'SalesController@index');
    Route::get('sas/listlocal', 'SalesController@listlocal');
    Route::get('sas/difm', 'SalesController@difm');
    Route::get('sas/cloud', 'SalesController@cloud');
    Route::get('sas/dedicated', 'SalesController@dedicated');
    Route::get('sas/vps', 'SalesController@vps');
    Route::get('sas/classichosting', 'SalesController@classic_hosting');
    Route::get('sas/mywebsite', 'SalesController@mywebsite');
    Route::get('sas/email', 'SalesController@email');
    Route::get('sas/ebusiness', 'SalesController@ebusiness');
    Route::get('sas/marketing', 'SalesController@marketing');
    Route::get('sas/office', 'SalesController@office');
    Route::get('sas/domains', 'SalesController@domains');
    Route::get('sas/other', 'SalesController@other');
    Route::get('ticketing/create', 'TicketingController@create');
    Route::get('sas/reports', 'SalesController@sas_reports');
    Route::post('sas/generate', 'SalesController@sas_generate');
    Route::get('sas/featured', 'SalesController@featured');
    Route::get('sas/gross', 'SalesController@gross');
    Route::get('sas/tariff', 'SalesController@tariff');
    Route::get('sas/dashboard', 'SalesController@dashboard');
    Route::get('sas/overallweekly', 'SalesController@weekly_sas');
    Route::get('sas/runningsas', 'SalesController@running_sas');
    Route::post('sas/save', 'SalesController@save_targets');
    Route::get('sas/upload', 'SalesController@uploadpayout');
    Route::post('sas/submit', 'SalesController@importExcel');
    Route::get('sas/payouts', 'SalesController@salespayout');
    Route::get('sas/upload_breakdown', 'SalesController@uploadBreakdown');
    Route::post('sas/submit_breakdown', 'SalesController@importBreakdown');
    Route::get('sas/payout_breakdown', 'SalesController@salesPayoutBreakdown');
    
    Route::get('agentstat/upload', 'AgentStatController@upload');
    Route::get('agentstat', 'AgentStatController@stat_reports');
    Route::post('agentstat/submit_sr', 'AgentStatController@importStackRank');
    Route::post('agentstat/submit_cqn', 'AgentStatController@importCQN');
    Route::post('agentstat/submit_prod', 'AgentStatController@importProd');
    Route::post('agentstat/submit_sas', 'AgentStatController@importSas');
    Route::post('agentstat/submit_rel', 'AgentStatController@importReleased');
    Route::post('agentstat/submit_aht', 'AgentStatController@importAHT');
    Route::get('agentstat/open_sr/{id}', 'AgentStatController@Open_stackrank');
    Route::get('agentstat/open_cqn/{id}', 'AgentStatController@Open_cqn');
    Route::get('agentstat/open_prod/{id}', 'AgentStatController@Open_prod');
    Route::get('agentstat/open_sas/{id}', 'AgentStatController@Open_sas');
    Route::get('agentstat/open_rr/{id}', 'AgentStatController@Open_released');
    Route::get('agentstat/open_aht/{id}', 'AgentStatController@Open_aht');

    //Alykka Routes
    Route::get('nofeedback/create', 'NoFeedbackController@createform');
    Route::post('nofeedback/store', 'NoFeedbackController@store');
    Route::get('nofeedback/edit/{id}', 'NoFeedbackController@retrieve');
    Route::get('debriefing/create', 'DebriefingController@createform');
    Route::post('debriefing/store', 'DebriefingController@store');
    Route::put('debriefing/update', 'DebriefingController@update');
    Route::get('debriefing/edit/{id}', 'DebriefingController@retrieve');
    Route::post('debriefing/search', 'DebriefingController@search');
    Route::post('debriefing/view', 'DebriefingController@view');
    Route::post('debriefing/reports', 'DebriefingController@reports');
    Route::get('debriefing/myreports', 'DebriefingController@myreports');
    Route::post('debriefing/searchdate', 'DebriefingController@searchdate');
    Route::get('debriefing', 'DebriefingController@index');
    Route::get('debriefing/display/{id}', 'DebriefingController@display');
    Route::get('freemailers/create', 'FreemailersController@createform');
    Route::post('freemailers/store', 'FreemailersController@store');
    Route::get('freemailers/edit/{id}', 'FreemailersController@retrieve');
    Route::post('freemailers/search', 'FreemailersController@search');
    Route::post('freemailers/sort', 'FreemailersController@sort');
    Route::get('cancellationrequests/create', 'CancellationRequestsController@createform');
    Route::post('cancellationrequests/store', 'CancellationRequestsController@store');
    Route::get('cancellationrequests/edit/{id}', 'CancellationRequestsController@retrieve');
    Route::post('cancellationrequests/search', 'CancellationRequestsController@search');
    Route::post('cancellationrequests/sort', 'CancellationRequestsController@sort');
    Route::get('feedback/create', 'FeedbackController@createform');
    Route::post('feedback/store', 'FeedbackController@store');
    Route::get('feedback/edit/{id}', 'FeedbackController@retrieve');
    Route::post('feedback/search', 'FeedbackController@search');
    Route::post('feedback/sort', 'FeedbackController@sort');
    Route::get('iteminventory/new', 'ItemInventoryController@display');
    Route::post('iteminventory/add', 'ItemInventoryController@add');
    Route::post('iteminventory/addcategory', 'ItemInventoryController@addcategory');
    Route::post('iteminventory/removecategory', 'ItemInventoryController@removecategory');
    Route::get('iteminventory/viewitem/{id}', 'ItemInventoryController@retrieve');
    Route::post('iteminventory/updatestocks', 'ItemInventoryController@updatestocks');
    Route::post('iteminventory/changecategory', 'ItemInventoryController@changecategory');
    Route::post('iteminventory/update', 'ItemInventoryController@update');
    Route::get('iteminventory/view', 'ItemInventoryController@manage');
    Route::get('iteminventory/display', 'ItemInventoryController@category');
    Route::post('iteminventory/sort', 'ItemInventoryController@sort');
    Route::get('incentives/new', 'IncentiveRequestsController@display');
    Route::post('incentives/add', 'IncentiveRequestsController@add');
    Route::get('incentives/view/{id}', 'IncentiveRequestsController@view');
    Route::post('incentives/update', 'IncentiveRequestsController@update');
    Route::post('incentives/addremarks', 'IncentiveRequestsController@addremarks');
    Route::post('incentives/sort', 'IncentiveRequestsController@sort');
    Route::post('incentives/process', 'IncentiveRequestsController@process');
    Route::get('supervisorycalls/new', 'SupervisoryCallsController@display');
    Route::get('supervisorycalls/getagent/{team}', 'SupervisoryCallsController@get_agent');
    Route::post('supervisorycalls/add', 'SupervisoryCallsController@add');
    Route::get('supervisorycalls/view/{id}', 'SupervisoryCallsController@view');
    Route::post('supervisorycalls/update', 'SupervisoryCallsController@update');
    Route::get('assets/new', 'AssetsController@display');
    Route::get('assets/getemployee/{department}', 'AssetsController@getemployee');
    Route::post('assets/addasset', 'AssetsController@addasset');
    Route::get('assets/view/{id}', 'AssetsController@view');
    Route::post('assets/action', 'AssetsController@action');
    Route::get('assets/selectitem', 'AssetsController@selectitem');
    Route::post('assets/issue', 'AssetsController@addissuance');

    //Vanessa Routes
    Route::get('sas/newcase', 'SASLowPerformersController@newcase');
    Route::post('sas/storecase', 'SASLowPerformersController@storecase');
    Route::get('sas/edit/{id}', 'SASLowPerformersController@editcase');
    Route::post('sas/filter_date', 'SASLowPerformersController@filter_date');
    Route::post('sas/sort', 'SASLowPerformersController@sort');
    Route::get('slpc/newcase', 'SLPendingConcernsController@newcase');
    Route::post('slpc/store', 'SLPendingConcernsController@store');
    Route::get('slpc/edit/{id}', 'SLPendingConcernsController@edit');
    Route::post('slpc/filter_date', 'SLPendingConcernsController@filter_date');
    Route::post('slpc/sort', 'SLPendingConcernsController@sort');
    Route::get('mcc/newcase', 'MailCancelledCasesController@newcase');
    Route::post('mcc/store', 'MailCancelledCasesController@store');
    Route::get('mcc/edit/{id}', 'MailCancelledCasesController@edit');
    Route::post('mcc/filter_date', 'MailCancelledCasesController@filter_date');
    Route::post('mcc/sort', 'MailCancelledCasesController@sort');
    Route::get('msas/newcase', 'MailSASController@newcase');
    Route::post('msas/store', 'MailSASController@store');
    Route::get('msas/edit/{id}', 'MailSASController@edit');
    Route::post('msas/filter_date', 'MailSASController@filter_date');
    Route::post('msas/sort', 'MailSASController@sort');
    Route::get('mct/newcase', 'MindersaldoCasesController@newcase');
    Route::post('mct/store', 'MindersaldoCasesController@store');
    Route::get('mct/edit/{id}', 'MindersaldoCasesController@retrieve');
    Route::post('mct/search', 'MindersaldoCasesController@search');
    Route::post('mct/sort', 'MindersaldoCasesController@sort');
    Route::get('itemissuance/create', 'ItemIssuanceController@create');
    Route::post('itemissuance/store', 'ItemIssuanceController@store');
    Route::get('itemissuance/view/{id}', 'ItemIssuanceController@view');
    Route::get('itemissuance/items_select', 'ItemIssuanceController@items_select');
    Route::post('itemissuance/items_store', 'ItemIssuanceController@items_store');
    Route::get('itemissuance/getemployee/{department}', 'ItemIssuanceController@getemployee');


    //Sarah Routes
    Route::get('mailtophone/newmailtophone', 'MailtoPhoneController@newmailtophone');
    Route::post('mailtophone/storemailtophone', 'MailtoPhoneController@storemailtophone');
    Route::put('mailtophone/update', 'MailtoPhoneController@updatemailtophone');
    Route::get('mailtophone/edit/{id}', 'MailtoPhoneController@editmailtophone');
    Route::get('bugrequest/create', 'BugRequestController@newbugrequest');
    Route::post('bugrequest/store', 'BugRequestController@store');
    Route::put('bugrequest/update', 'BugRequestController@update');
    Route::get('bugrequest/edit/{id}', 'BugRequestController@edit');
    Route::get('bugrequest/sort_status/{status}', 'BugRequestController@sort_status');
    Route::post('bugrequest/filter_date', 'BugRequestController@filter_date');
    Route::post('bugrequest/comment/{id}', 'BugRequestController@comment');
    Route::get('retentioncase/create', 'RetentionCaseController@newcase');
    Route::post('retentioncase/store', 'RetentionCaseController@store');
    Route::put('retentioncase/update', 'RetentionCaseController@update');
    Route::get('retentioncase/edit/{id}', 'RetentionCaseController@edit');
    Route::post('retentioncase/filter_date', 'RetentionCaseController@filter_date');
    Route::get('returneditem/create', 'ReturnedItemController@create');
    Route::post('returneditem/store', 'ReturnedItemController@store');
    Route::post('returneditem/mstore', 'ReturnedItemController@mstore');
    Route::put('returneditem/update', 'ReturnedItemController@update');
    Route::get('returneditem/edit/{id}', 'ReturnedItemController@edit');
    Route::get('returneditem/get_item/{cid}', 'ReturnedItemController@get_item');
    Route::get('returneditem/get_serial/{item_id}', 'ReturnedItemController@get_serial');
    Route::get('repaireditem/create', 'RepairedItemController@create');
    Route::post('repaireditem/store', 'RepairedItemController@store');
    Route::put('repaireditem/update', 'RepairedItemController@update');
    Route::get('repaireditem/edit/{id}', 'RepairedItemController@edit');
    Route::get('materialrequests/create', 'MaterialRequestsController@create');
    Route::post('materialrequests/store', 'MaterialRequestsController@store');
    Route::get('materialrequests/edit/{id}', 'MaterialRequestsController@edit');
    Route::post('materialrequests/update', 'MaterialRequestsController@update');
    Route::post('materialrequests/addremarks', 'MaterialRequestsController@addremarks');
    Route::post('materialrequests/sort', 'MaterialRequestsController@sort');
    Route::post('materialrequests/process', 'MaterialRequestsController@process');
    Route::get('posting/create', 'PDFfileController@create');
    Route::post('posting/store', 'PDFfileController@store');
    Route::post('posting/cStore', 'PDFfileController@cStore');
    Route::post('posting/update', 'PDFfileController@update');
    Route::get('posting/edit/{pdf_id}', 'PDFfileController@edit');
    Route::get('posting/delete/{pdf_id}', 'PDFfileController@delete');
    Route::get('posting/download/{pdf_name}', 'PDFfileController@getDownload');
    Route::get('joborder/create', 'JobOrderController@create');
    Route::post('joborder/store', 'JobOrderController@store');
    Route::get('joborder/view/{id}', 'JobOrderController@edit');
    Route::get('joborder/download/{attachments}', 'JobOrderController@getDownload');
    Route::post('joborder/upload', 'JobOrderController@storeFiles');
    Route::post('joborder/comment', 'JobOrderController@comment');
    Route::post('joborder/status', 'JobOrderController@status');
      
    //CoachingForm routes
    Route::get('coachingform' , 'CoachingFormController@index');
    Route::post('coachingform' , 'CoachingFormController@index');
    Route::post('coachingform/createForm' , 'CoachingFormController@createForm');
    Route::get('coachingform/createForm', function(){
        return redirect('coachingform');
    });
    
    Route::post('coachingform/deleteForm' , 'CoachingFormController@deleteForm');
    Route::post('coachingform/addForm', 'CoachingFormController@addForm');
    Route::post('coachingform/{id}/addPlan', 'CoachingFormController@addActionPlan');
    Route::get('coachingform/{id}', 'CoachingFormController@viewForm');
    Route::post('coachingform/{id}/addComment', 'CoachingFormController@addComment');
    Route::post('coachingform/{id}/delPlan', 'CoachingFormController@delActionPlan');
    Route::get('coachingform/{id}/editForm', 'CoachingFormController@editForm');
    Route::post('coachingform/{id}/update', 'CoachingFormController@updateForm');
    Route::post('coachingform/{id}/delComment', 'CoachingFormController@delComment');
    Route::get('coachingform/{id}/updateStatus', 'CoachingFormController@updateStatus');
    Route::get('coachingform/download/{file}', 'CoachingFormController@getDownload');
    Route::get('signature/{uid}', 'HomeController@showSignature');
    Route::post('coachingform/getMembers', 'CoachingFormController@getMembers');
    
    //coaching target
    Route::get('coachingtarget', 'CoachingFormController@coachingTargetIndex');
    Route::post('coachingtarget', 'CoachingFormController@selectTeam');
    Route::get('coachingtarget/createtarget', 'CoachingFormController@createCoachingTarget');
    Route::get('coachingtarget/createtarget/addtarget', function(){
        return redirect('coachingtarget');
    });
    //EXCEL
    Route::get('coachingtarget/generate', 'CoachingFormController@coachingTargetGenerate');
    Route::get('coachingtarget/generateteam/{id}', 'CoachingFormController@coachingTargetTeamGenerate');

    
    Route::post('coachingtarget/createtarget/addtarget', 'CoachingFormController@storeCoachingTarget');
    Route::get('coachingtarget/teamview', 'CoachingFormController@coachingTargetTeamView');
    Route::get('coachingtarget/{id}', 'CoachingFormController@coachingTargetView');
    Route::get('coachingtarget/edit/{id}', 'CoachingFormController@coachingTargetEditView');
    Route::post('coachingtarget/edit/{id}', 'CoachingFormController@coachingTargetEdit');
    Route::get('coachingtarget/delete/{id}', 'CoachingFormController@coachingTargetDelete');
    Route::get('coachingtarget/createtarget/{supId}', 'CoachingFormController@createCoachingTargetForSup');
    Route::post('coachingtarget/createtarget/addtargetforsup', 'CoachingFormController@storeCoachingTargetForSup');
    
    //IRFORMS
    Route::get('irforms', 'IrForms@index');
    Route::post('irforms/create', 'IrForms@create');    
    Route::get('irforms/create', 'IrForms@create');
    Route::post('irforms/store', 'IrForms@store');    
    Route::get('irforms/view/{id}', 'IrForms@view');
    Route::get('irforms/delete/{id}', 'IrForms@delete');
    Route::get('irforms/edit/{id}', 'IrForms@editView');    
    Route::post('irforms/edit/{id}', 'IrForms@edit');    
    Route::post('irforms/getagent', 'IrForms@getAgent');
    Route::post('irforms/gettype', 'IrForms@getType');
    

    
    //CCTV Dump Requests
    Route::get('cctvrequests/new', 'CCTVDumpRequest@createForm');

    //Cafeteria Tool
    Route::get('createmenu/{id}' , 'CafeteriaController@createMenu');
    Route::get('cafeteria/editmenu/{id}' , 'CafeteriaController@editMenu');
    Route::post('cafeteria/editmenu/{id}' , 'CafeteriaController@updateMenu');
    Route::post('cafeteria/updateItem/{id}' , 'CafeteriaController@updateItem');
    Route::post('cafeteria/addToMenu/{id}', 'CafeteriaController@addToMenu');
    Route::get('cafeteria' , 'CafeteriaController@index');
    Route::post('cafeteria/addItem/{id}', 'CafeteriaController@addItem');
    Route::post('cafeteria/deleteItem' , 'CafeteriaController@deleteItem');
    Route::get('cafeteria/{id}' , 'CafeteriaController@viewMenu');

    Route::get('survey', 'SurveyController@index');
    Route::get('survey/charts', 'SurveyController@charts');
    Route::get('survey/home', 'SurveyController@home');
    Route::post('survey/status', 'SurveyController@set_status');
    Route::get('survey/success', 'SurveyController@thankyou');
    Route::get('survey/edit/{survey}', 'SurveyController@edit_answer');
    Route::get('survey/downloadpdf/{answerid}/{user_id}', 'SurveyController@generate_pdf');
    Route::get('survey/downloadexcel/{survey}', 'SurveyController@generate_excel');
    Route::get('survey/exam_answer/{answerid}/{user_id}', 'SurveyController@open_answer');
    Route::post('survey/sort/{survey}', 'SurveyController@sort_order');
    Route::get('survey/view/{survey}', 'SurveyController@view_survey')->name('view.survey');
    Route::get('survey/{survey}/delete', 'SurveyController@delete_survey')->name('delete.survey');
    Route::get('survey/answers/{survey}', 'SurveyController@view_survey_answers')->name('view.survey.answers');
    Route::get('survey/scores/{survey}', 'SurveyController@view_scores')->name('view.survey.scores');
    Route::get('survey/{survey}/{question?}', 'SurveyController@detail_survey')->name('detail.survey');

    Route::get('survey/{survey}/edit', 'SurveyController@edit')->name('edit.survey');
    Route::patch('survey/{survey}/update', 'SurveyController@update')->name('update.survey');
    Route::post('survey/view/{survey}/completed', 'AnswerController@store')->name('complete.survey');
    Route::post('survey/edit/{survey}/completed', 'AnswerController@update');
    Route::post('survey/create', 'SurveyController@create')->name('create.survey');
    Route::post('survey/{survey}/questions', 'QuestionController@store')->name('store.question');
    Route::get('question/{question}/edit', 'QuestionController@edit')->name('edit.question');
    Route::post('question/{question}/update', 'QuestionController@update')->name('update.question');
    Route::get('question/{question}/delete', 'QuestionController@delete_question')->name('delete.question');
    
    Route::get('eos/create', 'EosController@create');
    Route::get('eos', 'EosController@home');
    Route::post('eos/save', 'EosController@save');
    Route::get('eos/send/{id}', 'EosController@send');
//    Route::post('eos/send', 'EosController@send');
//    Route::get('eos/view', 'EosController@view');
    Route::get('eos/edit/{id}', 'EosController@edit');
//    Route::post('eos/update', 'EosController@update');
    
    Route::get('us/create', 'UsReportsController@create');
    Route::get('eos/report', 'EosController@reports');
    
//    test
//    Route::get('test_email', function(){
//        return \App\Employee::find(1424);
//    });    
//    
//    mail sending test route
//    Route::get('test_email', function(){
//      Mail::raw('test 2', function ($message) {
//        $message->from('ana.dellosa@1and1.com', 'Birthday Notifier');
//        $message->to('rworlds2010@gmail.com','reynan');
//    });
//    });
    
    //USSasLogger
    Route::post('uslogger/create', 'UsSasLoggerController@create');
    Route::get('uslogger/create', 'UsSasLoggerController@create');
    Route::post('uslogger/store', 'UsSasLoggerController@store');
    Route::get('uslogger', 'UsSasLoggerController@index');
    Route::post('uslogger', 'UsSasLoggerController@index');
    Route::get('uslogger/view/{id}', 'UsSasLoggerController@view');
    Route::get('uslogger/edit/{id}', 'UsSasLoggerController@editView');
    Route::post('uslogger/edit/{id}', 'UsSasLoggerController@edit');
    Route::get('uslogger/delete/{id}', 'UsSasLoggerController@delete');
    
    //Billing Outbound
    Route::get('billingoutbound/create', 'BillingOutboundController@createform');
    Route::post('billingoutbound/store', 'BillingOutboundController@store');
    Route::get('billingoutbound/edit/{id}', 'BillingOutboundController@retrieve');
    Route::post('billingoutbound/update/{id}', 'BillingOutboundController@update');
    Route::post('billingoutbound/search', 'BillingOutboundController@search');
    Route::post('billingoutbound/sort', 'BillingOutboundController@sort');
    Route::get('billingoutbound/cases', 'BillingOutboundController@index');
    
    //birthday card uploader
    Route::get('birthdaycard/upload', 'BirthdayUploadController@upload');
    Route::post('birthdaycard/file', 'BirthdayUploadController@file');
    
    //PointSystem
    
    Route::get('pointsystem/home', 'PointSystemController@home');
    Route::get('pointsystem/', 'PointSystemController@index');
    Route::get('pointsystem/edit/{personid}', 'PointSystemController@retrieve'); 
    Route::post('pointsystem/update/{personid}', 'PointSystemController@update');
});
