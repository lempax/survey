<?php
namespace App\Http\Controllers;

use App\RepairedItem;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Mail;
use Session;
use Auth;
use App\Employee as Employee;  

class RepairedItemController extends Controller {
    
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
            'name' => 'Repaired Items',
            'headers' => ['Request ID', 'Date', 'Name', 'Department', 'Action'],
            'headerStyle' => ['', '', '', '', ''],
            'data' => []
        ];

        $repaireditem = new RepairedItem();

        $data['rows'] = $repaireditem->get();
        $data['breakdown'] = $breakdown;
        $data['page_title'] = 'Repaired Items';
        $data['perfurl'] = 'repaireditem';
        $data['form_title'] = "Your cases for " . date("F j, Y");
        return view('repaireditem.RepairedItemView', $data);
    }
    
    public function store(Request $request) {
        $this->validate($request, [
            'description' => 'required',
            'brand' => 'required',
            'serial' => 'required',
            'defect' => 'required',
        ]);

        $description = $request->get('description');
        $brand = $request->get('brand');
        $serial = $request->get('serial');
        $defect = $request->get('defect');
        
        $insertData = array();
        for ($i = 0; $i < count($description); $i++) {
            $_description = $description[$i];
            $_brand = $brand[$i];
            $_serial = $serial[$i];
            $_defect = $defect[$i];
            
            $insertData[] = array(
                'description' => $_description,
                'brand' => $_brand,
                'serial' => $_serial,
                'defect' => $_defect
            );
            
        }
        $defect_json = json_encode($insertData);
        $new_array = array(
            'date' => date("Y-m-d"),
            'name' => $request->get('name'),
            'department' => $request->get('department'),
            'status' => $request->get('status'),
            'request_id' => $request->get('request_id'),
            'defect' => $defect_json
        );
        
            if(isset($_POST['save'])){
                RepairedItem::create($new_array);
            }
            if(isset($_POST['send'])){
            $data['date'] = $request->get('date');
            $data['name'] = Employee::where('uid', $request->get('name'))->first(); 
            $data['department'] = $request->get('department');
            $data['defect'] = $defect_json;
        
//            $user = Auth::user();
//            Mail::send('repaireditem.RepairedItemSendFile', $data, function ($message) use ($user) {
//                $message->from('no-reply@mis-ews.ph.schlund.net', 'MIS-EWS');
//                $message->to($user->superior->email, $user->superior->name)->subject('1&1 Repaired Item Tool');
//                $message->cc($user->email, $user->name);
//                $message->bcc('arjay.villanueva@1and1.com', 'Arjay Villanueva');
//            });
            }
            Session::flash('flash_message', 'Successfully Added!');
            return redirect('repaireditem/create');
    }
    public function edit($id) {

        $repaireditem = new RepairedItem();
        $breakdown = [
            'name' => 'Repaired Items',
            'headers' => ['Request ID', 'Date', 'Name', 'Department', 'Action'],
            'headerStyle' => ['', '', '', '', ''],
            'data' => []
        ];
        
        
        $data['temp'] = $repaireditem->where('id', $id)->first();
        $data['rows'] = $repaireditem->get();
        $data['breakdown'] = $breakdown;
        $data['page_title'] = 'Repaired Items';
        $data['perfurl'] = 'repaireditem';
        $data['form_title'] = "Your cases for " . date("F j, Y");
        return view('repaireditem.RepairedItemEdit', $data);
    }
    
    public function update(Request $request) {

        $this->validate($request, [
            'description' => 'required',
            'brand' => 'required',
            'serial' => 'required',
            'defect' => 'required',
        ]);
        
        $description = $request->get('description');
        $brand = $request->get('brand');
        $serial = $request->get('serial');
        $defect = $request->get('defect');

        $editData = array();
        for ($i = 0; $i < count($description); $i++) {
            $_description = $description[$i];
            $_brand = $brand[$i];
            $_serial = $serial[$i];
            $_defect = $defect[$i];
            
            $editData[] = array(
                'description' => $_description,
                'brand' => $_brand,
                'serial' => $_serial,
                'defect' => $_defect
            );
        }
        
        $defect_json = json_encode($editData);
        $update_array = array(
            'date' => date("Y-m-d"),
            'name' => $request->get('name'),
            'department' => $request->get('department'),
            'status' => $request->get('status'),
            'request_id' => $request->get('request_id'),
            'defect' => $defect_json
        );
            if(isset($_POST['save'])){
                $repaireditem = RepairedItem::find($request->get('id'));
                $repaireditem->update($update_array);
            }
            if(isset($_POST['update'])){    
            $data['id'] = $request->get('id');
            $data['date'] = $request->get('date');
            $data['name'] = $request->get('name');
            $data['department'] = $request->get('department');
            $data['request_id'] = $request->get('request_id');
            $data['defect'] = $defect_json;
            
      
//            $user = Auth::user();
//            Mail::send('repaireditem.RepairedItemSendFile', $data, function ($message) use ($user) {
//                $message->from('no-reply@mis-ews.ph.schlund.net', 'MIS-EWS');
//                $message->to($user->superior->email, $user->superior->name)->subject('1&1 Repaired Item Tool');
//                $message->cc($user->email, $user->name);
//                $message->bcc('arjay.villanueva@1and1.com', 'Arjay Villanueva');
//            });
             return view('repaireditem.RepairedItemSendFile',$data);
            }
            
            $repaireditem = RepairedItem::find($request->get('id'));
            $repaireditem->update($update_array);
            Session::flash('flash_message', 'Case successfully updated!');
            return redirect('repaireditem/create');
    }
}

