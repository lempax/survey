<?php
namespace App\Http\Controllers;

use App\ReturnedItem;
use App\ReturnedManufacturers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Mail;
use Session;
use Auth;
use DB;
use App\Employee as Employee;
use App\ItemInventory as Item;

class ReturnedItemController extends Controller {
    
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
            'name' => 'Returned Items',
            'headers' => ['Item', 'Serial', 'Employee Name', 'Date', 'Action'],
            'headerStyle' => ['', '', '', '', ''],
            'data' => []
        ];
        
        $breakdowns = [
            'name' => 'Returned Items',
            'headers' => ['ID', 'Name', 'Date'],
            'headerStyle' => ['', '', ''],
            'data' => []
        ];
        
        
        $returneditem = new ReturnedItem();
        $returnedmanufacturers = new ReturnedManufacturers();
        $data['rows'] = $returneditem->get();
        $data['categories'] = DB::table('item_categories')->get();
        $data['items'] = DB::table('items')->get();
        $data['serials'] = DB::table('item_serials')->get();
        $data['reman'] = $returnedmanufacturers->get();
        $data['breakdown'] = $breakdown;
        $data['breakdowns'] = $breakdowns;
        $data['page_title'] = 'Returned Items';
        $data['page_desc'] = 'Below are the following returned items';
        $data['perfurl'] = 'returneditem';
        $data['form_title'] = "Returned items for " . date("F j, Y");
        return view('returneditem.ReturnedItemView', $data);
    }

    public function store(Request $request) {
        
        $this->validate($request, [
            'item_id' => 'required',
            //'serial' => 'required',
            'condition' => 'required',
            'quantity' => 'required',
            'username' => 'required',
            'logged_by' => 'required'
        ]);
        
        $insertData = array(
                'cid' => $request->get('category'),
                'item_id' => $request->get('item_id'),
                'manufacturer' => $request->get('manufacturer'),
                'serial' => $request->get('serial'),
                'condition' => $request->get('condition'),
                'warranty' => $request->get('warranty'),
                'fixed' => $request->get('fixed'),
                'disposed' => $request->get('disposed'),
                'quantity' => $request->get('quantity'),
                'username' => $request->get('username'),
                'logged_by' => $request->get('logged_by'),
                'date' => strtotime($request->get('date'))
            );
            
            
                if(isset($_POST['save'])){
                    ReturnedItem::create($insertData);
                }
                if(isset($_POST['send'])){
                $data['id'] = $request->get('id');
                //$data['cid'] = $request->get('category'); 
                $data['item_id'] = $request->get('item_id');
                $data['serial'] = $request->get('serial');
                $data['condition'] = $request->get('condition');
                $data['warranty'] = $request->get('warranty');
                $data['manufacturer'] = $request->get('manufacturer');
                $data['fixed'] = $request->get('fixed_uw');
                $data['fixed'] = $request->get('fixed');
                $data['disposed'] = $request->get('disposed');
                $data['quantity'] = $request->get('quantity');
                $data['username'] = Employee::where('uid', $request->get('username'))->first(); 
                $data['logged_by'] = $request->get('logged_by');

//            $user = Auth::user();
//            Mail::send('returneditem.ReturnedItemSendFile', $data, function ($message) use ($user) {
//                $message->from('no-reply@mis-ews.ph.schlund.net', '1&1 Returned Item Tool');
//                $message->to('sarahmae.navales@1and1.com')->subject('1&1 Returned Item Tool');
////                $message->cc($user->email, $user->name);
////                $message->bcc('arjay.villanueva@1and1.com', 'Arjay Villanueva');
//            });
                
                return view('returneditem.ReturnedItemSendFile',$data);
                }
                     
            Session::flash('flash_message', 'Successfully Added!');
            return redirect('returneditem/create');
            
    }

    public function edit($id, Request $request) {

        $returneditem = new ReturnedItem();
        $returnedmanufacturers = new ReturnedManufacturers();
        $breakdown = [
            'name' => 'Returned Items',
            'headers' => ['Item', 'Serial', 'Employee Name', 'Date', 'Action'],
            'headerStyle' => ['', '', '', '', ''],
            'data' => []
        ];
        
        $breakdowns = [
            'name' => 'Returned Items',
            'headers' => ['ID', 'Name', 'Date'],
            'headerStyle' => ['', '', ''],
            'data' => []
        ];

        $data['temp'] = $returneditem->where('id', $id)->first();
        $data['rows'] = $returneditem->get();
        $data['reman'] = $returnedmanufacturers->get();
        $data['categories'] = DB::table('item_categories')->get();
        $data['items'] = DB::table('items')->get();
        $data['serials'] = DB::table('item_serials')->get();
        $data['breakdown'] = $breakdown;
        $data['breakdowns'] = $breakdowns;
        $data['page_title'] = 'Returned Items';
        $data['page_desc'] = 'Below are the following returned items';
        $data['perfurl'] = 'returneditem';
        $data['form_title'] = "Returned items for " . date("F j, Y");
        return view('returneditem.ReturnedItemEdit', $data);
    }

    public function update(Request $request) {
        
        $this->validate($request, [
            'item_id' => 'required',
            'condition' => 'required',
            'quantity' => 'required',
            'username' => 'required',
            'logged_by' => 'required'
        ]);
        
        $updateData = array(
            'cid' => $request->get('category'),
            'item_id' => $request->get('item_id'),
            'serial' => $request->get('serial'),
            'condition' => $request->get('condition'),
            'warranty' => $request->get('warranty'),
            'manufacturer' => $request->get('manufacturer'),
            'fixed' => $request->get('fixed'),
            'disposed' => $request->get('disposed'),
            'quantity' => $request->get('quantity'),
            'username' => $request->get('username'),
            'logged_by' => $request->get('logged_by'),
            'date' => strtotime($request->get('date'))            
        );
        
            if(isset($_POST['save'])){
                $returneditem = ReturnedItem::find($request->get('id'));
                $returneditem->update($updateData);
            }
            
            if(isset($_POST['send'])){    
            $data['id'] = $request->get('id');
            //$data['cid'] = $request->get('category');
            $data['logged_by'] = $request->get('logged_by');
            $data['item_id'] = $request->get('item_id');
            $data['serial'] = $request->get('serial');
            $data['condition'] = $request->get('condition');
            $data['warranty'] = $request->get('warranty');
            $data['manufacturer'] = $request->get('manufacturer');
            $data['fixed'] = $request->get('fixed_uw');
            $data['fixed'] = $request->get('fixed');
            $data['disposed'] = $request->get('disposed');
            $data['quantity'] = $request->get('quantity');
            $data['username'] = Employee::where('uid', $request->get('username'))->first(); 
            
       
//            $user = Auth::user();
//            Mail::send('returneditem.ReturnedItemSendFile', $data, function ($message) use ($user) {
//                $message->from('no-reply@mis-ews.ph.schlund.net', '1&1 Returned Item Tool');
//                $message->to('sarahmae.navales@1and1.com')->subject('1&1 Returned Item Tool');
////                $message->cc($user->email, $user->name);
////                $message->bcc('arjay.villanueva@1and1.com', 'Arjay Villanueva');
//            });
            return view('returneditem.ReturnedItemSendFile',$data);
            }
            $returneditem = ReturnedItem::find($request->get('id'));
            $returneditem->update($updateData);
            Session::flash('flash_message', 'Case successfully updated!');
            return redirect('returneditem/create');
    }
    
    public function mstore(Request $request) {
        
        $breakdowns = [
            'name' => 'Returned Items',
            'headers' => ['ID', 'Name', 'Date'],
            'headerStyle' => ['', '', ''],
            'data' => []
        ];
        
        
        $mData = array(
                'name' => $request->get('name'),
                'date' => strtotime($request->get('date')),
                'manufacturer_id' => $request->get('manufacturer_id'),
            );
        
//      $user = Auth::user();
//      Mail::send('returneditem.ReturnedManufacturersSendFile', $data, function ($message) use ($user) {
//        $message->from('no-reply@mis-ews.ph.schlund.net', '1&1 Returned Manufacturers Tool');
//        $message->to('sarahmae.navales@1and1.com')->subject('1&1 Returned Manufacturers');
////      $message->cc($user->email, $user->name);
////      $message->bcc('arjay.villanueva@1and1.com', 'Arjay Villanueva');
//      });
        //return view('returneditem.ReturnedManufacturersSendFile',$data);
        
        ReturnedManufacturers::create($mData);
        $returneditem = new ReturnedItem();
        $returnedmanufacturers = new ReturnedManufacturers();
        $data['reman'] = $returnedmanufacturers->get();
        $data['rows'] = $returneditem->get();
        $data['breakdowns'] = $breakdowns;
        return redirect('returneditem/create');
    }
    
     public function get_item($cid) {
        $items = \App\ReturnedItem::getItemsFromCategories($cid);
        
        echo '<select id="itemss" type="text" name="item_id" style="width: 350px; margin-left: 15px;" class="form-control">';
        echo '<option value="">Select Item</option>';
        
        foreach ($items as $item) {
            echo '<option value="' . $item->id . '">' . $item->name . '</option>';
        }
        echo '</select>';
    }
    
    public function get_serial($item_id) {
        $serials = \App\ReturnedItem::getSerialsFromItems($item_id);

        echo '<select id="serial" type="text" name="serial" style="width: 350px; margin-left: 15px;" class="form-control">';
        echo '<option value="">Select Serial</option>';
        
        foreach ($serials as $serial) {
            echo '<option value="' . $serial->serial . '">' . $serial->serial . '</option>';
        }
        echo '</select>';
    }

}