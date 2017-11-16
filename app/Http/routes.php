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
    Route::get('/home', 'HomeController@index');
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
