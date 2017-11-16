<?php

namespace App\Http\Controllers;

use App\PDF_file;
use App\Categories;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Response;
use Session;
use Auth;
use DB;
use App\Employee as Employee;


class PDFfileController extends Controller {
    
    public function __construct() {
        $this->middleware('auth');
        if (Auth::check()) {
            $_team = Auth::user()->teams();
            if ($_team->count() == 1 && $_team->first()->departmentid = 21395000)
                $this->teams = \App\Department::where('name', 'like', 'U%')->get();
            else
                $this->teams = Auth::user()->teams();
                $this->exemptions = Auth::user()->settings()->type('filtered_list')->first() ?
                    json_decode(Auth::user()->settings()->type('filtered_list')->first()->entries) : [];
        }
    }
    
    public function create() {

        $breakdown = [
            'name' => 'Posting of Processes/Guidelines',
            'headers' => ['DOWNLOAD PDF FILE', 'ACTION'],
            'headerStyle' => ['', ''],
            'data' => []
        ];

        $pdf_file = new PDF_file();
        $data['rows'] = $pdf_file->get();
        $data['breakdown'] = $breakdown;
        $data['page_title'] = 'Posting of Processes/Guidelines';
        $data['perfurl'] = 'pdf_file';
        $data['form_title'] = "Your cases for " . date("F j, Y");
        return view('pdf_file.ProcessesGuidelinesView', $data);
    }
    
    public function store(Request $request) {
        
        $this->validate($request, [
            'pdf_name' => 'required',
            'pdf_title' => 'required',
            'type' => 'required'
        ]);
        
        $file = $request->file('pdf_name');
        $destinationPath = resource_path(). '/file_attachments/';
        $filename = $file->getClientOriginalName();
        $request->file('pdf_name')->move($destinationPath, $filename);
        
        $insertData = array(
                'pdf_name' => $filename,
                'pdf_title' => $request->get('pdf_title'),
                'uploader' => $request->get('uploader'),
                'type' => $request->get('type'),
                'date_uploaded' => date("Y-m-d")
            );
            
            PDF_file::create($insertData);        
            Session::flash('flash_message', 'Successfully Added!');
            return redirect('posting/create');
            
    }
    
    public function edit($pdf_id){
            
         $breakdown = [
            'name' => 'Posting of Processes/Guidelines',
            'headers' => ['DOWNLOAD PDF FILE', 'ACTION'],
            'headerStyle' => ['', ''],
            'data' => []
        ];
         
        $pdf_file = new PDF_file();
        $data['temp'] = $pdf_file->where('pdf_id', $pdf_id)->first();
        $data['rows'] = $pdf_file->get();
        $data['breakdown'] = $breakdown;
        $data['page_title'] = 'Posting of Processes/Guidelines';
        $data['perfurl'] = 'pdf_file';
        $data['form_title'] = "Your cases for " . date("F j, Y");
        return view('pdf_file.ProcessesGuidelinesEdit', $data);

    }
    
    public function update(Request $request) {
        
        $this->validate($request, [
            'pdf_title' => 'required',
            'type' => 'required'
        ]);
        
        if ($request->hasFile('pdf_name')) {
            $file = $request->file('pdf_name');
            $destinationPath = resource_path(). '/file_attachments/';
            $filename = $file->getClientOriginalName();
            $request->file('pdf_name')->move($destinationPath, $filename);
            
            $updateData = array(
            'pdf_name' => $filename,
            'pdf_title' => $request->get('pdf_title'),
            'uploader' => $request->get('uploader'),
            'type' => $request->get('type'),
            'date_uploaded' => date("Y-m-d")       
        );
        
        if(isset($_POST['send'])){
            $pdf_file= PDF_file::find($request->get('pdf_id'));
            $pdf_file->update($updateData);
        }
        
        }
        Session::flash('flash_message', 'Case successfully updated!');
        return redirect('posting/create');
    }
    
    public function cStore(Request $request) {
        
        $breakdowns = [
            'name' => 'Posting of Processes/Guidelines',
            'headers' => ['DOWNLOAD PDF FILE', 'ACTION'],
            'headerStyle' => ['', ''],
            'data' => []
        ];
       
        $category = array(
                'category_name' => $request->get('category_name')
            );
        
//      $user = Auth::user();
//      Mail::send('returneditem.ReturnedManufacturersSendFile', $data, function ($message) use ($user) {
//        $message->from('no-reply@mis-ews.ph.schlund.net', '1&1 Returned Manufacturers Tool');
//        $message->to('sarahmae.navales@1and1.com')->subject('1&1 Returned Manufacturers');
////      $message->cc($user->email, $user->name);
////      $message->bcc('arjay.villanueva@1and1.com', 'Arjay Villanueva');
//      });
        
        Categories::create($category);
        $Categories = new Categories();
        $PDF_file = new PDF_file();
        $data['rows'] = $PDF_file->get();
        $data['cat'] = $Categories->get();
        $data['breakdowns'] = $breakdowns;
        return redirect('posting/create');
    }
    
    public function getDownload($pdf_name){
        
        $file_path = resource_path('file_attachments/'.$pdf_name);
        $headers = array(
            'Content-Type: application/pdf',
        );
        return response()->download($file_path, $pdf_name, $headers);
    }
    
    public function delete($pdf_id){
        
        DB::table('pdf_file')->where('pdf_id','=', $pdf_id)->delete();
        
        Session::flash('flash_message', 'Task successfully deleted!');
        return redirect('posting/create');
    }

}    

